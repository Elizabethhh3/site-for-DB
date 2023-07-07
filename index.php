<html>
<head>
    <meta charset="UTF-8">
    <title>Головна сторінка</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
    .content p, ul {
        font-size: large;
    }
    .imagess {
    width: 250px;
    height: auto;
    border: 2px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    }
    </style>
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
        <h1>Вітаємо вас на сайті нашого підприємства catPhone!</h1>
        
        <h2>Зламався телефон?</h2>
        <p>Можливо котик випадково погриз корпус? Не спішіть сварити його! У нас ви можете відремонтувати його або придбати новий за дуже приємною ціною!</p>
        <img class="imagess" src="images/kys.jpg">
        <p><b>catPhone</b>. Робимо щасливими і котиків, і клієнтів! <i>(частина прибутку іде на фонди для бездомних котів).</i></p>
        <img class="imagess" src="images/catiphone.jpg">
        <h2>Про нас</h2>
        <p>Ми є підприємством, яке динамічно розвивається та забезпечує своїх клієнтів сучасними мобільними телефонами високої якості за дуже привабливими цінами.</p>
        
        <h2>Наші послуги</h2>
        <ul>
            <li>Продаж нових мобільних телефонів;</li>
            <li>Ремонт та сервісне обслуговування мобільних телефонів, придбаних у нас раніше;</li>
            <li>Замовлення та доставка придбаних або відремонтованих мобільних телефонів.</li>
        </ul>
        
        <h2>Наші клієнти</h2>
        <p>Ми пишаємося нашими клієнтами, які отримують надійний сервіс та якісний товар від нас.</p>
        
        <h2>Наші контакти</h2>
        <p>Заповніть ваше замовлення на сайті або зв'яжіться з нами за допомогою:</p>
        <ul>
            <li>Телефон: +380988888888</li>
            <li>Email: catPhone@gmail.com</li>
            <li>Адреса: вул. Котика, 1, м. Львів</li>
        </ul>
        
        <img class="image" src="images/shuush.jpg">
    </div>
    
    <?php
    // З'єднання з базою даних
    $conn = new mysqli("localhost", "root", "123456", "enterprise");
    if ($conn->connect_error) {
        die("Помилка з'єднання з базою даних: " . $conn->connect_error);
    }
    ?>
</body>
</html>