<?php
session_start();
require_once 'includes/connect.inc';

//if not admin, redirect
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['iduser'])) {
    if ($result->num_rows == 1) {  
        //get iduser of the user in the database that paid for their booking
        $iduser = $_GET['iduser']; 

    } else { //iduser doesn't exist in database
        header("HTTP/1.0 404 Not Found");
        include '404.php';
        exit();
    }

} else { //no iduser sent in URL
    header("HTTP/1.0 404 Not Found");
    include '404.php';
    exit();
}

$update_q = "UPDATE user SET event_paid = 1 WHERE iduser = $iduser";
$update_r = $conn->query($update_q);
 
if ($update_r) {
    //successful update
    header("Location: attendees.php");
    exit();

} else {
    echo "Error: " . mysqli_error($conn);
}

