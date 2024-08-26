<?php

session_start();

require_once ('./includes/connect.inc');

if (isset($_SESSION['iduser'])) {
    $iduser = $_SESSION['iduser'];
} else {
    header ("Location: index.php");
}

if (isset($_GET['id'])) {
    $idproduct = $_GET['id'];

    // get id of the user's cart
    $cart_q = "SELECT idcart FROM cart WHERE iduser = $iduser";
    $cart_r = $conn->query($cart_q);

    if ($cart_r->num_rows > 0) { //if cart exists
        $row = $cart_r->fetch_assoc();
        $idcart = $row['idcart'];

        // delete cart item
        $delete_q = "DELETE FROM cart_item WHERE idcart = $idcart AND idproduct = $idproduct";
        $delete_r = $conn->query($delete_q);

        if ($delete_r) {
            header("Location: cart.php");
        } else {
            echo "Error: " . mysqli_error($conn);
            exit();
        }

    } else {
        // echo "Cart not found.";
        header("Location: index.php");
    }
    
} else {
    header("HTTP/1.0 404 Not Found");
    include '404.php';
    exit();
}
