<?php

session_start();

include "includes/db.php";

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $room = $_POST["room"];
    $start_date = $_POST["start_date"];
    $payment = $_POST["payment"];

    $user_id = $_SESSION["user"]["id"];

    if (!empty($room) && !empty($start_date) && !empty($payment)) {

        $sql = "INSERT INTO applications (user_id, room, start_date, payment, status, review)
                VALUES ('$user_id', '$room', '$start_date', '$payment', 'Новая', '')";

        mysqli_query($conn, $sql);

        header("Location: index.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Оформление заявки | Конференции.РФ</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">

    <h1>Оформление заявки</h1>

    <p class="nav">
        <a href="index.php">Личный кабинет</a>
        <a href="create_application.php">Оформить заявку</a>
        <a href="logout.php">Выход</a>
    </p>

    <div class="card">

        <form method="POST">

            <label>Выберите помещение</label>
            <select name="room">
                <option value="Аудитория">Аудитория</option>
                <option value="Коворкинг">Коворкинг</option>
                <option value="Кинозал">Кинозал</option>
            </select>

            <label>Дата начала конференции</label>
            <input type="date" name="start_date">

            <label>Способ оплаты</label>
            <select name="payment">
                <option value="Наличные">Наличные</option>
                <option value="Банковская карта">Банковская карта</option>
                <option value="Безналичный расчет">Безналичный расчет</option>
            </select>

            <button class="btn">Отправить заявку</button>

        </form>

    </div>

</div>

</body>
</html>
