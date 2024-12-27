<?php

$db = require "../db.php";
require "../function.php";
session_start();

$login = $_POST["login"];
$pass = $_POST["pass"];
$email = $_POST["email"];
$photo_name = (empty($_FILES["photo"]['tmp_name'])) ? "avatar.png" : generateName();
$photo_path = "../uploads/";

if ($photo_name != "uploads/avatar.png")
    move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path.$photo_name);

$queryInsert = "INSERT INTO users (login, pass,email,photo_path) VALUES (:login, :pass, :email, :photo_path)";
$sqlValidation = $db->query("SELECT `login` FROM users WHERE login = '$login' OR  email = '$email'")->rowCount() > 0;

if (empty($login) || empty($pass) || empty($email)) {
    echo "Заплните все поля";
    exit();
} elseif ($sqlValidation) {
    echo "Такой логин или почта уже заняты";
    exit();
} else {
    try {
        $stmt = $db->prepare($queryInsert);
        $stmt->execute([
            ":login" => $login,
            ":pass" => $pass,
            ":email" => $email,
            ":photo_path" => $photo_path . $photo_name
        ]);
        $user = $db -> query("SELECT * FROM users WHERE login = '$login'")->fetch(PDO::FETCH_ASSOC);
        $_SESSION["user_id"] = $user['id'];
        header("location: ../");
    }   catch (PDOException $e) {
        echo "Неизвестная ошибка".$e->getMessage();
    }
}



