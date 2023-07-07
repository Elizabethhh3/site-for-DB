<?php
// З'єднання з базою даних
$conn = new mysqli("localhost", "root", "123456", "enterprise");
if ($conn->connect_error) {
    die("Помилка з'єднання з базою даних: " . $conn->connect_error);
}

// Видалення рядка з таблиці "products"
$id = $_GET["id"]; // Отримання ID рядка для видалення (запит залежить від вашого URL)
$sql = "DELETE FROM products WHERE id_product = $id";
if ($conn->query($sql) === TRUE) {
    // Рядок успішно видалено
    echo "<script>setTimeout(function(){location.href='products.php'},500);</script>";
} else {
    echo "Помилка видалення рядка: " . $conn->error;
    echo "<script>setTimeout(function(){location.href='products.php'},2000);</script>";
}

// Закриття з'єднання
$conn->close();
?>