<html>
<head>
    <meta charset="UTF-8">
    <title>Ремонт</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div class="navbar">
    <span class="logo">catPhone</span>
    <a href="index.php">На головну</a>
    <a href="sample.php">ТОП-10</a>
    <a href="zvit.html">Звіти</a>
    <a href="clients.php">Клієнти</a>
    <a href="products.php">Товари</a>
    <a href="orders.php">Замовлення</a>
    <a href="repair.php">Ремонт</a>
    <a href="employee.php">Працівники</a>
</div>
<div class="content">
    <h1 style="font-size: 22px;">Ремонт</h1>
    <div class="search-container">
    <form method="GET" action="repair.php" class="search-form">
        <input type="text" name="search" placeholder="Введіть ПІБ, модель або виконавця" class="search-input">
        <input class="search-button" type="submit" value="Пошук">
    </form>
</div>
    <?php
    // З'єднання з базою даних
    $conn = new mysqli("localhost", "root", "123456", "enterprise");
    if ($conn->connect_error) {
        die("Помилка з'єднання з базою даних: " . $conn->connect_error);
    }

    // Перевірка, чи було введено пошуковий запит
    if (isset($_GET['search'])) {
        $search = $_GET['search'];

        // Запит до бази даних з урахуванням пошукового запиту
        $sql = "SELECT repair.id_repair, clients.pib_client, repair.serial_number, repair.problem_description,
        repair.date_receive, repair.status_repair, repair.price_repair, repair.payment_repair, employee.pib_employee,
        products.model, products.manufacturer
        FROM repair
        JOIN clients ON repair.id_client = clients.id_client
        JOIN employee ON repair.id_employee = employee.id_employee
        LEFT JOIN products ON repair.serial_number = products.serial_number
        WHERE clients.pib_client LIKE '%$search%' OR products.model LIKE '%$search%' OR employee.pib_employee LIKE '%$search%'";
    } else {
        // Запит до бази даних без пошукового запиту
        $sql = "SELECT repair.id_repair, clients.pib_client, repair.serial_number, repair.problem_description,
        repair.date_receive, repair.status_repair, repair.price_repair, repair.payment_repair, employee.pib_employee,
        products.model, products.manufacturer
        FROM repair
        JOIN clients ON repair.id_client = clients.id_client
        JOIN employee ON repair.id_employee = employee.id_employee
        LEFT JOIN products ON repair.serial_number = products.serial_number";
    }

    // Додано сортування за датою, статусом ремонту та ціною
    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
        switch ($sort) {
            case 'date_asc':
                $sql .= " ORDER BY repair.date_receive ASC";
                break;
            case 'date_desc':
                $sql .= " ORDER BY repair.date_receive DESC";
                break;
            case 'status_asc':
                $sql .= " ORDER BY repair.status_repair ASC";
                break;
            case 'status_desc':
                $sql .= " ORDER BY repair.status_repair DESC";
                break;
            case 'price_asc':
                $sql .= " ORDER BY repair.price_repair ASC";
                break;
            case 'price_desc':
                $sql .= " ORDER BY repair.price_repair DESC";
                break;
        }
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Виведення даних у вигляді таблиці
        echo "<table>";
        echo "<tr><th>ID ремонту</th><th>ПІБ клієнта</th><th>Модель</th><th>Виробник</th><th>Серійний номер</th>
        <th>Опис проблеми</th>
        <th>Дата прийому <a href='repair.php?sort=date_asc' class='sort-arrow sort-asc'></a> <a href='repair.php?sort=date_desc' class='sort-arrow sort-desc'></a></th>
        <th>Статус ремонту <a href='repair.php?sort=status_asc' class='sort-arrow sort-asc'></a> <a href='repair.php?sort=status_desc' class='sort-arrow sort-desc'></a></th>
        <th>Ціна <a href='repair.php?sort=price_asc' class='sort-arrow sort-asc'></a> <a href='repair.php?sort=price_desc' class='sort-arrow sort-desc'></a></th>
        <th>Оплата</th><th>Виконавець ремонту</th><th style='padding-left: 100px;'>Дії</th></tr>";
        while ($row = $result->fetch_assoc()) {        
            echo "<tr>";
            echo "<td>" . $row["id_repair"] . "</td>";
            echo "<td>" . $row["pib_client"] . "</td>";
            echo "<td>" . $row["model"] . "</td>";
            echo "<td>" . $row["manufacturer"] . "</td>";
            echo "<td>" . $row["serial_number"] . "</td>";
            echo "<td>" . $row["problem_description"] . "</td>";
            echo "<td>" . $row["date_receive"] . "</td>";
            echo "<td>" . $row["status_repair"] . "</td>";
            echo "<td>" . $row["price_repair"] . "</td>";
            echo "<td>" . $row["payment_repair"] . "</td>";
            echo "<td>" . $row["pib_employee"] . "</td>";
            echo "<td>";
            echo "<a class='edit-button' href='edit_repair.php?id=" . $row["id_repair"] . "'>Редагувати</a>";
            echo "<a class='delete-button' href='delete_repair.php?id=" . $row["id_repair"] . "'>Видалити</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Немає даних для відображення";
    }
    // Закриття з'єднання
    $conn->close();
    ?>
    <div class="add-button-container">
        <a href="add_repair.php" class="add-button">Додати новий запис</a>
    </div>
</div>
</body>
</html>