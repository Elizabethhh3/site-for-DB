<html>
<head>
    <meta charset="UTF-8">
    <title>Товари</title>
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
    <h1 style="font-size: 22px;">Товари</h1>
    <div class="search-container">
    <form method="GET" action="products.php" class="search-form">
        <input type="text" name="search" placeholder="Введіть виробника або колір товару" class="search-input">
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
    $sql = "SELECT * FROM products WHERE manufacturer LIKE '%$search%' OR color LIKE '%$search%'";
} else {
      // Запит до бази даних без урахування пошукового запиту
      $orderBy = isset($_GET['order']) ? $_GET['order'] : 'id_product';
      if ($orderBy === 'manufacturer_asc') {
          $sql = "SELECT * FROM products ORDER BY manufacturer ASC";
      } elseif ($orderBy === 'manufacturer_desc') {
          $sql = "SELECT * FROM products ORDER BY manufacturer DESC";
      } elseif ($orderBy === 'price_product_asc') {
          $sql = "SELECT * FROM products ORDER BY price_product ASC";
      } elseif ($orderBy === 'price_product_desc') {
          $sql = "SELECT * FROM products ORDER BY price_product DESC";
      } elseif ($orderBy === 'warranty_asc') {
          $sql = "SELECT * FROM products ORDER BY warranty ASC";
      } elseif ($orderBy === 'warranty_desc') {
          $sql = "SELECT * FROM products ORDER BY warranty DESC";
      } else {
          $sql = "SELECT * FROM products";
      }
  }

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Виведення даних у вигляді таблиці
    echo "<table>";
    echo "<tr>
            <th>ID</th>
            <th>Модель</th>
            <th>Виробник <a href='products.php?order=manufacturer_asc' class='sort-arrow sort-asc'></a> <a href='products.php?order=manufacturer_desc' class='sort-arrow sort-desc'></a></th>
            <th>Процесор</th>
            <th>Колір</th>
            <th>Серійний номер</th>
            <th>Ціна <a href='products.php?order=price_product_asc' class='sort-arrow sort-asc'></a> <a href='products.php?order=price_product_desc' class='sort-arrow sort-desc'></a></th>
            <th>Кількість на складі</th>
            <th>Гарантія <a href='products.php?order=warranty_asc' class='sort-arrow sort-asc'></a> <a href='products.php?order=warranty_desc' class='sort-arrow sort-desc'></a></th>
            <th style='padding-left: 100px;'>Дії</th>
        </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id_product"] . "</td>";
        echo "<td>" . $row["model"] . "</td>";
        echo "<td>" . $row["manufacturer"] . "</td>";
        echo "<td>" . $row["processor"] . "</td>";
        echo "<td>" . $row["color"] . "</td>";
        echo "<td>" . $row["serial_number"] . "</td>";
        echo "<td>" . $row["price_product"] . "</td>";
        echo "<td>" . $row["quantity_stock"] . "</td>";
        echo "<td>" . $row["warranty"] . "</td>";
        echo "<td>";
        echo "<a class='edit-button' href='edit_product.php?id=" . $row["id_product"] . "'>Редагувати</a>";
        echo "<a class='delete-button' href='delete_product.php?id=" . $row["id_product"] . "'>Видалити</a>";
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
        <a href="add_product.html" class="add-button">Додати новий запис</a>
    </div>
</div>
</body>
</html>