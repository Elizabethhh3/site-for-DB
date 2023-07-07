<html>
<head>
    <meta charset="UTF-8">
    <title>Ремонт</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div class="navbar">
    <span class="logo">catPhone</span>
    <a href="index.php">На головну</a>
    <a href="sample.php">ТОП-10</a>
    <a href="zvit.html">Звіти</a>
    <a href="clients.php">Клієнти</a>
    <a href="products.php">Товари</a>
    <a href="orders.php">Замовлення</a>
    <a href="repair.php">Ремонт</a>
    <a href="employee.php">Працівники</a>
</div>
<div class="content">
    <h1 style="font-size: 22px;">Вибірка: ТОП-10 найпопулярніших товарів у нашому магазині!</h1>
<?php
// З'єднання з базою даних
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "enterprise";

// Підключення до бази даних
$conn = new mysqli($servername, $username, $password, $dbname);

// Перевірка підключення до бази даних
if ($conn->connect_error) {
    die("Помилка підключення до бази даних: " . $conn->connect_error);
}

// SQL-запит для вибірки топ 10 найбільш популярних телефонів
$sql = "SELECT p.manufacturer, p.model, COUNT(o.id_product) as purchase_count
        FROM orders o
        JOIN products p ON o.id_product = p.id_product
        GROUP BY o.id_product
        ORDER BY purchase_count DESC
        LIMIT 10";

$result = $conn->query($sql);

// Перевірка результату запиту
if ($result->num_rows > 0) {
    // Виведення результатів
    echo "<table>";
    echo "<tr><th>Виробник</th><th>Модель телефону</th><th>Кількість покупок:</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["manufacturer"] . "</td>";
        echo "<td>" . $row["model"] . "</td>";
        echo "<td>" . $row["purchase_count"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Немає даних про покупки телефонів";
}
?>
<a href='index.php' class='back-button'>Назад</a>
</div>
</body>
</html>