<?php
// Перевірка, чи передано ID замовлення
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Отримання даних з форми
    $pib_client = $_POST['client'];
    $product = $_POST['product'];
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];
    $status_order = $_POST['status_order'];
    $payment_order = $_POST['payment_order'];

    // З'єднання з базою даних
    $conn = new mysqli("localhost", "root", "123456", "enterprise");
    if ($conn->connect_error) {
        die("Помилка з'єднання з базою даних: " . $conn->connect_error);
    }
// Оновлення замовлення в базі даних
$updateOrderSql = "UPDATE orders SET id_product = '$product', quantity = '$quantity', date_order = '$date', 
status_order = '$status_order', payment_order = '$payment_order' WHERE id_order = $id";
if ($conn->query($updateOrderSql) === TRUE) {
    // Оновлення інформації про клієнта в базі даних
    $updateClientSql = "UPDATE clients SET pib_client = '$pib_client' WHERE id_client = (SELECT id_client FROM orders WHERE id_order = $id)";
    if ($conn->query($updateClientSql) === TRUE) {
        echo "<script>setTimeout(function(){location.href='orders.php'},500);</script>";
    } else {
        echo "Помилка при оновленні інформації про клієнта: " . $conn->error;
        echo "<script>setTimeout(function(){location.href='orders.php'},2000);</script>";
    }
} else {
    echo "Помилка оновлення замовлення: " . $conn->error;
    echo "<script>setTimeout(function(){location.href='orders.php'},2000);</script>";
}
}
// Закриття з'єднання
$conn->close();
?>