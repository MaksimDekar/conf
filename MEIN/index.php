<?php

session_start();

include "includes/db.php";

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user"]["id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $application_id = $_POST["application_id"];
    $review = $_POST["review"];

    if (!empty($review)) {
        $sql = "UPDATE applications
                SET review='$review'
                WHERE id='$application_id'
                AND user_id='$user_id'";

        mysqli_query($conn, $sql);

        header("Location: index.php");
        exit;
    }
}

$sql = "SELECT * FROM applications
        WHERE user_id='$user_id'
        ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет | Конференции.РФ</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">

    <h1>
        Личный кабинет:
        <?php echo $_SESSION["user"]["fullname"]; ?>
    </h1>

    <p class="nav">
        <a href="index.php">Личный кабинет</a>
        <a href="create_application.php">Оформить заявку</a>
        <a href="logout.php">Выход</a>
    </p>

    <div class="card">
        <h3>Мои заявки</h3>
        <p>Просмотр истории бронирований</p>
    </div>

    <div class="card">
        <h3>Новая заявка</h3>
        <p>Бронирование помещения</p>
    </div>

    <div class="card">
        <h3>Отзывы</h3>
        <p>Отзыв доступен после завершения мероприятия</p>
    </div>

    <div class="card slider">

        <h2>Наши помещения</h2>

        <img src="img/room1.jpg" id="sliderImage" alt="Помещение">

        <div class="slider-buttons">
            <button class="btn" onclick="prevSlide()">Назад</button>
            <button class="btn" onclick="nextSlide()">Вперед</button>
        </div>

    </div>

    <div class="card">

        <h2>История заявок</h2>

        <table class="table">

            <tr>
                <th>№</th>
                <th>Помещение</th>
                <th>Дата</th>
                <th>Оплата</th>
                <th>Статус</th>
                <th>Отзыв</th>
            </tr>

            <?php while ($application = mysqli_fetch_assoc($result)): ?>

                <tr>
                    <td><?php echo $application["id"]; ?></td>
                    <td><?php echo $application["room"]; ?></td>
                    <td><?php echo $application["start_date"]; ?></td>
                    <td><?php echo $application["payment"]; ?></td>
                    <td><?php echo $application["status"]; ?></td>
                    <td>

                        <?php if ($application["status"] == "Мероприятие завершено" && empty($application["review"])): ?>

                            <form method="POST">
                                <input type="hidden"
                                       name="application_id"
                                       value="<?php echo $application["id"]; ?>">

                                <textarea name="review"
                                          placeholder="Оставьте отзыв"></textarea>

                                <button class="btn">Отправить</button>
                            </form>

                        <?php elseif (!empty($application["review"])): ?>

                            <?php echo $application["review"]; ?>

                        <?php else: ?>

                            Недоступно

                        <?php endif; ?>

                    </td>
                </tr>

            <?php endwhile; ?>

        </table>

    </div>

</div>

<script src="js/slider.js"></script>

</body>
</html>
