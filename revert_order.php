<?php
session_start();
require_once './includes/connect.inc';

if (!isset($_SESSION['iduser'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['idcart'])) {
    $idcart = $_POST['idcart'];

    // set the cart as not ordered
    $update_q = "UPDATE cart SET ordered = 0 WHERE idcart = $idcart";
    if ($conn->query($update_q)) {
        header("Location: cart.php");
        exit();
        
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }

} else { //if the idcart is not sent
    header("HTTP/1.0 404 Not Found");
    include '404.php';
    exit();
}
