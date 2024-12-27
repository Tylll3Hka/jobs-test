<?php
$db = require_once $_SERVER['DOCUMENT_ROOT'].'/jobboard2/db.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/jobboard2/function.php';
session_start();
userVerification();


$user_id = $_SESSION['user_id'];
$login = $_POST["login"];
$pass = $_POST["pass"];
$email = $_POST["email"];

$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->execute(['id' => $user_id]);
$user =$stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM users WHERE login = :login OR email = :email";
$stmt= $db->prepare($sql);
$stmt->execute([
    'login' => $login,
    'email' => $email
]);
$protectUniq = $stmt;


$sql = "UPDATE users SET login = :login, email = :email, photo_path = :photo_path WHERE id = :user_id";

if (empty($login) || empty($pass) || empty($email)) {
    echo "заполните все поля";
}  else{
    if ($pass != $user['pass']) {
        echo "Неверный пароль";
    } else {
        if ($protectUniq->rowCount() > 0) {
            echo "Такой логин или почта уже используются";
        }else {
            if (empty($_FILES["photo"]['tmp_name']) && $user['photo_path']!="../uploads/avatar.png")
            {
                $photo_name =  $user['photo_path'];
            } else {
                $photo_name = generateName();
                $photo_path = "../uploads/";
                move_uploaded_file($_FILES['photo']['tmp_name'], '../' . $photo_path . $photo_name);
            }
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    'login' => $login,
                    'email' => $email,
                    'photo_path' => $photo_path . $photo_name,
                    'user_id' => $user_id
                ]);
            header("location: ../");
        }
    }
}
