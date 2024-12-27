<?php
$db = require_once "db.php";
require_once "function.php";

$vacancies_id = $_POST["id"];
$name = $_POST['name'];
$email = $_POST['email'];
$portfolio = $_POST['url'];
$cover_letter = $_POST['cover_letter'];
$file_path = 'response/';

if (!empty($_FILES["file"]['tmp_name'])) {
    $file_name = generateName();
    $file = $file_path . $file_name;
    move_uploaded_file($_FILES["file"]["tmp_name"], $file);
}else{
    $file = "";
}

$sql = "INSERT INTO response (name, email, portfolio, cover_letter, file_path, vacancies_id) VALUES (:name, :email, :portfolio, :cover_letter, :file_path, :vacancies_id)";
$stmt = $db->prepare($sql);
$stmt->execute([
"name" => $name,
"email" => $email,
"portfolio" => $portfolio,
"cover_letter" => $cover_letter,
"file_path" => $file,
"vacancies_id" => $vacancies_id
]);

header("location: /jobboard2");