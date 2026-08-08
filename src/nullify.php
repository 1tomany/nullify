<?php

use Symfony\Component\String\Exception\ExceptionInterface as StringExceptionInterface;

use function Symfony\Component\String\s;

if (!function_exists('nullify')) {
    /**
     * @return ?string
     */
    function nullify(
        string|Stringable|null $string,
        bool $trim = true,
    ): ?string {
        if (null === $string) {
            return $string;
        }

        try {
            $s = s((string) $string);
        } catch (StringExceptionInterface) {
            return null;
        }

        if (true === $trim) {
            $s = $s->trim();
        }

        return $s->isEmpty() ? null : $s->toString();
    }
}
