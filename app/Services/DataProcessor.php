<?php

declare(strict_types=1);

namespace App\Services;

function shiftArrayRight(array $numbers): array
{
    if ($numbers === []) {
        return [];
    }

    $last = array_pop($numbers);
    array_unshift($numbers, $last);

    return array_map(static fn ($item): int => (int) $item, $numbers);
}

function filterShortWords(string $text, int $maxLength = 5): array
{
    $words = preg_split('/\s+/u', trim($text), -1, PREG_SPLIT_NO_EMPTY) ?: [];

    return array_values(array_filter(
        $words,
        static function (string $word) use ($maxLength): bool {
            $length = preg_match_all('/./u', $word);

            return ($length ?: 0) <= $maxLength;
        }
    ));
}

function moveDigitsFirst(string $input): string
{
    $chars = preg_split('//u', $input, -1, PREG_SPLIT_NO_EMPTY) ?: [];
    $digits = array_filter($chars, static fn (string $ch): bool => ctype_digit($ch));
    $others = array_filter($chars, static fn (string $ch): bool => !ctype_digit($ch));

    return implode('', [...$digits, ...$others]);
}