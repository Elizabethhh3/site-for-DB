<html>
<head>
    <meta charset="UTF-8">
    <title>Редагувати замовлення ремонту</title>
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
<h1 style="font-size: 22px;">Редагувати замовлення ремонту</h1>

<?php
// З'єднання з базою даних
$conn = new mysqli("localhost", "root", "123456", "enterprise");
if ($conn->connect_error) {
    die("Помилка з'єднання з базою даних: " . $conn->connect_error);
}

// Перевірка, чи передано ID ремонту через параметр URL
if (isset($_GET['id'])) {
    $repairId = $_GET['id'];

    $sql = "SELECT repair.id_repair, repair.id_client, repair.serial_number, 
    repair.problem_description, repair.price_repair, repair.id_employee, clients.pib_client, 
    products.manufacturer, products.model, products.serial_number, repair.date_receive, repair.status_repair, 
    repair.payment_repair, employee.pib_employee
    FROM repair
    JOIN clients ON repair.id_client = clients.id_client
    JOIN products ON repair.serial_number = products.serial_number
    JOIN employee on repair.id_employee = employee.id_employee
    WHERE id_repair = $repairId";
$result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Виведення форми для редагування ремонту
        echo "<form action='update_repair.php' method='POST'>";
        echo "<input type='hidden' name='id' value='$repairId'>";
        echo "<div class='form-group'>";
        echo "<label>ПІБ клієнта:</label>";
        echo "<input type='text' name='pib_client' value='" . $row["pib_client"] . "' required><br>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='product'>Товар:</label>";
        echo "<select name='product' id='product' required>";

        // Отримання списку товарів з бази даних
        $productsSql = "SELECT manufacturer, model, color, serial_number FROM products";
        $productsResult = $conn->query($productsSql);

        if ($productsResult->num_rows > 0) {
            while ($productRow = $productsResult->fetch_assoc()) {
                $selected = ($productRow["serial_number"] == $row["serial_number"]) ? "selected" : "";
                echo "<option value='" . $productRow["serial_number"] . "' " . $selected . ">" . $productRow["manufacturer"] . ", " . $productRow["model"] . ", " . $productRow["color"] . "</option>";
            }
        }
        echo "</select>";
        echo "</div>";      
        echo "<div class='form-group'>";
        echo "<label>Серійний номер товару (для перевірки, змінювати заборонено!):</label>";
        echo "<input type='text' name='serial_number' value='" . $row["serial_number"] . "' readonly><br>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label>Опис проблеми:</label>";
        echo "<textarea required name='problem_description'>" . $row['problem_description'] . "</textarea><br>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label>Дата прийому:</label>";
        echo "<input type='date' name='date_receive' required value='" . $row["date_receive"] . "'><br>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='status_repair'>Статус:</label>";
        echo "<select name='status_repair' id='status_repair'>";
        echo "<option value='в процесі'" . ($row["status_repair"] === 'в процесі' ? ' selected' : '') . ">в процесі</option>";
        echo "<option value='виконано'" . ($row["status_repair"] === 'виконано' ? ' selected' : '') . ">виконано</option>";
        echo "<option value='скасовано'" . ($row["status_repair"] === 'скасовано' ? ' selected' : '') . ">скасовано</option>";
        echo "</select><br>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label>Ціна ремонту:</label>";
        echo "<input type='text' required name='price_repair' value='" . $row["price_repair"] . "'><br>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='payment_repair'>Оплата:</label>";
        echo "<select name='payment_repair' id='payment_repair'>";
        echo "<option value='оплачено'" . ($row["payment_repair"] === 'оплачено' ? ' selected' : '') . ">оплачено</option>";
        echo "<option value='неоплачено'" . ($row["payment_repair"] === 'неоплачено' ? ' selected' : '') . ">неоплачено</option>";
        echo "</select><br>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='employee'>Виконавець ремонту:</label>";
        echo "<select name='employee' id='employee'>";

            // Отримання списку працівників
            $employeeSql = "SELECT id_employee, pib_employee FROM employee";
            $employeeResult = $conn->query($employeeSql);

            if ($employeeResult->num_rows > 0) {
                while ($employeeRow = $employeeResult->fetch_assoc()) {
                    $selected = ($employeeRow["id_employee"] === $row["id_employee"]) ? ' selected' : '';
                    echo "<option value='" . $employeeRow["id_employee"] . "'$selected>" . $employeeRow["pib_employee"] . "</option>";
                }
            }
        echo "</select><br>";
        echo "</div>";
        echo "<input type='submit' value='Зберегти' class='submit-button'>";
        echo "</form>";
        echo "<a href='repair.php' class='back-button'>Назад</a>";
    } else {
        echo "Ремонт не знайдено";
    }
} else {
    echo "Не передано ID ремонту";
}

// Закриття з'єднання
$conn->close();
?>
</body>
</html>