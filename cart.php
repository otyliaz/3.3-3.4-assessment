<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Cart - CAS Centenary</title>
    <?php include './includes/basehead.html'; ?>
</head>

<body>
<?php 
session_start();
require_once'./includes/connect.inc';
include'./includes/nav.php';

if (isset($_SESSION['iduser'])) {
    $iduser = $_SESSION['iduser'];
} else {
    header ("Location: login.php");
    exit();
}

$cart_q = "SELECT idcart, ordered, paid FROM cart WHERE iduser = $iduser";
$cart_r = $conn->query($cart_q);
$row = $cart_r->fetch_assoc();
$idcart = $row['idcart'];
$paid = $row['paid'];

if ($row['ordered'] == 1) {
    header ("Location: checkout.php");
    exit();
}

$query = "SELECT product.idproduct, product.stock, product.name, product.image_url, product.price, cart_item.item_quantity 
FROM cart_item JOIN product 
ON cart_item.idproduct = product.idproduct WHERE cart_item.idcart = $idcart";
$result = $conn->query($query);

// if ($result){
//     //echo "yes";
// }

//echo $idcart;
?>

<div class="container">

<div class="row">
    <div class="col-12 col-md-8 pe-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="m-3 ms-0">My Cart</h1>
        </div>
        
        <?php
        $total_price = 0;
        $total_items = 0;

        //while($row = $result->fetch_assoc()) {
        //    $data_result[] = $row;}
            
        if ($result->num_rows == 0) {
            echo '<p>You currently have nothing in your cart. Go to the shop to add some items!</p>';
        } else {

            while($row = $result->fetch_assoc()) {
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
                    <form class='qty-group' action='update_cart.php' autocomplete='off' method='post'>
                        <p class='m-0 text-center text-muted' id='qty-label'>Quantity</p>
                        <div class='d-flex'>
                            <button type='button' class='btn btn-qty text-muted btn-decrease px-2' >
                                <i class='fas fa-minus'></i>
                            </button>

                            <input min='1' max='$row[stock]' name='quantity' value='$row[item_quantity]' type='number' class='quantity-input p-0' data-stock='$row[stock]'>
                            <input type='hidden' name='idproduct' value='$row[idproduct]'>
                            
                            <button type='button' class='btn btn-qty btn-increase text-muted px-2'>
                                <i class='fas fa-plus'></i>
                            </button>
                        </div>  
                    </form>
                    </div>
                    <div class='col-3'>
                        <h6 class='mb-0 text-center'>$" . number_format($item_total, 2) . "</h6>
                    </div>
                    <div class='col-1 text-end'>
                        <a href='delete_cart_item.php?id=$row[idproduct]' class='delete-icon'><i class='fas fa-trash'></i></a>
                    </div>
                </div> <!--closing class='row'-->";
                //echo '<img src='./images/$row[image_url].jpg' alt='$row[name]'>';
                //echo '$row[name], $row[item_quantity]';
            }
        }
        ?>

    </div> <!--closing class="col-md-8"-->

    <div class="col-md-4 col-12">
        <h2 class="m-3 pt-2 mt-5 text-center">Order Summary</h2>
        <div class="d-flex justify-content-between">
            <p class="mb-0"><?=$total_items?> items</p>
            <p class="text-end mb-0">$<?=number_format($total_price, 2)?></p> 
        </div>
        <hr>
        <div class="d-flex justify-content-between">
            <h5>Total</h5>
            <h5 class="text-end">$<?=number_format($total_price, 2)?></h5>
        </div>
        <a class="btn btn-green mt-3" href="checkout.php">Place Order</a>
    </div>

    
</div>

</div> <!--closing class="container"-->

<?php include './includes/footer.html'?>

<script>
$(document).ready(function() {
    //increase quantity of item on click
    $('.btn-increase').on('click', function(event) {
        event.preventDefault(); //prevents the form from submitting
        let $input = $(this).siblings('.quantity-input');
        let currentValue = parseInt($input.val());
        let maxStock = parseInt($input.data('stock')); //getting stock from the form

        if (currentValue < maxStock) {
            $input.val(currentValue + 1);
        }        

        //sumbits form
        $(this).closest('form').submit();

    });

    $('.btn-decrease').on('click', function(event) {
        event.preventDefault();
        let $input = $(this).siblings('.quantity-input');
        let currentValue = parseInt($input.val());
        if (currentValue > 1) {
            $input.val(currentValue - 1);
        }

        $(this).closest('form').submit();
    });
    
});
</script>
</body>
</html>