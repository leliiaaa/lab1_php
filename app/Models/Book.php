<?php

declare(strict_types=1);

namespace App\Models;

use App\Interfaces\ExportableInterface;
use App\Traits\JsonExportTrait;

class Book extends AbstractEntity implements ExportableInterface
{
    use JsonExportTrait;

    public function __construct(
        string $id,
        string $createdAt,
        private string $title,
        private string $author,
        private string $isbn
    ) {
        parent::__construct($id, $createdAt);
    }

    public function getDetails(): string
    {
        return "Книга #{$this->id}: «{$this->title}» — {$this->author} (ISBN: {$this->isbn}), додано {$this->createdAt}";
    }
}
