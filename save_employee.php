<?php
// Перевірка, чи були надіслані дані з форми
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Отримання даних з форми
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $position = $_POST["position"];

    // Перевірка, чи всі поля заповнені
    if (!empty($name) && !empty($phone) && !empty($position)) {
        // Підключення до бази даних
        $conn = new mysqli("localhost", "root", "123456", "enterprise");
        if ($conn->connect_error) {
            die("Помилка з'єднання з базою даних: " . $conn->connect_error);
        }

        foreach($conn->query("SELECT MAX(id_employee) FROM employee") as $row) {
            $id = $row['MAX(id_employee)']+1;
          }

        // Підготовка та виконання SQL-запиту для додавання працівника
        $sql = "INSERT INTO employee (id_employee, pib_employee, phone_employee, position) VALUES ($id, '$name', '$phone', '$position')";
        if ($conn->query($sql) === TRUE) {
            // Успішно додано працівника
            echo "<script>setTimeout(function(){location.href='employee.php'},500);</script>";
        } else {
            echo "Помилка при додаванні працівника: " . $conn->error;
            echo "<script>setTimeout(function(){location.href='employee.php'},2000);</script>";
        }

        // Закриття з'єднання з базою даних
        $conn->close();
    } else {
        // Виведення повідомлення про неповністю заповнену форму
        echo "Будь ласка, заповніть всі поля форми!";
        echo "<script>setTimeout(function(){location.href='employee.php'},2000);</script>";
    }
}
?>