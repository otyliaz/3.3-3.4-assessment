<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Order - CAS Centenary</title>
    <?php include './includes/basehead.html'; ?>
</head>

<body>
<?php 
session_start();
require_once './includes/connect.inc';
include './includes/nav.php';

if (!isset($_SESSION['iduser'])) {
    header("Location: login.php");
    exit();
}

$iduser = $_SESSION['iduser'];

//gets idcart
$cart_q = "SELECT idcart, ordered, paid FROM cart WHERE iduser = $iduser";
$cart_r = $conn->query($cart_q);

if ($cart_r->num_rows > 0) { //if cart exists
    $row = $cart_r->fetch_assoc();
    $idcart = $row['idcart'];
    $ordered = $row['ordered'];
    $paid = $row['paid'];
}

//if the cart isn't already ordered 
//(to fix the problem of the stock always going down)
if ($ordered != 1) {

    // get items in cart
    $fetch_items_q = "SELECT idproduct, item_quantity FROM cart_item 
    WHERE idcart = $idcart";
    $fetch_items_r = $conn->query($fetch_items_q);
    
    if ($fetch_items_r->num_rows > 0) {
        // decrease stock
        while ($row = $fetch_items_r->fetch_assoc()) {
            $idproduct = $row['idproduct'];
            $quantity = $row['item_quantity'];
            $update_stock_q = "UPDATE product SET stock = stock - $quantity WHERE idproduct = $idproduct";
            $conn->query($update_stock_q);
        }

        // mark cart as ordered
        $update_q = "UPDATE cart SET ordered = 1 WHERE idcart = $idcart";
        if ($conn->query($update_q)) {
            $success_message = "<p>Your order has been successfully placed!</p>";
        } else {
            $error_message = "<p>There was an error processing your order. Please try again later.</p>";
        }
    } else {
        header("HTTP/1.0 404 Not Found");
        include '404.php';
        exit();
    }
}

$display_q = "SELECT product.idproduct, product.name, product.image_url, product.price, cart_item.item_quantity 
              FROM cart_item 
              JOIN product ON cart_item.idproduct = product.idproduct 
              WHERE cart_item.idcart = $idcart";
$display_r = $conn->query($display_q);

?>

<div class="container">

    <div class="row">
        <div class="col-md-8 col-12 pe-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="m-3 ms-0">My Order</h>
            </div>

            <?php
            if (isset($success_message)) {
                echo $success_message;
            }
            if (isset($error_message)) {
                echo $error_message;
            }

            if ($display_r->num_rows == 0) {
                echo '<p>You currently have nothing in your cart. Go to the shop to add some items!</p>';
            } else {
                $total_price = 0;
                $total_items = 0;

                while ($row = $display_r->fetch_assoc()) {
                    $item_total = $row['item_quantity'] * $row['price'];
                    $total_price += $item_total;
                    $total_items += $row['item_quantity'];
                    $imagepath = "./item_images/$row[image_url]";

                    echo "
                    <div class='row d-flex justify-content-between align-items-center'>
                        <div class='col-2'>
                            <img class='cart-img' src='";
                            if (file_exists($imagepath)) {
                                echo $imagepath; }
                            else {echo "./item_images/no_img.png";}
                            echo "' alt='$row[name]'>
                        </div>
                        <div class='col-3'>
                            <h6>$row[name]</h6>
                            <p class='mb-0'>$" . number_format($row['price'], 2) . "</p>
                        </div>
                        <div class='col-3 d-flex justify-content-center'>
                            <p class='mb-0'>Qty: $row[item_quantity]</p>
                        </div>
                        <div class='col-3'>
                            <h6 class='mb-0 text-center'>$" . number_format($item_total, 2) . "</h6>
                        </div>
                    </div>";
                }
            }
            ?>

            <div class="d-flex w-100 my-3 justify-content-between">
                <h3>Total price:</h3>
                <h3 class="me-5">$<?= number_format($total_price, 2) ?></h3>
            </div>
        </div>
        <div class="col-md-4 col-12 my-auto">

    <?php if ($paid == 1) {
        echo "<p>Thank you for paying for your order. If you haven't already received your items, you will receive them shortly.</p>";
    } else { 
    echo "
        <p class='mt-4'>If you would like to edit your order, please click the button below.</p>
        <p>Remember to place the order again for it to go through.</p>
        <p class='mb-0'>Pay for and pick up your items at the reunion.</p>
        <form method='post' action='revert_order.php' class='text-center'>
            <input type='hidden' name='idcart' value='$idcart'>
            <button type='submit' class='btn btn-red mt-3 w-100'>Re-open Order</button>
        </form>";
} ?>

        </div>
    </div>

</div>


<?php include './includes/footer.html'?>

</body>
</html>
