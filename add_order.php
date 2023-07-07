<html>
<head>
    <meta charset="UTF-8">
    <title>Додати замовлення</title>
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
<h1 style="font-size: 22px;">Додати замовлення</h1>

<?php
// З'єднання з базою даних
$conn = new mysqli("localhost", "root", "123456", "enterprise");
if ($conn->connect_error) {
    die("Помилка з'єднання з базою даних: " . $conn->connect_error);
}

// Отримання списку клієнтів з бази даних
$clientsSql = "SELECT id_client, pib_client FROM clients";
$clientsResult = $conn->query($clientsSql);

// Отримання списку товарів з бази даних
$productsSql = "SELECT id_product, manufacturer, model FROM products";
$productsResult = $conn->query($productsSql);
?>
<form method="post" action="save_order.php" class="edit-form">
<div class="form-group">
        <label for="client">ПІБ клієнта:</label>
        <select name="client" id="client" style="width: 300px" required>
            <?php
            if ($clientsResult->num_rows > 0) {
                while ($clientRow = $clientsResult->fetch_assoc()) {
                    echo "<option value='" . $clientRow["id_client"] . "'>" . $clientRow["pib_client"] . "</option>";
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="product">Товар:</label>
        <select name="product" id="product" required>
    <?php
    $productsSql = "SELECT id_product, manufacturer, model, color FROM products";
    $productsResult = $conn->query($productsSql);
    if ($productsResult->num_rows > 0) {
        while ($productRow = $productsResult->fetch_assoc()) {
            echo "<option value='" . $productRow["id_product"] . "'>" . $productRow["manufacturer"] . ", " . $productRow["model"] . ", " . $productRow["color"] . "</option>";
        }
    }
    ?>
</select>

    </div>
    <div class="form-group">
        <label for="quantity">Кількість:</label>
        <input type="number" value="1" name="quantity" id="quantity" required>
    </div>
    <div class="form-group">
        <label for="date">Дата:</label>
        <input type="date" name="date" id="date" required>
    </div>
    <input type="submit" value="Додати" class="submit-button">
</form>
<a href="orders.php" class="back-button">Назад</a>

</body>
</html>