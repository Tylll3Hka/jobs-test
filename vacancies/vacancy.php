<?php
$db = require_once "../db.php";
require_once "../function.php";
session_start();
userVerification();

$id =$_GET["id"];

$query = getVacancies();
$query .=" WHERE v.id= :id";
$stmt = $db -> prepare($query);
$stmt -> execute([ "id" => $id ]);
$vacancy = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/magnific-popup.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/themify-icons.css">
    <link rel="stylesheet" href="../css/nice-select.css">
    <link rel="stylesheet" href="../css/flaticon.css">
    <link rel="stylesheet" href="../css/gijgo.css">
    <link rel="stylesheet" href="../css/animate.min.css">
    <link rel="stylesheet" href="../css/slicknav.css">

    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="job_details_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="job_details_header">
                    <div class="single_jobs white-bg d-flex justify-content-between">
                        <div class="jobs_left d-flex align-items-center">
                            <div class="thumb">
                                <img src="<?=$vacancy['user_photo_path']?>" alt="">
                            </div>
                            <div class="jobs_conetent">
                                <a href="vacancy.php?id=<?=$vacancy['id']?>"><h4><?=$vacancy['name']?></h4></a>
                                <div class="links_locat d-flex align-items-center">
                                    <div class="location">
                                        <p> <i class="fa fa-map-marker"></i><?=$vacancy['location']?></p>
                                    </div>
                                    <div class="location">
                                        <p> <i class="fa fa-clock-o"></i> <?=$vacancy['type_employment_name']?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="jobs_right">
                            <div class="apply_now">
                                <p style="color :<?=(1 == $vacancy['is_activity']) ? 'green' : 'red'?>"><?=(1 == $vacancy['is_activity']) ? 'активная' : 'неактивная'?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="descript_wrap white-bg">
                    <div class="single_wrap">
                        <h4>Job description</h4>
                        <p><?=$vacancy['description']?></p>
                        <div class="actions" style="display: flex;gap: 80px;">
                            <a href="actions/hid.php?id=<?=$vacancy['id']?>&is_activity=<?=$vacancy['is_activity']?>"><button style="border-radius: 8px" class="btn btn-primary">Изменить статус</button></a>
                            <a href="update_vacancy.php?id=<?=$vacancy['id']?>"><button style="border-radius: 8px" class="btn btn-primary">Изменить содержание </button></a>
                            <a href="actions/delete.php?id=<?=$vacancy['id']?>"><button style="border-radius: 8px" class="btn btn-primary">Удалить вакансию</button></a>
                        </div>
                    </div>
                </div>
</body>
</html>
