<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home - CAS Centenary</title>
    <?php include './includes/basehead.html'; ?>
</head>
<body>
    
<?php 
session_start();
require_once './includes/connect.inc';
include './includes/nav.php';
//echo $_SESSION['admin'];
?>
<div class="container">
    <h1 class="mt-4 mt-md-3 text-center">Welcome to the CAS Centenary Website!</h1>
    <div class="row py-2 align-items-center">

        <div class="col-md-6 order-md-1 order-2 mt-2">
            <div id="homeCarousel" class="carousel slide my-2" data-bs-ride="carousel">

                <!-- indicator lines on carousel at bottom-->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>

                <!-- carousel images -->
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

                <!-- carousel next and previous image controls -->
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

        <div class="col-md-6 order-md-2 order-1">
            <p>Join us in our celebrations for 100 years of quality Christian education at Christchurch Adventist School. On this website, you can register for events at the reunion and buy CAS merchandise.</p>
            <p>Date: Friday 25th to Sunday 27th of April, 2025.</p>
            <p>Events open to all CAS Alumni.</p>
            
            <?php
            if (isset($_SESSION['iduser'])) {
                $iduser = $_SESSION['iduser'];
                
                $query = "SELECT * FROM `registration` WHERE iduser = $iduser";
                $result = $conn->query($query);

                // if the user has already registered, show thank you for booking
                if ($result->num_rows > 0) {
                    echo "<p class='my-2 fw-bold thanks'>Thank you for booking. We hope to see you next year!</p>";
                
                } else { //show register button if they haven't already
                echo "<p>Book your spot for the reunion!</p>
                <a class='btn btn-green me-3' href='register.php'>Register Now!</a>"; //the button is weird when i click on it
                }

            } else { //if they haven't logged in
                echo "<p>Create an account to book one of the limited spaces available at the reunion.</p>
                <a class='btn btn-green me-3' href='signup.php'>Sign Up Now!</a>";
            }

            //admin buttons for viewing attendees and adding events
            if (isset($_SESSION['admin'])) {
                echo "<a class='btn btn-red' href='attendees.php'>View attendees</a>";
                echo "<a class='btn btn-red ms-3' href='add_event.php'>Add an event</a>";}
            ?>
            
        </div><!-- closing class="col-md-6" -->

    </div> <!--closing class="row" -->
</div>

<?php include './includes/footer.html'?>

</body>
</html>


