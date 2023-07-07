<html>
<head>
    <meta charset="UTF-8">
    <title>Редагувати клієнта</title>
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
<h1 style="font-size: 22px;">Редагувати клієнта</h1>
<?php
// Перевірка, чи передано ID клієнта
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // З'єднання з базою даних
    $conn = new mysqli("localhost", "root", "123456", "enterprise");
    if ($conn->connect_error) {
        die("Помилка з'єднання з базою даних: " . $conn->connect_error);
    }

    // Отримання інформації про клієнта за його ID
    $sql = "SELECT * FROM clients WHERE id_client = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Виведення форми редагування
echo "<form method='post' action='update_client.php' class='edit-form'>";
echo "<input type='hidden' name='id' value='" . $row["id_client"] . "'>";
echo "<div class='form-group'>";
echo "<label for='pib'>ПІБ:</label>";
echo "<input type='text' name='pib' id='pib' value='" . $row["pib_client"] . "' required>";
echo "</div>";
echo "<div class='form-group'>";
echo "<label for='phone'>Телефон:</label>";
echo "<input type='text' name='phone' id='phone' value='" . $row["phone_client"] . "' required>";
echo "</div>";
echo "<div class='form-group'>";
echo "<label for='address'>Адреса:</label>";
echo "<input type='text' name='address' id='address' required value='" . $row["address_client"] . "'>";
echo "</div>";
echo "<div class='form-group'>";
echo "<label for='city'>Місто:</label>";
echo "<input type='text' name='city' required id='city' value='" . $row["city_client"] . "'>";
echo "</div>";
echo "<input type='submit' value='Зберегти' class='submit-button'>";
echo "</form>";
// Кнопка "Назад"
echo "<a href='clients.php' class='back-button'>Назад</a>";

    } else {
        echo "Клієнта з ID $id не знайдено";
    }
    // Закриття з'єднання
    $conn->close();
} else {
    echo "Не вказано ID клієнта для редагування";
}
?>
</body>
</html>