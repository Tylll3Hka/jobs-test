<?php
$db = require_once $_SERVER['DOCUMENT_ROOT'].'/jobboard2/db.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/jobboard2/function.php';
session_start();
userVerification();

$id = $_GET["id"];
$user_id = $_SESSION["user_id"];

$sql = "DELETE FROM vacancies WHERE id = :id AND user_id = :user_id";
$stmt = $db->prepare($sql);
$stmt->execute([
    ":id" => $id,
    ":user_id" => $user_id
]);
header("location: ../");