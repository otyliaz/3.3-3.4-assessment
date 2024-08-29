<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - CAS Centenary</title>
    <?php include './includes/basehead.html'; ?>
</head>

<?php
session_start();
require_once "includes/connect.inc";
include './includes/nav.php';

if (isset($_SESSION['iduser'])) {
    $iduser = $_SESSION['iduser'];
} else {
    header("Location: login.php");
    exit();
}

//check if they have already registered
$check_q = "SELECT * FROM `registration` WHERE iduser = $iduser";
$check_r = $conn->query($check_q);

// if ($check_r->num_rows == 0) {
// header ("Location: register.php");
// exit();
// } 
?>

<body>
<div class="container justify-content-center align-items-center p-0 mt-5 pt-5">
    
<h2 class="my-4 text-center">Event booking</h2>

<p class="text-center">Thank you for successfully booking an event. We hope to see you at the reunion!</p>
</div>

<?php include './includes/footer.html' ?>

</body>
</html>
