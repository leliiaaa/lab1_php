<?php

declare(strict_types=1);

namespace App\Tasks;

class Teacher extends Student
{
    public function __construct(
        string $name,
        string $group,
        protected string $subject
    ) {
        parent::__construct($name, $group);
    }

    public function getRoleDetails(): string
    {
        return parent::getRoleDetails()." | Викладач дисципліни «{$this->subject}»";
    }
}
