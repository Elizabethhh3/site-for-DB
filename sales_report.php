<html>
<head>
    <meta charset="UTF-8">
    <title>Клієнти</title>
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
<?php
// З'єднання з базою даних
$conn = new mysqli("localhost", "root", "123456", "enterprise");
if ($conn->connect_error) {
    die("Помилка з'єднання з базою даних: " . $conn->connect_error);
}

// Отримання дат початку і закінчення з форми
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

// SQL-запит для вибірки продажів за певний період
$sql = "SELECT c.pib_client, p.model, o.quantity, o.date_order
        FROM orders o
        JOIN clients c ON o.id_client = c.id_client
        JOIN products p ON o.id_product = p.id_product
        WHERE o.date_order BETWEEN '$start_date' AND '$end_date'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Виведення даних у вигляді таблиці
    echo "<h1>Звіт про продажі за період з $start_date до $end_date</h1>";
    echo "<table>";
    echo "<tr><th>Клієнт</th><th>Модель телефону</th><th>Кількість</th><th>Дата замовлення</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["pib_client"] . "</td>";
        echo "<td>" . $row["model"] . "</td>";
        echo "<td>" . $row["quantity"] . "</td>";
        echo "<td>" . $row["date_order"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<h2>Немає даних про продажі за вказаний період</h2>";
}
echo "<a href='zvit.html' class='back-button'>Назад</a>";
// Закриття з'єднання
$conn->close();
?>
</body>
</html>