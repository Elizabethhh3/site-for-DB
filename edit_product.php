<html>
<head>
    <meta charset="UTF-8">
    <title>Редагувати товар</title>
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
<h1 style="font-size: 22px;">Редагувати товар</h1>

<?php
// Перевірка, чи передано ID товару
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // З'єднання з базою даних
    $conn = new mysqli("localhost", "root", "123456", "enterprise");
    if ($conn->connect_error) {
        die("Помилка з'єднання з базою даних: " . $conn->connect_error);
    }

    // Отримання інформації про товар за його ID
    $sql = "SELECT * FROM products WHERE id_product = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Виведення форми редагування
        echo "<form method='post' action='update_product.php' class='edit-form'>";
        echo "<input type='hidden' name='id' value='" . $row["id_product"] . "'>";
        echo "<div class='form-group'>";
        echo "<label for='model'>Модель:</label>";
        echo "<input type='text' name='model' id='model' value='" . $row["model"] . "' required>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='manufacturer'>Виробник:</label>";
        echo "<input type='text' name='manufacturer' id='manufacturer' value='" . $row["manufacturer"] . "' required>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='processor'>Процесор:</label>";
        echo "<input type='text' name='processor' id='processor' required value='" . $row["processor"] . "'>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='color'>Колір:</label>";
        echo "<input type='text' name='color' required id='color' value='" . $row["color"] . "'>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='serial_number'>Серійний номер: УВАГА! При зміні сер. номеру дані про цей товар видаляються з інших таблиць, адже це вже зовсім інший телефон.</label>";
        echo "<input type='text' name='serial_number' required id='serial_number' value='" . $row["serial_number"] . "'>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='price'>Ціна:</label>";
        echo "<input type='text' name='price' required id='price' value='" . $row["price_product"] . "'>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='quantity'>Кількість на складі:</label>";
        echo "<input type='text' name='quantity' required id='quantity' value='" . $row["quantity_stock"] . "'>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='warranty'>Гарантія:</label>";
        echo "<input type='date' name='warranty' required id='warranty' value='" . $row["warranty"] . "'>";
        echo "</div>";
        echo "<input type='submit' value='Зберегти' class='submit-button'>";
        echo "</form>";
        // Кнопка "Назад"
        echo "<a href='products.php' class='back-button'>Назад</a>";

    } else {
        echo "Товара з ID $id не знайдено";
    }
    // Закриття з'єднання
    $conn->close();
} else {
    echo "Не вказано ID товару для редагування";
}
?>
</body>
</html>