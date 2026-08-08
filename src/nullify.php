<?php

use Symfony\Component\String\Exception\ExceptionInterface;

use function Symfony\Component\String\u;

if (!function_exists('nullify')) {
    function nullify(
        string|Stringable|null $string,
        bool $trim = true,
    ): ?string {
        if (null === $string) {
            return $string;
        }

        if ($string instanceof Stringable) {
            $string = $string->__toString();
        }

        try {
            $us = u($string);
        } catch (ExceptionInterface) {
            return null;
        }

        if (true === $trim) {
            $us = $us->trim();
        }

        return $us->isEmpty() ? null : $us->toString();
    }
}
