<?php

declare(strict_types=1);

$bookGenres = [
    'Фантастика',
    'Детектив',
    'Класика',
    'Психологія',
    'Сучасна проза',
];
sort($bookGenres);

$bookCopy = [
    'id' => 101,
    'bookId' => 15,
    'ownerId' => 7,
    'condition' => 'Відмінний',
    'status' => 'available',
];
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>BookSwap — Масиви примірника книги і жанрів</title>
</head>
<body>
    <h2>Індексний масив жанрів книг</h2>
    <ul>
        <?php foreach ($bookGenres as $genre): ?>
            <li><?= htmlspecialchars($genre, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Асоціативний масив примірника книги (BookCopy)</h2>
    <ul>
        <?php foreach ($bookCopy as $key => $value): ?>
            <li><strong><?= htmlspecialchars((string) $key, ENT_QUOTES, 'UTF-8') ?>:</strong> <?= htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>