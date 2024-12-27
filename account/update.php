<?php
$db = require_once "../db.php";
require_once "../function.php";
session_start();
userVerification();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="actions/update.php" method="post" enctype="multipart/form-data" style="display: flex;flex-direction: column">
    <input type="text" placeholder="Введите новый логин" name="login" required>
    <input type="email" placeholder="Введите новую почту" name="email" required>
    <input type="file" name="photo">
    <input type="text" placeholder="Введи пароль" name="pass" required>
    <input type="submit">
</form>
</body>
</html>
