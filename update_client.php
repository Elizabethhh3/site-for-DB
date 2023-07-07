<?php
// Перевірка, чи отримано дані з форми редагування
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Отримання даних з форми
    $id = $_POST["id"];
    $pib = $_POST["pib"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $city = $_POST["city"];

    // З'єднання з базою даних
    $conn = new mysqli("localhost", "root", "123456", "enterprise");
    if ($conn->connect_error) {
        die("Помилка з'єднання з базою даних: " . $conn->connect_error);
    }
    // Оновлення інформації про клієнта
    $sql = "UPDATE clients SET pib_client='$pib', phone_client='$phone', address_client='$address', city_client='$city' WHERE id_client=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>setTimeout(function(){location.href='clients.php'},500);</script>";
    } else {
        echo "Помилка при оновленні інформації про клієнта. " . $conn->error;
        echo "<script>setTimeout(function(){location.href='clients.php'},2000);</script>";
    }
    // Закриття з'єднання
    $conn->close();
} else {
    echo "Недоступний безпосередній доступ до цього файлу.";
    echo "<script>setTimeout(function(){location.href='clients.php'},2000);</script>";
}
?>