<?php
session_start();
require_once 'includes/connect.inc';

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['idcart'])) {
    $idcart = $_GET['idcart']; 
} else {
    header("HTTP/1.0 404 Not Found");
    include '404.php';
    exit();
}

$update_q = "UPDATE cart SET paid = 1 WHERE idcart = $idcart";
$update_r = $conn->query($update_q);
 
if ($update_r) {
    //successful
    header("Location: attendees.php");
} else {
    echo 'There was an error in executing the query. Please try again later.';
    header ("Location: index.php");
    exit();
}

// close the connection
mysqli_close($conn);

