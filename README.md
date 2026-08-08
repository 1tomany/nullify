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

Dealing with

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
| `' PHP '`  | `true`  |   `'PHP'`   |
| `' PHP '`  | `false` |  `' PHP '`  |
| `' PHP '`  | `false` |  `' PHP '`  |
| `' 🐘🎉 '` | `true`  |  `'🐘🎉'`   |

## Credits

- [Vic Cherubini](https://github.com/viccherubini), [1:N Labs, LLC](https://1tomany.com)

## License

The MIT License
