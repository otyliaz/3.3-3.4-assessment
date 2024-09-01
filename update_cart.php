
<?php

session_start();

require_once './includes/connect.inc';

if (isset($_SESSION['iduser'])) {
    //get iduser
    $iduser = $_SESSION['iduser'];

//if not logged in, go to login.php
} else {
    header ("Location: login.php");
    exit();
}

//if they change an item's quantity in the cart
if (isset($_POST['idproduct']) && isset($_POST['quantity'])) {
    $idproduct = $_POST['idproduct'];
    $quantity = $_POST['quantity'];

    //if the new quantity is negative, don't do anything
    if ($quantity < 1) {
        header ("Location: cart.php");
        exit();
    }

    // get id of the user's cart
    $cart_q = "SELECT idcart FROM cart WHERE iduser = $iduser";
    $cart_r = $conn->query($cart_q);

    if ($cart_r->num_rows > 0) { //if cart exists
        $row = $cart_r->fetch_assoc();
        $idcart = $row['idcart'];

        // update the quantity in the database
        $update_q = "UPDATE cart_item SET item_quantity = $quantity WHERE idcart = $idcart AND idproduct = $idproduct";
        $update_r = $conn->query($update_q);

        if ($update_r) {
            //echo "<p>successful update</p>";
            header ("Location: cart.php");
            exit();

        } else {
            echo "Error: " . mysqli_error($conn);
        }

    } else {
        // echo "Cart not found.";
        header("Location: cart.php");
        exit();
    }

} else { //quantity change was not updated
    header("HTTP/1.0 404 Not Found");
    include '404.php';
    exit();
}