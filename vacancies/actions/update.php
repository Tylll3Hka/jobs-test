<?php
$db = require_once $_SERVER['DOCUMENT_ROOT'].'/jobboard2/db.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/jobboard2/function.php';
session_start();
userVerification();

$user_id = $_SESSION['user_id'];
$id = $_POST['id'];
$name = $_POST['name'];
$salaryFrom = $_POST['salaryFrom'];
$salaryTo = $_POST['salaryTo'];
$experience = $_POST['experience'];
$position = $_POST['position'];
$skills = $_POST['skills'];
$location = $_POST['location'];
$description = $_POST['description'];
$employment = $_POST['employment'];
$category = $_POST['category'];

$sql = "UPDATE vacancies 
        SET name = :name, salary_from = :salaryFrom, salary_to = :salaryTo, experience = :experience, position = :position, skill_level = :skills, location = :location, description = :description, type_employment_id = :employment, category_id = :category 
        WHERE id = :id 
        AND user_id = :user_id ";

$stmt = $db->prepare($sql);
$stmt->execute([
    ':name' => $name,
    ':salaryFrom' => $salaryFrom,
    ':salaryTo' => $salaryTo,
    ':experience' => $experience,
    ':position' => $position,
    ':skills' => $skills,
    ':location' => $location,
    ':description' => $description,
    ':employment' => $employment,
    ':category' => $category,
    ':id' => $id,
    ':user_id' => $user_id
]);
header('Location: ../');

