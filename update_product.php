<?php
// Перевірка, чи отримано дані з форми
if (isset($_POST['id']) && isset($_POST['model']) && isset($_POST['manufacturer']) && isset($_POST['processor']) && isset($_POST['color']) && isset($_POST['serial_number']) && isset($_POST['price']) && isset($_POST['quantity']) && isset($_POST['warranty'])) {
    $id = $_POST['id'];
    $model = $_POST['model'];
    $manufacturer = $_POST['manufacturer'];
    $processor = $_POST['processor'];
    $color = $_POST['color'];
    $serial_number = $_POST['serial_number'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $warranty = $_POST['warranty'];

    // З'єднання з базою даних
    $conn = new mysqli("localhost", "root", "123456", "enterprise");
    if ($conn->connect_error) {
        die("Помилка з'єднання з базою даних: " . $conn->connect_error);
    }

    // Перевірка, чи змінений серійний номер
    $previousSerialNumberQuery = "SELECT serial_number FROM products WHERE id_product = $id";
    $previousSerialNumberResult = $conn->query($previousSerialNumberQuery);
    if ($previousSerialNumberResult->num_rows > 0) {
        $previousSerialNumberRow = $previousSerialNumberResult->fetch_assoc();
        $previousSerialNumber = $previousSerialNumberRow['serial_number'];

        if ($previousSerialNumber != $serial_number) {
            // Видалення попереднього рядка
            $deleteQuery = "DELETE FROM products WHERE id_product = $id";
            if ($conn->query($deleteQuery) === FALSE) {
                echo "Помилка при видаленні попереднього рядка. " . $conn->error;
                echo "<script>setTimeout(function(){location.href='products.php'},2000);</script>";
                $conn->close();
                exit;
            }

            // Вставка нового рядка
            $insertQuery = "INSERT INTO products (id_product, model, manufacturer, processor, color, serial_number, price_product, quantity_stock, warranty)
                            VALUES ($id, '$model', '$manufacturer', '$processor', '$color', '$serial_number', '$price', '$quantity', '$warranty')";
            if ($conn->query($insertQuery) === TRUE) {
                echo "<script>setTimeout(function(){location.href='products.php'},500);</script>";
            } else {
                echo "Помилка при оновленні інформації про товар. " . $conn->error;
                echo "<script>setTimeout(function(){location.href='products.php'},2000);</script>";
            }
        } else {
            // Оновлення рядка
            $updateQuery = "UPDATE products SET model = '$model', manufacturer = '$manufacturer', processor = '$processor', color = '$color', price_product = '$price', quantity_stock = '$quantity', warranty = '$warranty' WHERE id_product = $id";
            if ($conn->query($updateQuery) === TRUE) {
                echo "<script>setTimeout(function(){location.href='products.php'},500);</script>";
            } else {
                echo "Помилка при оновленні інформації про товар. " . $conn->error;
                echo "<script>setTimeout(function(){location.href='products.php'},2000);</script>";
            }
        }
    }

    $conn->close();
}
?>