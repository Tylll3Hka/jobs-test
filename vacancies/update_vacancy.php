<?php
$db = require_once "../db.php";
require_once "../function.php";
session_start();
userVerification();

$categories = $db->query("SELECT * FROM categories");
$employments = $db->query("SELECT * FROM type_employment");
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
<form action="actions/update.php" method="post">
    <input type="text" placeholder="Введите название" name="name" required>
    <input type="number" placeholder="Зарплата от " name="salaryFrom" required>
    <input type="number" placeholder="Зарплата до " name="salaryTo" required>
    <input type="number"  placeholder="Количество мест" name="position" required>
    <input type="number" placeholder="Опыт работы в месяцах" name="experience" required>
    <input type="text" placeholder="Требуемый уровень" name="skills" required>
    <input type="text" placeholder="Место работы" name="location" required>
    <select name="employment" required>
        <option value="0" >Выберите тип занятости</option>
        <?php foreach ($employments as $employment):?>
            <option value="<?=$employment['id']?>"><?=$employment['name']?></option>
        <?php endforeach;?>
    </select>
    <select name="category"  required>
        <option value="">Выберите категорию</option>
        <?php foreach ($categories as $category):?>
            <option value="<?=$category['id']?>"><?=$category['name']?></option>
        <?php endforeach;?>
    </select>
    <link href="../wysiwyg-editor-master/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <textarea maxlength="4096" name="description"></textarea>
    <script type="text/javascript" src="../wysiwyg-editor-master/js/froala_editor.pkgd.min.js"></script>
    <script>
        new FroalaEditor('textarea');
    </script>
    <input type="hidden" name="id" value="<?=$_GET['id']?>">
    <input type="submit" value="Опубликовать">
</form>
</body>
</html>