<?php
// Перевірка, чи були надіслані дані з форми
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Отримання даних з форми
    $pib = $_POST["pib"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $city = $_POST["city"];

    // Перевірка, чи всі поля заповнені
    if (!empty($pib) && !empty($phone) && !empty($address) && !empty($city)) {
        // Підключення до бази даних
        $conn = new mysqli("localhost", "root", "123456", "enterprise");
        if ($conn->connect_error) {
            die("Помилка з'єднання з базою даних: " . $conn->connect_error);
        }

        foreach($conn->query("SELECT MAX(id_client) FROM clients") as $row) {
            $id = $row['MAX(id_client)']+1;
          }

        // Підготовка та виконання SQL-запиту для додавання клієнта
        $sql = "INSERT INTO clients (id_client, pib_client, phone_client, address_client, city_client) VALUES ($id, '$pib', '$phone', '$address', '$city')";
        if ($conn->query($sql) === TRUE) {
            // Успішно додано клієнта
            echo "<script>setTimeout(function(){location.href='clients.php'},500);</script>";
        } else {
            echo "Помилка при додаванні клієнта: " . $conn->error;
            echo "<script>setTimeout(function(){location.href='clients.php'},2000);</script>";
        }
        // Закриття з'єднання з базою даних
        $conn->close();
    } else {
        // Виведення повідомлення про неповністю заповнену форму
        echo "Будь ласка, заповніть всі поля форми!";
        echo "<script>setTimeout(function(){location.href='clients.php'},2000);</script>";
    }
}
?>