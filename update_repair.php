<?php
// З'єднання з базою даних
$conn = new mysqli("localhost", "root", "123456", "enterprise");
if ($conn->connect_error) {
    die("Помилка з'єднання з базою даних: " . $conn->connect_error);
}

// Перевірка, чи передано ID ремонту через POST-запит
if (isset($_POST['id'])) {
    $repairId = $_POST['id'];
    $pibClient = $_POST['pib_client'];
    $productSerialNumber = $_POST['product'];
    $problemDescription = $_POST['problem_description'];
    $dateReceive = $_POST['date_receive'];
    $statusRepair = $_POST['status_repair'];
    $priceRepair = $_POST['price_repair'];
    $paymentRepair = $_POST['payment_repair'];
    $employeeId = $_POST['employee'];

        // Оновлення даних ремонту в таблиці repair
        $repairSql = "UPDATE repair
                      SET serial_number = '$productSerialNumber',
                          problem_description = '$problemDescription',
                          date_receive = '$dateReceive',
                          status_repair = '$statusRepair',
                          price_repair = '$priceRepair',
                          payment_repair = '$paymentRepair',
                          id_employee = $employeeId
                      WHERE id_repair = $repairId";

        // Оновлення ПІБ клієнта в таблиці clients
        $updateClientSql = "UPDATE clients SET pib_client = '$pibClient' WHERE id_client = (SELECT id_client FROM repair WHERE id_repair = $repairId)";

        // Оновлення серійного номеру товару в таблиці products
        $updateProductSql = "UPDATE products SET serial_number = '$productSerialNumber' WHERE serial_number = '$productSerialNumber'";

        // Розпочати транзакцію
        $conn->autocommit(FALSE);

        // Виконати запити оновлення в рамках однієї транзакції
        $success = TRUE;
        $conn->query($repairSql) ? null : $success = FALSE;
        $conn->query($updateClientSql) ? null : $success = FALSE;
        $conn->query($updateProductSql) ? null : $success = FALSE;

        if ($success) {
            $conn->commit(); // Застосувати зміни
            echo "<script>setTimeout(function(){location.href='repair.php'},500);</script>";
        } else {
            $conn->rollback(); // Скасувати зміни у випадку помилки
        }
        $conn->autocommit(TRUE); // Ввімкнути автокоміт після виконання запитів
} else {
    echo "Не передано ID ремонту";
    echo "<script>setTimeout(function(){location.href='repair.php'},2000);</script>";
}
// Закриття з'єднання
$conn->close();
?>