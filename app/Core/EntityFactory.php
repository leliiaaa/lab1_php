<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\AbstractEntity;
use App\Models\Book;
use App\Models\User;
use InvalidArgumentException;

class EntityFactory
{
    /**
     * @param  array<string, string>  $data
     */
    public static function createEntity(string $type, array $data): AbstractEntity
    {
        return match ($type) {
            'book' => new Book(
                $data['id'] ?? '0',
                $data['createdAt'] ?? date('Y-m-d'),
                $data['title'] ?? 'Без назви',
                $data['author'] ?? 'Невідомий автор',
                $data['isbn'] ?? '000-0-00-000000-0'
            ),
            'user' => new User(
                $data['id'] ?? '0',
                $data['createdAt'] ?? date('Y-m-d'),
                $data['name'] ?? 'Анонім',
                $data['email'] ?? 'user@bookswap.ua',
                $data['city'] ?? 'Івано-Франківськ'
            ),
            default => throw new InvalidArgumentException("Невідомий тип сутності: {$type}"),
        };
    }
}
