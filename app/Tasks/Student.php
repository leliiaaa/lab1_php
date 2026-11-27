<?php

declare(strict_types=1);

namespace App\Tasks;

class Student extends Person
{
    public function __construct(
        string $name,
        protected string $group
    ) {
        parent::__construct($name);
    }

    public function getRoleDetails(): string
    {
        return "Персона: {$this->name} | Студент групи {$this->group}";
    }
}
