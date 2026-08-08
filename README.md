# String Nullifier for PHP

This simple library exposes a single function named `nullify()` in the global namespace. By default, the function trims the string passed into it and returns `null` if the trimmed value is an empty string, or the trimmed string otherwise.

## Installation

```
composer require 1tomany/nullify
```

## Usage

The `nullify()` function has the following signature:

```php
nullify(string|\Stringable|null $string, bool $trim = true): ?string;
```

If the `$trim` argument is set to `false`, the string is not trimmed. An empty string will still return `null`, otherwise, the original string is returned. If an object implementing `\Stringable` is passed in, the object will be converted to a `string` first.

## Purpose

Dealing with falsy and empty values in PHP has always been a challenge. If you've used the language long enough, you've probably been bitten by `empty('0')` returning `true` even though the string `'0'` clearly isn't empty. My preference is to typehint strings as `non-empty-string|null` to clearly indicate what kinds of values that variable holds.

Take the following basic DTO as an example:

```php
final readonly class Person
{
    public function __construct(
        private ?string $name,
    ) {
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
```

Because of the ambiguity of the `$name` property, it's cumbersome to determine if it is empty or not:

```php
$person = new Person('     ');

if (null === $person->getName() || '' === trim($person->getName())) {
    throw new \InvalidArgumentException('Please enter a name.');
}
```

For all practical purposes, `$name` is empty, but determining that is cumbersome.

A much clearer DTO would be written like this:

```php
final readonly class Person
{
    /**
     * @var ?non-empty-string
     */
    private ?string $name;

    public function __construct(
        ?string $name,
    ) {
        $this->name = nullify($name);
    }

    /**
     * @return ?non-empty-string
     */
    public function getName(): ?string
    {
        return $this->name;
    }
}
```

It's immediately clear what data `$name` holds, and testing if `$name` is empty or not is a cinch:

```php
$person = new Person('     ');

if (null === $person->getName()) {
    throw new \InvalidArgumentException('Please enter a name.');
}
```

These are also clear because `nullify()` has removed any ambiguity around falsy or empty values:

```php
if (!$person->getName()) {
}

if (empty($person->getName())) {
}
```

## Examples

| `$string`  | `$trim` | `nullify()` |
| :--------: | :-----: | :---------: |
|   `null`   | `true`  |   `null`    |
|    `''`    | `true`  |   `null`    |
|    `''`    | `false` |   `null`    |
|   `' '`    | `true`  |   `null`    |
|   `' '`    | `false` |    `' '`    |
|   `'0'`    | `true`  |    `'0'`    |
|   `'0'`    | `false` |    `'0'`    |
|  `' 0 '`   | `true`  |    `'0'`    |
|  `' 0 '`   | `false` |   `' 0 '`   |
| `' PHP '`  | `true`  |   `'PHP'`   |
| `' PHP '`  | `false` |  `' PHP '`  |
| `' 🐘🎉 '` | `true`  |  `'🐘🎉'`   |

## Credits

- [Vic Cherubini](https://github.com/viccherubini), [1:N Labs, LLC](https://1tomany.com)

## License

The MIT License
