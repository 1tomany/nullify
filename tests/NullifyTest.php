<?php

namespace OneToMany\Nullify\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[Group('UnitTests')]
final class NullifyTest extends TestCase
{
    #[DataProvider('providerStringAndNullifiedValue')]
    public function testNullifyingString(
        string|\Stringable|null $string,
        ?string $nullifiedValue,
    ): void {
        $this->assertSame($nullifiedValue, nullify($string));
    }

    public static function providerStringAndNullifiedValue(): array
    {
        $provider = [
            [null, null],
        ];

        return $provider;
    }
}
