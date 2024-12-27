<?php

$db = require_once "../db.php";
session_start();

$login = $_POST['login'];
$pass = $_POST['pass'];

$queryLoginUser = $db->query("SELECT * FROM users WHERE login = '$login' AND pass = '$pass'")->rowCount()>0;
$user = $db -> query("SELECT * FROM users WHERE login = '$login'")->fetch(PDO::FETCH_ASSOC);

if (!$queryLoginUser) {
    echo "Неверный пароль или логин";
} else {
    $_SESSION['user_id'] = $user['id'];
    header("location: ../");
}