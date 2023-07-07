<?php
// Перевірка, чи були надіслані дані з форми
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Отримання даних з форми
    $model = $_POST["model"];
    $manufacturer = $_POST["manufacturer"];
    $processor = $_POST["processor"];
    $color = $_POST["color"];
    $serialNumber = $_POST["serial_number"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $warranty = $_POST["warranty"];

    // Перевірка, чи всі поля заповнені
    if (!empty($model) && !empty($manufacturer) && !empty($processor) && !empty($color) && !empty($serialNumber) && !empty($price) && !empty($quantity) && !empty($warranty)) {
        // Підключення до бази даних
        $conn = new mysqli("localhost", "root", "123456", "enterprise");
        if ($conn->connect_error) {
            die("Помилка з'єднання з базою даних: " . $conn->connect_error);
        }

        foreach($conn->query("SELECT MAX(id_product) FROM products") as $row) {
            $id = $row['MAX(id_product)']+1;
          }

        // Підготовка та виконання SQL-запиту для додавання товару
        $sql = "INSERT INTO products (id_product, model, manufacturer, processor, color, serial_number, price_product, quantity_stock, warranty) 
                VALUES ($id, '$model', '$manufacturer', '$processor', '$color', '$serialNumber', $price, $quantity, '$warranty')";
        if ($conn->query($sql) === TRUE) {
            // Успішно додано товар
            echo "<script>setTimeout(function(){location.href='products.php'},500);</script>";
        } else {
            echo "Помилка при додаванні товару: " . $conn->error;
            echo "<script>setTimeout(function(){location.href='products.php'},2000);</script>";
        }

        // Закриття з'єднання з базою даних
        $conn->close();
    } else {
        // Виведення повідомлення про неповністю заповнену форму
        echo "Будь ласка, заповніть всі поля форми!";
        echo "<script>setTimeout(function(){location.href='products.php'},2000);</script>";
    }
}
?>