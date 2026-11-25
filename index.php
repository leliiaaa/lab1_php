<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';
require_once 'app/Services/EntityService.php';
require_once 'app/Services/DataProcessor.php';

use App\Services;
use Faker\Factory;

$faker = Factory::create('uk_UA');

// 10 випадкових років видання книг та фільтрація через анонімну функцію з use
$publishYears = [];
for ($i = 0; $i < 10; $i++) {
    $publishYears[] = $faker->numberBetween(1980, 2025);
}

$minPublishYear = 2015;
$filteredYears = array_values(array_filter(
    $publishYears,
    static function (int $year) use ($minPublishYear): bool {
        return $year >= $minPublishYear;
    }
));

// Типізована функція підрахунку обмінів
$totalExchanges = Services\countExchanges(12, 3);

// Обробка винятку applyDiscount через try-catch-finally
$discountError = '';
$discountFinally = '';
try {
    Services\applyDiscount(500.0, 150.0);
} catch (Exception $e) {
    $discountError = 'Помилка: '.$e->getMessage();
} finally {
    $discountFinally = 'Завершення спроби розрахунку.';
}

// Три алгоритмічні задачі (змінні замість вводу з клавіатури)
$shiftedNumbers = Services\shiftArrayRight([1, 2, 3, 4, 5]);
$shortWords = Services\filterShortWords('Книга обмін полиця читач бібліотека дім', 5);
$digitsFirstResult = Services\moveDigitsFirst('book2026swap99');
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>BookSwap — Лабораторна робота №3</title>
</head>
<body>
    <h1>BookSwap — Результати виконання скриптів</h1>

    <h2>Обміни читача</h2>
    <p>Було 12 обмінів, додалося 3. Стало <?= $totalExchanges ?>.</p>

    <h2>Роки видання книг, не менші за <?= $minPublishYear ?></h2>
    <p>Усі згенеровані роки: <?= implode(', ', $publishYears) ?></p>
    <ul>
        <?php foreach ($filteredYears as $year) { ?>
            <li><?= $year ?></li>
        <?php } ?>
    </ul>

    <h2>Знижка</h2>
    <p><?= htmlspecialchars($discountError, ENT_QUOTES, 'UTF-8') ?></p>
    <p><?= htmlspecialchars($discountFinally, ENT_QUOTES, 'UTF-8') ?></p>

    <h2>Зсув масиву вправо</h2>
    <p>Вхід: 1 2 3 4 5</p>
    <p>Результат: <?= implode(' ', $shiftedNumbers) ?></p>

    <h2>Слова довжиною до 5 символів</h2>
    <p>Текст: Книга обмін полиця читач бібліотека дім</p>
    <p>Результат: <?= implode(', ', $shortWords) ?></p>

    <h2>Цифри на початку рядка</h2>
    <p>Вхід: book2026swap99</p>
    <p>Результат: <?= htmlspecialchars($digitsFirstResult, ENT_QUOTES, 'UTF-8') ?></p>
</body>
</html>