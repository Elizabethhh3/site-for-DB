<?php
// Перевірка, чи передані дані форми
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Перевірка, чи передано ID працівника
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // З'єднання з базою даних
        $conn = new mysqli("localhost", "root", "123456", "enterprise");
        if ($conn->connect_error) {
            die("Помилка з'єднання з базою даних: " . $conn->connect_error);
        }

        // Отримання даних з форми
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $position = $_POST['position'];

        // Оновлення даних працівника
        $sql = "UPDATE employee SET pib_employee='$name', phone_employee='$phone', position='$position' WHERE id_employee=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>setTimeout(function(){location.href='employee.php'},500);</script>";
    } else {
        echo "Помилка при оновленні інформації про клієнта. " . $conn->error;
        echo "<script>setTimeout(function(){location.href='employee.php'},2000);</script>";
    }
    // Закриття з'єднання
    $conn->close();
} else {
    echo "Недоступний безпосередній доступ до цього файлу.";
    echo "<script>setTimeout(function(){location.href='employee.php'},2000);</script>";
}
}
?>