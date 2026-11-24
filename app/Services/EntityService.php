<?php

declare(strict_types=1);

namespace App\Services;

use Exception;

function countExchanges(int $completedExchanges, int $addedExchanges): int
{
    return $completedExchanges + $addedExchanges;
}

function applyDiscount(float $price, float $discount): float
{
    if ($discount < 0.0 || $discount > 100.0) {
        throw new Exception('Неприпустиме значення знижки!');
    }

    return round($price - ($price * ($discount / 100.0)), 2);
}