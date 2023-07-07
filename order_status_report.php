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

// SQL-запит для вибірки стану замовлень
$sql = "SELECT o.id_order, c.pib_client, p.model, o.status_order
        FROM orders o
        JOIN clients c ON o.id_client = c.id_client
        JOIN products p ON o.id_product = p.id_product
        ORDER BY o.id_order ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Виведення даних у вигляді таблиці
    echo "<h2>Звіт про стан замовлень</h2>";
    echo "<table>";
    echo "<tr><th>№ замовлення</th><th>Клієнт</th><th>Модель телефону</th><th>Статус</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id_order"] . "</td>";
        echo "<td>" . $row["pib_client"] . "</td>";
        echo "<td>" . $row["model"] . "</td>";
        echo "<td>" . $row["status_order"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<h2>Немає даних про замовлення</h2>";
}
echo "<a href='zvit.html' class='back-button'>Назад</a>";
// Закриття з'єднання
$conn->close();
?>
</body>
</html>