<?php

namespace OneToMany\Nullify\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[Group('UnitTests')]
final class NullifyTest extends TestCase
{
    #[DataProvider('providerStringTrimAndOutput')]
    public function testNullifyingString(
        string|\Stringable|null $string,
        bool $trim,
        ?string $output,
    ): void {
        $this->assertSame($output, nullify($string, $trim));
    }

    public static function providerStringTrimAndOutput(): \Generator
    {
        yield [null, true, null];
        yield [null, false, null];
        yield ['', true, null];
        yield ['', false, null];
        yield [' ', true, null];
        yield [' ', false, ' '];
        yield ['  ', true, null];
        yield ['0', true, '0'];
        yield ['0', false, '0'];
        yield [' 0 ', true, '0'];
        yield [' 0 ', false, ' 0 '];
        yield ['a', true, 'a'];
        yield ['Z', true, 'Z'];
        yield [' Z ', true, 'Z'];
        yield [' Z ', false, ' Z '];
        yield ['न', true, 'न'];
        yield ['न ', true, 'न'];
        yield ['न ', false, 'न '];
        yield ['न ', false, 'न '];
        yield [' さよなら ', true, 'さよなら'];
        yield [' 🐘🎉 ', true, '🐘🎉'];

        $stringable = new class(' test ') implements \Stringable {
            public function __construct(
                private string $value,
            ) {
            }

            /**
             * @see \Stringable
             */
            #[\Override]
            public function __toString(): string
            {
                return $this->value;
            }
        };

        yield [$stringable, true, 'test'];
    }

    public function testNullifyReturnsNullOrNonEmptyString(): void
    {
        $name = \Faker\Factory::create()->name();

        $person = new class($name) {
            /**
             * @var ?non-empty-string
             */
            private ?string $name;

            public function __construct(
                ?string $name = null,
            ) {
                $this->setName($name);
            }

            /**
             * @return ?non-empty-string
             */
            public function getName(): ?string
            {
                return $this->name;
            }

            public function setName(?string $name): static
            {
                $this->name = nullify($name);

                return $this;
            }
        };

        $this->assertSame($name, $person->getName());
    }
}
