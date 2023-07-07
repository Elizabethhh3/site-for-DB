<html>
<head>
    <meta charset="UTF-8">
    <title>Редагувати працівника</title>
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
<h1 style="font-size: 22px;">Редагувати працівника</h1>

<?php
// Перевірка, чи передано ID працівника
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // З'єднання з базою даних
    $conn = new mysqli("localhost", "root", "123456", "enterprise");
    if ($conn->connect_error) {
        die("Помилка з'єднання з базою даних: " . $conn->connect_error);
    }

    // Отримання інформації про працівника за його ID
    $sql = "SELECT * FROM employee WHERE id_employee = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Виведення форми редагування
        echo "<form method='post' action='update_employee.php' class='edit-form'>";
        echo "<input type='hidden' name='id' value='" . $row["id_employee"] . "'>";
        echo "<div class='form-group'>";
        echo "<label for='name'>ПІБ:</label>";
        echo "<input type='text' name='name' id='name' value='" . $row["pib_employee"] . "' required>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='phone'>Телефон:</label>";
        echo "<input type='text' name='phone' required id='phone' value='" . $row["phone_employee"] . "'>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='position'>Посада:</label>";
        echo "<input type='text' name='position' id='position' value='" . $row["position"] . "' required>";
        echo "</div>";
        echo "<input type='submit' value='Зберегти' class='submit-button'>";
        echo "</form>";
        // Кнопка "Назад"
        echo "<a href='employee.php' class='back-button'>Назад</a>";
    } else {
        echo "Працівника з ID $id не знайдено";
    }

    // Закриття з'єднання
    $conn->close();
} else {
    echo "Не вказано ID працівника для редагування";
}
?>
</body>
</html>