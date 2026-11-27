<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\LoggerInterface;
use App\Models\AbstractEntity;
use Exception;

class EntityService
{
    public function __construct(
        private LoggerInterface $logger
    ) {}

    public function registerEntity(AbstractEntity $entity): void
    {
        $this->logger->log('Опрацьовано сутність: '.$entity->getDetails());
    }
}

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
