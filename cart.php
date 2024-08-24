<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Cart - CAS Centenary</title>
    <?php include ('./includes/basehead.html'); ?>
</head>

<body>
<?php 
session_start();
require_once('./includes/connect.inc');
include('./includes/nav.php');
if (isset($_SESSION['iduser'])) {
    $iduser = $_SESSION['iduser'];
} else {
    echo "sign in to you account to add items to cart! no thanks, i want to continue browsing";
    //exit();
    //header ("Location: login.php");
}

$cart_q = "SELECT idcart FROM cart WHERE iduser = $iduser";
$cart_r = $conn->query($cart_q);
$row = $cart_r->fetch_assoc();
$idcart = $row['idcart'];

$query = "SELECT product.name, product.image_url, product.price, cart_item.item_quantity FROM cart_item JOIN product ON cart_item.idproduct = product.idproduct WHERE cart_item.idcart = $idcart";
$result = $conn->query($query);

// if ($result){
//     //echo "yes";
// }

//echo $idcart;
?>

<div class="container">

<div class="row">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center">
            <h1>My Cart</h1>
        </div>
        
        <?php
        $total_price = 0;
        $total_items = 0;


        //while($row = $result->fetch_assoc()) {
        //    $data_result[] = $row;}
            
        if ($result->num_rows == 0) {
            echo '<p>You have nothing in your cart. go to the shop to add some items</p>';
        } else {

            while($row = $result->fetch_assoc()) {
                $item_total = $row['item_quantity'] * $row['price'];
                $total_price += $item_total;
                $total_items += $row['item_quantity'];
                $imagepath = "./images/$row[image_url]";

                echo "
                <div class='row d-flex justify-content-between align-items-center'>
                    <div class='col-md-2'>
                    <img src='";

                    if (file_exists($imagepath)) {
                        echo $imagepath; }
                    else {echo "./images/no_img.png";}
                    echo "' alt='$row[name]'>
                    </div>
                    <div class='col-md-3'>
                        <h6>$row[name]</h6>
                        <p>$$row[price]</p>
                    </div>
                    <div class='col-md-3 d-flex'>
                        <button class='btn px-2'>
                            <i class='fas fa-minus'></i>
                        </button>

                        <input min='0' name='quantity' value='$row[item_quantity]' type='number' class='form-control'>

                        <button class='btn px-2'>
                            <i class='fas fa-plus'></i>
                        </button>
                    </div>
                    <div class='col-md-3'>
                        <h6>$$item_total</h6>
                    </div>
                    <div class='col-md-1 text-end'>
                        <a href='' class='text-muted'><i class='fas fa-trash'></i></a>
                    </div>
                </div> <!--closing class='row'-->";
                //echo '<img src='./images/$row[image_url].jpg' alt='$row[name]'>';
                //echo '$row[name], $row[item_quantity]';
            }
        }
        ?>

    </div> <!--closing class="col-md-8"-->
        
    <div class="col-md-4">
        <h3 class="fw-bold">Order Summary</h3>
        <p><?=$total_items?> items // Subtotal: $<?=$total_price?></p> 
        <hr>
        <p>Total: $<?=$total_price?></p> 
        <a class="btn btn-success">Proceed to checkout</a>
    </div>
</div>

</div> <!--closing class="container"-->

</body>
</html>