<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';
require_once 'app/Services/EntityService.php';
require_once 'app/Services/DataProcessor.php';

use App\Core\Database;
use App\Core\EntityFactory;
use App\Models\Book;
use App\Services;
use App\Services\ConsoleLogger;
use App\Services\EntityService;
use App\Services\FileLogger;
use App\Tasks\Book as TaskBook;
use App\Tasks\Category;
use App\Tasks\DepartmentHead;
use App\Tasks\Student;
use App\Tasks\Teacher;
use App\Tasks\Triangle;
use Faker\Factory;

$faker = Factory::create('uk_UA');

// --- ЛАБОРАТОРНА РОБОТА №3 ---

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

// --- ООП та патерни (лаб4)---

// 1. Singleton (Database)
ob_start();
$db1 = Database::getInstance();
$db2 = Database::getInstance();
$dbOutput = trim((string) ob_get_clean());
$isSameDb = $db1 === $db2 ? 'Так' : 'Ні';

// 2. Factory Method
$book = EntityFactory::createEntity('book', [
    'id' => '101',
    'createdAt' => '2026-11-26',
    'title' => 'Кобзар',
    'author' => 'Тарас Шевченко',
    'isbn' => '978-966-01-0589-8',
]);

$user = EntityFactory::createEntity('user', [
    'id' => '7',
    'createdAt' => '2026-11-20',
    'name' => 'Лілія Булатова',
    'email' => 'bulatova.liliya2308@gmail.com',
    'city' => 'Івано-Франківськ',
]);

// 3. Інтерфейс та Трейт (JSON-експорт)
$bookJson = $book instanceof Book ? $book->exportToJson() : '';

// 4. Dependency Injection (EntityService + Loggers)
ob_start();
$consoleService = new EntityService(new ConsoleLogger);
$consoleService->registerEntity($book);

$fileService = new EntityService(new FileLogger);
$fileService->registerEntity($user);
$logsOutput = trim((string) ob_get_clean());

// --- Індив. задачі (лаб 4) варіант 4 ---

// 6.1 Композиція: Book та Category
$category = new Category(1, 'Українська класика');
$category->addBook(new TaskBook(1, 'Кобзар', ['Тарас Шевченко'], 1840));
$category->addBook(new TaskBook(2, 'Тигролови', ['Іван Багряний'], 1944));
$category->addBook(new TaskBook(3, 'Тіні забутих предків', ['Михайло Коцюбинський'], 1911));
$foundBooks = $category->searchBook('Кобзар');
$category->removeBook(2);

// 6.2 Ієрархія: Персона -> Студент -> Викладач -> Завідувач кафедри
$people = [
    new Student('Лілія Булатова', 'КН-41'),
    new Teacher('Іван Петренко', 'КН-41', 'Веб-програмування'),
    new DepartmentHead('Олександр Коваленко', 'КН-41', 'Архітектура ПЗ', 'Комп’ютерні науки'),
];

// 6.3 Трикутник (сторони 3, 4, 5)
$triangle = new Triangle(3.0, 4.0, 5.0);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>BookSwap</title>
</head>
<body>
    <h1>BookSwap — Лабораторна робота №4 (ООП та патерни)</h1>

    <h2>1. Singleton (Database)</h2>
    <p><?= htmlspecialchars($dbOutput, ENT_QUOTES, 'UTF-8') ?></p>
    <p>Один і той самий екземпляр БД: <?= $isSameDb ?></p>

    <h2>2. Factory Method та Наслідування</h2>
    <p><?= htmlspecialchars($book->getDetails(), ENT_QUOTES, 'UTF-8') ?></p>
    <p><?= htmlspecialchars($user->getDetails(), ENT_QUOTES, 'UTF-8') ?></p>

    <h2>3. Інтерфейс та Трейт (Експорт у JSON)</h2>
    <pre><?= htmlspecialchars($bookJson, ENT_QUOTES, 'UTF-8') ?></pre>

    <h2>4. Dependency Injection (EntityService + Логери)</h2>
    <pre><?= htmlspecialchars($logsOutput, ENT_QUOTES, 'UTF-8') ?></pre>

    <h2>5. Індивідуальне завдання</h2>

    <h3>Категорія «<?= htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8') ?>» (після видалення книги #2)</h3>
    <ul>
        <?php foreach ($category->getBooks() as $taskBook) { ?>
            <li><?= htmlspecialchars($taskBook->getInfo(), ENT_QUOTES, 'UTF-8') ?></li>
        <?php } ?>
    </ul>
    <p>Пошук «Кобзар»: знайдено <?= count($foundBooks) ?> (<?= htmlspecialchars($foundBooks[0]->getInfo(), ENT_QUOTES, 'UTF-8') ?>)</p>

    <h3>Ієрархія ролей (Персона -> Студент -> Викладач -> Завідувач кафедри)</h3>
    <ul>
        <?php foreach ($people as $person) { ?>
            <li><?= htmlspecialchars($person->getRoleDetails(), ENT_QUOTES, 'UTF-8') ?></li>
        <?php } ?>
    </ul>

    <h3>Трикутник (<?= $triangle->a ?>, <?= $triangle->b ?>, <?= $triangle->c ?>)</h3>
    <p>Периметр: <?= $triangle->getPerimeter() ?>, Площа (за Героном): <?= $triangle->getArea() ?></p>

    <hr>

    <h1>BookSwap — Результати виконання скриптів (ЛР №3)</h1>

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