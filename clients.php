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
<h1 style="font-size: 22px;">Клієнти</h1>
<div class="search-container">
    <form method="GET" action="clients.php" class="search-form">
        <input type="text" name="search" placeholder="Введіть ПІБ" class="search-input">
        <input class="search-button" type="submit" value="Пошук">
    </form>
</div>
<?php
// З'єднання з базою даних
$conn = new mysqli("localhost", "root", "123456", "enterprise");
if ($conn->connect_error) {
    die("Помилка з'єднання з базою даних: " . $conn->connect_error);
}

// Перевірка, чи було введено пошуковий запит
if (isset($_GET['search'])) {
    $search = $_GET['search'];

    // Запит до бази даних з урахуванням пошукового запиту
    $sql = "SELECT * FROM clients WHERE pib_client LIKE '%$search%'";
} else {
    // Запит до бази даних без урахування пошукового запиту
    $orderBy = isset($_GET['order']) ? $_GET['order'] : 'id_client';
    if ($orderBy === 'city_asc') {
        $sql = "SELECT * FROM clients ORDER BY city_client ASC";
    } elseif ($orderBy === 'city_desc') {
        $sql = "SELECT * FROM clients ORDER BY city_client DESC";
    } else {
        $sql = "SELECT * FROM clients";
    }
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Виведення даних у вигляді таблиці
    echo "<table>";
    echo "<tr><th>ID</th><th>ПІБ</th><th>Телефон</th><th>Адреса</th><th>Місто <a href='clients.php?order=city_asc' class='sort-arrow sort-asc'></a> <a href='clients.php?order=city_desc' class='sort-arrow sort-desc'></a></th><th style='padding-left: 100px;'>Дії</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id_client"] . "</td>";
        echo "<td>" . $row["pib_client"] . "</td>";
        echo "<td>" . $row["phone_client"] . "</td>";
        echo "<td>" . $row["address_client"] . "</td>";
        echo "<td>" . $row["city_client"] . "</td>";
        echo "<td>";
        echo "<a class='edit-button' href='edit_client.php?id=" . $row["id_client"] . "'>Редагувати</a>";
        echo "<a class='delete-button' href='delete_client.php?id=" . $row["id_client"] . "'>Видалити</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Немає даних для відображення";
}

// Закриття з'єднання
$conn->close();
?>
<div class="add-button-container">
    <a href="add_client.html" class="add-button">Додати новий запис</a>
</div>
</body>
</html>