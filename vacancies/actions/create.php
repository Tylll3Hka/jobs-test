<?php
$db = require_once $_SERVER['DOCUMENT_ROOT'].'/db.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';
userVerification();

$user_id = $_POST['user_id'];
$name = $_POST['name'];
$slug = generateUniqueSlug($name,$db);
$salaryFrom = $_POST['salaryFrom'];
$salaryTo = $_POST['salaryTo'];
$experience = $_POST['experience'];
$position = $_POST['position'];
$skills = $_POST['skills'];
$location = $_POST['location'];
$description = $_POST['description'];
$employment = $_POST['employment'];
$category = $_POST['category'];

$query = "INSERT INTO vacancies (name,slug, salary_from, salary_to, experience,position, skill_level, location, description, type_employment_id, category_id,user_id) 
VALUES (:name, :slug, :salaryFrom, :salaryTo, :experience,:position, :skills, :location, :description, :type_employment_id, :category_id, :user_id)";


if(
    empty($name) || empty($salaryFrom) || empty($salaryTo) || empty($experience) || empty($skills) || empty($location) || empty($employment) || empty($category)
) {
    echo "заполните все поля";
    exit();
}
$stmt = $db->prepare($query);
$stmt->execute([
    'name' => $name,
    'slug' => $slug,
    'salaryFrom' => $salaryFrom,
    'salaryTo' => $salaryTo,
    'experience' => $experience,
    'position' => $position,
    'skills' => $skills,
    'location' => $location,
    'description' => $description,
    'type_employment_id' => $employment,
    'category_id' => $category,
    'user_id' => $user_id
]);
header("location: ../");