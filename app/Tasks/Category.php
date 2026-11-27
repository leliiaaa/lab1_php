<?php

declare(strict_types=1);

namespace App\Tasks;

class Category
{
    /**
     * @param  array<int, Book>  $books
     */
    public function __construct(
        public int $category_id,
        public string $name,
        private array $books = []
    ) {}

    public function addBook(Book $book): void
    {
        $this->books[$book->id] = $book;
    }

    public function removeBook(int $id): bool
    {
        if (! isset($this->books[$id])) {
            return false;
        }

        unset($this->books[$id]);

        return true;
    }

    /**
     * @return array<int, Book>
     */
    public function searchBook(string $query): array
    {
        return array_values(array_filter(
            $this->books,
            static fn (Book $book): bool => stripos($book->title, $query) !== false
        ));
    }

    /**
     * @return array<int, Book>
     */
    public function getBooks(): array
    {
        return array_values($this->books);
    }
}
