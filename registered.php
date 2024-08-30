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
// $check_q = "SELECT * FROM `registration` WHERE iduser = $iduser";
// $check_r = $conn->query($check_q);


$query = "SELECT event.name AS event_name, event.price
FROM registration 
JOIN user ON registration.iduser = user.iduser 
JOIN event ON event.idevent = registration.idevent 
WHERE registration.iduser = $iduser";

$result = $conn->query($query);

if ($result->num_rows == 0) {
header ("Location: register.php");
exit();
} 
?>

<body>
<div class="container justify-content-center align-items-center p-0 mt-5 pt-5">
    
<h2 class="my-4 text-center">Event booking</h2>

<p class="text-center">Thank you for successfully booking an event. Please pay on arrival. We hope to see you there!</p>
<p class="text-center fw-bold mt-4">You have booked:</p>

<?php 
while($row = $result->fetch_assoc()) {
    echo "<div class='row d-flex justify-content-center my-3'>
        <div class='col-md-6 text-center'>
        <p class='text-center mb-1 fw-bold'>". $row['event_name'] . "</p>";

        if ($row['price'] > 0) {
            echo "<p class='text-center'>$" . number_format($row['price'], 2) . "</p>"; 
        } else {
            echo "<p class='text-center'>Free of charge.</p>";
        }

        echo "</div>";
        echo "</div>";
}
?>

</div>

<?php include './includes/footer.html' ?>

</body>
</html>
