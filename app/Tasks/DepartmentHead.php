<?php

declare(strict_types=1);

namespace App\Tasks;

class DepartmentHead extends Teacher
{
    public function __construct(
        string $name,
        string $group,
        string $subject,
        protected string $department
    ) {
        parent::__construct($name, $group, $subject);
    }

    public function getRoleDetails(): string
    {
        return parent::getRoleDetails()." | Завідувач кафедри «{$this->department}»";
    }
}
