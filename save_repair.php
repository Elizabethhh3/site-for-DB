<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Отримання даних з форми
    $client = $_POST["client"];
    $product = $_POST["product"];
    $problem_description = $_POST["problem_description"];
    $date_receive = $_POST["date_receive"];
    $price_repair = $_POST["price_repair"];
    $employee = $_POST["employee"];

    // З'єднання з базою даних
    $conn = new mysqli("localhost", "root", "123456", "enterprise");
    if ($conn->connect_error) {
        die("Помилка з'єднання з базою даних: " . $conn->connect_error);
    }

        // Екранування даних перед вставкою
        $client = mysqli_real_escape_string($conn, $client);
        $product = mysqli_real_escape_string($conn, $product);
        $problem_description = mysqli_real_escape_string($conn, $problem_description);
        $date_receive = mysqli_real_escape_string($conn, $date_receive);
        $price_repair = mysqli_real_escape_string($conn, $price_repair);
        $employee = mysqli_real_escape_string($conn, $employee);

        foreach ($conn->query("SELECT MAX(id_repair) FROM repair") as $row) {
            $id = $row['MAX(id_repair)'] + 1;
        }

        $sql = "INSERT INTO repair (id_repair, id_client, serial_number, problem_description, date_receive, status_repair, price_repair, payment_repair, id_employee)
            VALUES ($id,'$client', '$product', '$problem_description', '$date_receive', 'виконується','$price_repair', 'неоплачено', '$employee')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>setTimeout(function(){location.href='repair.php'},500);</script>";
        } else {
            echo "Помилка при додаванні замовлення на ремонт: " . $conn->error;
            echo "<script>setTimeout(function(){location.href='repair.php'},2000);</script>";
        }

        $conn->close();
    } else {
        echo "Будь ласка, заповніть всі поля форми!";
        echo "<script>setTimeout(function(){location.href='repair.php'},2000);</script>";
    }
?>