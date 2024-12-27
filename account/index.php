<?php
$db = require_once "../db.php";
require_once "../function.php";
session_start();
userVerification();

$user_id = $_SESSION["user_id"];

$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->execute(['id' => $user_id]);
$user =$stmt->fetch(PDO::FETCH_ASSOC);
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
    <div class="container">
        <h2><?=$user['login']?></h2>
        <p><?=$user['email']?></p>
        <img src="<?=$user['photo_path']?>" alt="avatar">
        <div class="container-actions">
            <a href="update.php?id=<?=$user['id']?>">Изменить данные</a>
            <a href="actions/delete.php?id=<?=$user['id']?>">Удалить профиль</a>
        </div>
    </div>
</body>
</html>
