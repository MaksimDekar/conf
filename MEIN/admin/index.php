<?php

session_start();

include "../includes/db.php";

if (!isset($_SESSION["user"])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION["user"]["role"] != "admin") {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $application_id = $_POST["application_id"];
    $status = $_POST["status"];

    $sql = "UPDATE applications
            SET status='$status'
            WHERE id='$application_id'";

    mysqli_query($conn, $sql);

    header("Location: index.php");
    exit;
}

$sql = "SELECT applications.*, users.fullname, users.phone, users.email
        FROM applications
        JOIN users ON applications.user_id = users.id
        ORDER BY applications.id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель администратора | Конференции.РФ</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container">

    <h1>Панель администратора</h1>

    <p class="nav">
        <a href="index.php">Заявки</a>
        <a href="../logout.php">Выход</a>
    </p>

    <div class="card">

        <table class="table">

            <tr>
                <th>№</th>
                <th>Пользователь</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Помещение</th>
                <th>Дата</th>
                <th>Оплата</th>
                <th>Статус</th>
                <th>Действие</th>
            </tr>

            <?php while ($application = mysqli_fetch_assoc($result)): ?>

                <tr>
                    <td><?php echo $application["id"]; ?></td>
                    <td><?php echo $application["fullname"]; ?></td>
                    <td><?php echo $application["phone"]; ?></td>
                    <td><?php echo $application["email"]; ?></td>
                    <td><?php echo $application["room"]; ?></td>
                    <td><?php echo $application["start_date"]; ?></td>
                    <td><?php echo $application["payment"]; ?></td>
                    <td><?php echo $application["status"]; ?></td>
                    <td>

                        <form method="POST">

                            <input type="hidden"
                                   name="application_id"
                                   value="<?php echo $application["id"]; ?>">

                            <select name="status">
                                <option value="Новая">Новая</option>
                                <option value="Мероприятие назначено">Мероприятие назначено</option>
                                <option value="Мероприятие завершено">Мероприятие завершено</option>
                            </select>

                            <button class="btn">Сохранить</button>

                        </form>

                    </td>
                </tr>

            <?php endwhile; ?>

        </table>

    </div>

</div>

</body>
</html>
