<?php

session_start();

include "includes/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = $_POST["login"];
    $password = $_POST["password"];

    if (empty($login) || empty($password)) {
        $error = "Заполните логин и пароль";
    } else {

        $sql = "SELECT * FROM users
                WHERE login='$login'
                AND password='$password'";

        $result = mysqli_query($conn, $sql);

        $user = mysqli_fetch_assoc($result);

        if ($user) {

            $_SESSION["user"] = $user;

            if ($user["role"] == "admin") {
                header("Location: admin/index.php");
                exit;
            } else {
                header("Location: index.php");
                exit;
            }

        } else {
            $error = "Неверный логин или пароль";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход | Конференции.РФ</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="form-page">

    <div class="card form-box">

        <h1>Вход</h1>

        <?php if ($error): ?>
            <div class="message error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <input type="text" name="login" placeholder="Логин">

            <input type="password" name="password" placeholder="Пароль">

            <button class="btn">Войти</button>

        </form>

        <p>
            Еще не зарегистрированы?
            <a href="register.php">Регистрация</a>
        </p>

    </div>

</div>

</body>
</html>