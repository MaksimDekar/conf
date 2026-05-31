<?php

include "includes/db.php";

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = $_POST["login"];
    $password = $_POST["password"];
    $fullname = $_POST["fullname"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];

    if (
        empty($login) ||
        empty($password) ||
        empty($fullname) ||
        empty($phone) ||
        empty($email)
    ) {
        $error = "Заполните все поля";
    } elseif (strlen($login) < 6) {
        $error = "Логин должен быть не меньше 6 символов";
    } elseif (!preg_match("/^[a-zA-Z0-9]+$/", $login)) {
        $error = "Логин должен содержать только латинские буквы и цифры";
    } elseif (strlen($password) < 8) {
        $error = "Пароль должен быть не меньше 8 символов";
    } else {

        $check = "SELECT * FROM users WHERE login='$login'";
        $result = mysqli_query($conn, $check);

        if (mysqli_num_rows($result) > 0) {
            $error = "Такой логин уже существует";
        } else {
            $sql = "INSERT INTO users (login, password, fullname, phone, email, role)
                    VALUES ('$login', '$password', '$fullname', '$phone', '$email', 'user')";

            mysqli_query($conn, $sql);

            $message = "Регистрация прошла успешно";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация | Конференции.РФ</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="form-page">

    <div class="card form-box">

        <h1>Регистрация</h1>

        <?php if ($message): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="message error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <input type="text" name="login" placeholder="Логин">

            <input type="password" name="password" placeholder="Пароль">

            <input type="text" name="fullname" placeholder="ФИО">

            <input type="text" name="phone" placeholder="Телефон">

            <input type="email" name="email" placeholder="Email">

            <button class="btn">Зарегистрироваться</button>

        </form>

        <p>
            Уже есть аккаунт?
            <a href="login.php">Войти</a>
        </p>

    </div>

</div>

</body>
</html>