<?php
session_start();
require_once 'includes/connect.inc';


//if not admin, redirect
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

//if idcart is sent in the URL
if (isset($_GET['idcart'])) {
    $idcart = $_GET['idcart']; 

    //if the idcart doesn't match in the database
    if ($result->num_rows != 1) {  
        header("HTTP/1.0 404 Not Found");
        include '404.php';
        exit();
    }
   
} else { //idcart is not sent
    header("HTTP/1.0 404 Not Found");
    include '404.php';
    exit();
}

$update_q = "UPDATE cart SET paid = 1 WHERE idcart = $idcart";
$update_r = $conn->query($update_q);
 
//if successfully set as paid, decrease stock
if ($update_r) {
    //get all items in the cart
    $fetch_items_q = "SELECT idproduct, item_quantity FROM cart_item 
    WHERE idcart = $idcart";
    $fetch_items_r = $conn->query($fetch_items_q);

    // decrease stock
    while ($row = $fetch_items_r->fetch_assoc()) {
        $idproduct = $row['idproduct'];
        $quantity = $row['item_quantity'];
        $update_stock_q = "UPDATE product SET stock = stock - $quantity WHERE idproduct = $idproduct";
        $conn->query($update_stock_q);
    }

    //successfull, so redirect
    header("Location: attendees.php");
    exit();

} else {
    echo "Error: " . mysqli_error($conn);
}