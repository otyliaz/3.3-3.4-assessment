<!DOCTYPE html>
<html lang="en">
<head>
    <title>HOME</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    
<?php 
session_start();
require_once('./includes/connect.inc');
include('./includes/nav.php');
//echo $_SESSION['admin'];
?>
<div class="container">
<div class="row">

    <div class="col-md-6">
        <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel">

            <!-- indicator lines on carousel at bottom-->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./images/history.jpg" class="w-100 h-100" alt="CAS school photo">
                </div>
                <div class="carousel-item">
                    <img src="./images/pic2.png" class="w-100 h-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="./images/pic3.png" class="w-100 h-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="col-md-6">
        <p>Celebrating 100 years of Christian education!</p>
    </div>

</div>
</div>
</body>
</html>

