<?php

declare(strict_types=1);

namespace App\Models;

class User extends AbstractEntity
{
    public function __construct(
        string $id,
        string $createdAt,
        private string $name,
        private string $email,
        private string $city
    ) {
        parent::__construct($id, $createdAt);
    }

    public function getDetails(): string
    {
        return "Читач #{$this->id}: {$this->name} ({$this->email}), м. {$this->city}, зареєстрований {$this->createdAt}";
    }
}
