<?php

declare(strict_types=1);

namespace App\Tasks;

class Book
{
    /**
     * @param  array<int, string>  $authors
     */
    public function __construct(
        public int $id,
        public string $title,
        public array $authors,
        public int $pubYear
    ) {}

    public function getInfo(): string
    {
        $authorsList = implode(', ', $this->authors);

        return "#{$this->id} «{$this->title}» — {$authorsList} ({$this->pubYear})";
    }
}
