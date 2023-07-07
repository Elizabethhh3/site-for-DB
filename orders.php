<html>
<head>
    <meta charset="UTF-8">
    <title>Замовлення</title>
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
<!-- ... -->
<div class="content">
    <h1 style="font-size: 22px;">Замовлення</h1>
    <div class="search-container">
        <form method="GET" action="orders.php" class="search-form">
            <input type="text" name="search" placeholder="Введіть ПІБ або статус замовлення" class="search-input">
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
        $sql = "SELECT orders.id_order, clients.pib_client, products.model, products.manufacturer, orders.quantity, orders.date_order, orders.status_order, orders.payment_order FROM orders
                JOIN clients ON orders.id_client = clients.id_client
                JOIN products ON orders.id_product = products.id_product
                WHERE clients.pib_client LIKE '%$search%' OR orders.status_order LIKE '%$search%'";
    } else {
        // Запит до бази даних без урахування пошукового запиту
        $orderBy = isset($_GET['order']) ? $_GET['order'] : 'id_order';
        if ($orderBy === 'date_order_asc') {
            $sql = "SELECT orders.id_order, clients.pib_client, products.model, products.manufacturer, orders.quantity, orders.date_order, orders.status_order, orders.payment_order FROM orders
                    JOIN clients ON orders.id_client = clients.id_client
                    JOIN products ON orders.id_product = products.id_product
                    ORDER BY orders.date_order ASC";
        } elseif ($orderBy === 'date_order_desc') {
            $sql = "SELECT orders.id_order, clients.pib_client, products.model, products.manufacturer, orders.quantity, orders.date_order, orders.status_order, orders.payment_order FROM orders
                    JOIN clients ON orders.id_client = clients.id_client
                    JOIN products ON orders.id_product = products.id_product
                    ORDER BY orders.date_order DESC";
        } elseif ($orderBy === 'status_order_asc') {
            $sql = "SELECT orders.id_order, clients.pib_client, products.model, products.manufacturer, orders.quantity, orders.date_order, orders.status_order, orders.payment_order FROM orders
                    JOIN clients ON orders.id_client = clients.id_client
                    JOIN products ON orders.id_product = products.id_product
                    ORDER BY orders.status_order ASC";
        } elseif ($orderBy === 'status_order_desc') {
            $sql = "SELECT orders.id_order, clients.pib_client, products.model, products.manufacturer, orders.quantity, orders.date_order, orders.status_order, orders.payment_order FROM orders
                    JOIN clients ON orders.id_client = clients.id_client
                    JOIN products ON orders.id_product = products.id_product
                    ORDER BY orders.status_order DESC";
        } elseif ($orderBy === 'payment_order_asc') {
            $sql = "SELECT orders.id_order, clients.pib_client, products.model, products.manufacturer, orders.quantity, orders.date_order, orders.status_order, orders.payment_order FROM orders
                    JOIN clients ON orders.id_client = clients.id_client
                    JOIN products ON orders.id_product = products.id_product
                    ORDER BY orders.payment_order ASC";
        } elseif ($orderBy === 'payment_order_desc') {
            $sql = "SELECT orders.id_order, clients.pib_client, products.model, products.manufacturer, orders.quantity, orders.date_order, orders.status_order, orders.payment_order FROM orders
                    JOIN clients ON orders.id_client = clients.id_client
                    JOIN products ON orders.id_product = products.id_product
                    ORDER BY orders.payment_order DESC";
        } else {
            // Запит до бази даних без сортування
            $sql = "SELECT orders.id_order, clients.pib_client, products.model, products.manufacturer, orders.quantity, orders.date_order, orders.status_order, orders.payment_order FROM orders
                    JOIN clients ON orders.id_client = clients.id_client
                    JOIN products ON orders.id_product = products.id_product";
        }
    }
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Виведення даних у вигляді таблиці
        echo "<table>";
        echo "<tr>
                <th>ID замовлення</th>
                <th>ПІБ клієнта</th>
                <th>Назва товару</th>
                <th>Кількість</th>
                <th>Дата <a href='orders.php?order=date_order_asc' class='sort-arrow sort-asc'></a> <a href='orders.php?order=date_order_desc' class='sort-arrow sort-desc'></a></th>
                <th>Статус <a href='orders.php?order=status_order_asc' class='sort-arrow sort-asc'></a> <a href='orders.php?order=status_order_desc' class='sort-arrow sort-desc'></a></th>
                <th>Оплата <a href='orders.php?order=payment_order_asc' class='sort-arrow sort-asc'></a> <a href='orders.php?order=payment_order_desc' class='sort-arrow sort-desc'></a></th>
                <th style='padding-left: 100px;'>Дії</th>
            </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id_order"] . "</td>";
            echo "<td>" . $row["pib_client"] . "</td>";
            echo "<td>" . $row["manufacturer"] . ", " . $row["model"] . "</td>";
            echo "<td>" . $row["quantity"] . "</td>";
            echo "<td>" . $row["date_order"] . "</td>";
            echo "<td>" . $row["status_order"] . "</td>";
            echo "<td>" . $row["payment_order"] . "</td>";
            echo "<td>";
            echo "<a class='edit-button' href='edit_order.php?id=" . $row["id_order"] . "'>Редагувати</a>";
            echo "<a class='delete-button' href='delete_order.php?id=" . $row["id_order"] . "'>Видалити</a>";
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
        <a href="add_order.php" class="add-button">Додати новий запис</a>
    </div>
</div>
</body>
</html>