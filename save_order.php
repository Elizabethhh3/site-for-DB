<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientId = $_POST["client"];
    $productId = $_POST["product"];
    $quantity = $_POST["quantity"];
    $date = $_POST["date"];

    if (!empty($clientId) && !empty($productId) && !empty($quantity) && !empty($date)) {
        $conn = new mysqli("localhost", "root", "123456", "enterprise");
        if ($conn->connect_error) {
            die("Помилка з'єднання з базою даних: " . $conn->connect_error);
        }

        // Екранування даних перед вставкою
        $clientId = mysqli_real_escape_string($conn, $clientId);
        $productId = mysqli_real_escape_string($conn, $productId);
        $quantity = mysqli_real_escape_string($conn, $quantity);
        $date = mysqli_real_escape_string($conn, $date);

        foreach ($conn->query("SELECT MAX(id_order) FROM orders") as $row) {
            $id = $row['MAX(id_order)'] + 1;
        }

        $sql = "INSERT INTO orders (id_order, id_client, id_product, quantity, date_order, status_order, payment_order) 
                VALUES ($id, $clientId, $productId, $quantity, '$date', 'в обробці', 'неоплачено')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>setTimeout(function(){location.href='orders.php'},500);</script>";
        } else {
            echo "Помилка при додаванні замовлення: " . $conn->error;
            echo "<script>setTimeout(function(){location.href='orders.php'},2000);</script>";
        }

        $conn->close();
    } else {
        echo "Будь ласка, заповніть всі поля форми!";
        echo "<script>setTimeout(function(){location.href='orders.php'},2000);</script>";
    }
}
?>