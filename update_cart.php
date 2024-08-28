
<?php

session_start();

require_once './includes/connect.inc';

if (isset($_SESSION['iduser'])) {
    $iduser = $_SESSION['iduser'];
} else {
    header ("Location: index.php");
}

if (isset($_POST['idproduct']) && isset($_POST['quantity'])) {
    $idproduct = $_POST['idproduct'];
    $quantity = $_POST['quantity'];

    if ($quantity > 0) {
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
            echo "<p>successful update</p>";
            header ("Location: cart.php");
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