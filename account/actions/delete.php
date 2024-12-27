<?php
$db = require_once $_SERVER['DOCUMENT_ROOT'].'/jobboard2/db.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/jobboard2/function.php';
session_start();
userVerification();

$id = $_GET["id"];
$user_id = $_SESSION["user_id"];

try {
    $sql = "DELETE FROM users WHERE id = :id AND id = :user_id";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ":id" => $id,
        ":user_id" => $user_id
    ]);
} catch (PDOException $e) {
    echo "Неизвестная ошибка";
}
$_SERVER ['DOCUMENT_ROOT'] . header('location: /jobboard2/');
