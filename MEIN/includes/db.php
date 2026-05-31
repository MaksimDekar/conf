<?php

$conn = mysqli_connect(
    "MySQL-8.4",
    "root",
    "",
    "conf_exam",
    3306
);

if (!$conn) {
    die("Ошибка подключения к БД");
}
