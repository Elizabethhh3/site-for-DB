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

// SQL-запит для вибірки виконаних ремонтів за певний період
$sql = "SELECT r.id_repair, r.date_receive, c.pib_client, r.price_repair, e.pib_employee
        FROM repair r
        JOIN clients c ON r.id_client = c.id_client
        JOIN employee e ON r.id_employee = e.id_employee
        WHERE r.date_receive BETWEEN '$start_date' AND '$end_date'
        ORDER BY r.date_receive ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Виведення даних у вигляді таблиці
    echo "<h1>Звіт про виконані ремонти за період з $start_date до $end_date</h1>";
    echo "<table>";
    echo "<tr><th>№ ремонту</th><th>Дата ремонту</th><th>Клієнт</th><th>Вартість ремонту</th><th>Виконавець</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id_repair"] . "</td>";
        echo "<td>" . $row["date_receive"] . "</td>";
        echo "<td>" . $row["pib_client"] . "</td>";
        echo "<td>" . $row["price_repair"] . "</td>";
        echo "<td>" . $row["pib_employee"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<h2>Немає даних про ремонти за вказаний період.</h2>";
}
echo "<a href='zvit.html' class='back-button'>Назад</a>";
// Закриття з'єднання
$conn->close();
?>
</body>
</html>