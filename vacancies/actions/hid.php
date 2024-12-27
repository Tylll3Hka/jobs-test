<?php
$db = require_once $_SERVER['DOCUMENT_ROOT'].'/jobboard2/db.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/jobboard2/function.php';
session_start();
userVerification();

$id = $_GET['id'];
$is_activity = (1 == $_GET['is_activity']) ? 0 : 1;
var_dump($is_activity);
$user_id = $_SESSION['user_id'];

$query = "UPDATE vacancies SET is_activity = :is_activity WHERE id = :id AND user_id = :user_id";
$stmt = $db->prepare($query);
$stmt->execute([
    'is_activity' => $is_activity,
    'id' => $id,
    'user_id' => $user_id
]);
header("location: ../");