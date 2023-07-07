<?php
// З'єднання з базою даних
$conn = new mysqli("localhost", "root", "123456", "enterprise");
if ($conn->connect_error) {
    die("Помилка з'єднання з базою даних: " . $conn->connect_error);
}

// Переконайтеся, що ID клієнта передано через параметр URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Запит на видалення рядка з бази даних
    $sql = "DELETE FROM clients WHERE id_client = $id";

    if ($conn->query($sql) === TRUE) {
        // Рядок успішно видалено
        echo "<script>setTimeout(function(){location.href='clients.php'},500);</script>";
    } else {
        echo "Помилка видалення рядка: " . $conn->error;
        echo "<script>setTimeout(function(){location.href='clients.php'},2000);</script>";
    }
} else {
    echo "ID клієнта не передано";
    echo "<script>setTimeout(function(){location.href='clients.php'},2000);</script>";
}

// Закриття з'єднання
$conn->close();
?>