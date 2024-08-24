<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home - CAS Centenary</title>
    <?php include ('./includes/basehead.html'); ?>
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
                        <img src="./images/history1.jpg" class="w-100 h-100" alt="CAS school photo">
                    </div>
                    <div class="carousel-item">
                        <img src="./images/history2.jpg" class="w-100 h-100" alt="CAS school photo">
                    </div>
                    <div class="carousel-item">
                        <img src="./images/history3.jpg" class="w-100 h-100" alt="CAS school photo">
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
            <p>Join us in our celebrations for 100 years of quality Christian education at Christchurch Adventist School!</p>
            <p>John 1:5 "The light shines in the darkness, and the darkness can never extinguish it."</p>
            <p>Friday 25th to Sunday 27th of April, 2025. Open to all CAS Alumni</p>
        </div>

    </div>

    <div class="row">

        <?php
        if (isset($_SESSION['iduser'])) {
            $iduser = $_SESSION['iduser'];

        } else {
            echo "<p>Create an account to book one of the limited spaces available at the reunion.</p>";
        }
        ?>

    </div>
</div>
</body>
</html>


