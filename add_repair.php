<html>
<head>
    <meta charset="UTF-8">
    <title>Додати замовлення ремонту</title>
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
<h1 style="font-size: 22px;">Додати замовлення ремонту</h1>

<form action="save_repair.php" method="POST">
<div class="form-group">
        <label for="client">ПІБ клієнта:</label>
        <select name="client" id="client" style="width: 300px" required>
            <?php
            // З'єднання з базою даних
            $conn = new mysqli("localhost", "root", "123456", "enterprise");
            if ($conn->connect_error) {
                die("Помилка з'єднання з базою даних: " . $conn->connect_error);
            }
            
            // Отримання списку клієнтів з бази даних
            $clientsSql = "SELECT id_client, pib_client FROM clients";
            $clientsResult = $conn->query($clientsSql);
            if ($clientsResult->num_rows > 0) {
                while ($clientRow = $clientsResult->fetch_assoc()) {
                    echo "<option value='" . $clientRow["id_client"] . "'>" . $clientRow["pib_client"] . "</option>";
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="product">Виробник і модель телефону:</label>
        <select id="product" name="product" required>
            <?php
            $conn = new mysqli("localhost", "root", "123456", "enterprise");
            if ($conn->connect_error) {
                die("Помилка з'єднання з базою даних: " . $conn->connect_error);
            }
            // Отримання списку товарів з бази даних
            $productsSql = "SELECT serial_number, manufacturer, model, color FROM products";
            $productsResult = $conn->query($productsSql);
            if ($productsResult->num_rows > 0) {
                while ($productRow = $productsResult->fetch_assoc()) {
                    echo "<option value='" . $productRow["serial_number"] . "'>" . $productRow["manufacturer"] . ", " . $productRow["model"] . ", " . $productRow["color"] . "</option>";
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="problem_description">Опис проблеми:</label>
        <textarea id="problem_description" name="problem_description" required></textarea>
    </div>
    <div class="form-group">
        <label for="date_receive">Дата прийому:</label>
        <input type="date" id="date_receive" name="date_receive" required>
    </div>
    <div class="form-group">
        <label for="price_repair">Ціна ремонту:</label>
        <input type="text" id="price_repair" required name="price_repair">
    </div>
    <div class="form-group">
        <label for="employee">Виконавець ремонту:</label>
        <select id="employee" name="employee">
        <?php
            $conn = new mysqli("localhost", "root", "123456", "enterprise");
            if ($conn->connect_error) {
                die("Помилка з'єднання з базою даних: " . $conn->connect_error);
            }
        $employeeSql = "SELECT id_employee, pib_employee FROM employee";
            $employeeResult = $conn->query($employeeSql);

            if ($employeeResult->num_rows > 0) {
                while ($employeeRow = $employeeResult->fetch_assoc()) {
                    $selected = ($employeeRow["id_employee"] === $row["id_employee"]) ? ' selected' : '';
                    echo "<option value='" . $employeeRow["id_employee"] . "'$selected>" . $employeeRow["pib_employee"] . "</option>";
                }
            }
            ?>
        </select><br>
    </div>
    <input type="submit" value="Додати" class="submit-button">
</form>
<a href="repair.php" class="back-button">Назад</a>

</body>
</html>