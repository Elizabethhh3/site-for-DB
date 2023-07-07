<html>
<head>
    <meta charset="UTF-8">
    <title>Редагувати замовлення</title>
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
<h1 style="font-size: 22px;">Редагувати замовлення</h1>

<?php
// Перевірка, чи передано ID замовлення
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // З'єднання з базою даних
    $conn = new mysqli("localhost", "root", "123456", "enterprise");
    if ($conn->connect_error) {
        die("Помилка з'єднання з базою даних: " . $conn->connect_error);
    }

    // Отримання інформації про замовлення за його ID
    $sql = "SELECT orders.id_order, orders.id_client, clients.pib_client, orders.id_product, products.manufacturer, products.model, orders.quantity, orders.date_order, orders.status_order, orders.payment_order 
            FROM orders
            JOIN clients ON orders.id_client = clients.id_client
            JOIN products ON orders.id_product = products.id_product
            WHERE id_order = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Виведення форми редагування
        echo "<form method='post' action='update_order.php' class='edit-form'>";
        echo "<input type='hidden' name='id' value='" . $row["id_order"] . "'>";
        echo "<div class='form-group'>";
        echo "<label for='client'>ПІБ клієнта:</label>";
        echo "<input type='text' name='client' id='client' value='" . $row["pib_client"] . "' required>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='product'>Товар:</label>";
        echo "<select name='product' id='product' required>";

        // Отримання списку товарів з бази даних
        $productsSql = "SELECT id_product, manufacturer, model, color FROM products";
        $productsResult = $conn->query($productsSql);

        if ($productsResult->num_rows > 0) {
            while ($productRow = $productsResult->fetch_assoc()) {
                $selected = ($productRow["id_product"] == $row["id_product"]) ? "selected" : "";
                echo "<option value='" . $productRow["id_product"] . "' " . $selected . ">" . $productRow["manufacturer"] . ", " . $productRow["model"] . ", " . $productRow["color"] . "</option>";
            }
        }

        echo "</select>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='quantity'>Кількість:</label>";
        echo "<input type='number' name='quantity' id='quantity' value='" . $row["quantity"] . "' required>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='date'>Дата:</label>";
        echo "<input type='date' name='date' id='date' value='" . $row["date_order"] . "' required>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='status'>Статус:</label>";
        echo "<select name='status_order'>";
        echo "<option value='виконано'" . ($row["status_order"] === 'виконано' ? ' selected' : '') . ">виконано</option>";
        echo "<option value='в обробці'" . ($row["status_order"] === 'в обробці' ? ' selected' : '') . ">в обробці</option>";
        echo "<option value='доставляється'" . ($row["status_order"] === 'доставляється' ? ' selected' : '') . ">доставляється</option>";
        echo "<option value='скасовано'" . ($row["status_order"] === 'скасовано' ? ' selected' : '') . ">скасовано</option>";
        echo "</select><br>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='payment'>Оплата:</label>";
        echo "<select name='payment_order'>";
        echo "<option value='оплачено'" . ($row["payment_order"] === 'оплачено' ? ' selected' : '') . ">оплачено</option>";
        echo "<option value='неоплачено'" . ($row["payment_order"] === 'неоплачено' ? ' selected' : '') . ">неоплачено</option>";
        echo "</select><br>";
        echo "</div>";
        echo "<input type='submit' value='Зберегти' class='submit-button'>";
        echo "</form>";
        echo "<a href='orders.php' class='back-button'>Назад</a>";
    } else {
        echo "Замовлення не знайдено";
    }

    // Закриття з'єднання
    $conn->close();
} else {
    echo "Недостатній параметр - ID замовлення";
}
?>
</body>
</html>