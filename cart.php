<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Cart - CAS Centenary</title>
    <?php include './includes/basehead.html'; ?>
</head>

<body>
<?php 
session_start();
require_once './includes/connect.inc';
include './includes/nav.php';

//redirect user if not logged in
if (isset($_SESSION['iduser'])) {
    $iduser = $_SESSION['iduser'];
} else {
    header ("Location: login.php");
    exit();
}

//query to get idcart and see if it is ordered
$cart_q = "SELECT idcart, ordered FROM cart WHERE iduser = $iduser";

// if query is successful, set $idcart variable
if ($cart_r = $conn->query($cart_q)) {
    $row = $cart_r->fetch_assoc();
    $idcart = $row['idcart'];

    //if the cart is already ordered, redirect
    if ($row['ordered'] == 1) {
        header ("Location: checkout.php");
        exit();
    }

} else {
    echo "Error fetching data: " . mysqli_error($conn);
}



//query to show all the user's cart items
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
        <div class="col-12 col-lg-8 pe-4">
            <h1 class="m-3 ms-0">My Cart</h1>
            
            <?php
            $total_price = 0;
            $total_items = 0;
                
            if ($result->num_rows == 0) {
                //if they don't have anything in the cart
                echo '<p>You currently have nothing in your cart. Go to the shop to add some items!</p>';
            
            } else {
                // loop through cart items
                while($row = $result->fetch_assoc()) {
                    //calculate total price of an item in the cart
                    $item_total_price = $row['item_quantity'] * $row['price'];

                    //adds price to cart total price
                    $total_price += $item_total_price;

                    //adds number of items to the total item tally
                    $total_items += $row['item_quantity'];

                    $imagepath = "./item_images/$row[image_url]";

                    echo "
                    <div class='row d-flex justify-content-between align-items-center cart-row'>
                        <div class='col-2 pe-0 justify-content-center d-flex'>
                            <img class='cart-img py-1' src='";

                            //if image exists show image, if not show "no image available"
                            if (!file_exists($imagepath) || empty($row['image_url'])) {
                                echo "./item_images/no_img.png"; }
                            else {echo $imagepath;}
                            echo "' alt='$row[name]'>

                        </div>
                        <div class='col-3'>
                            <h6 class='mb-0 mb-lg-2'>$row[name]</h6>
                            <p class='mb-0'>$" . number_format($row['price'], 2) . "</p>
                        </div>
                        <div class='col-3 d-flex justify-content-center'>";

                    // form for updating item quantity with buttons
                    echo "
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
                            <h6 class='mb-0 text-center'>$" . number_format($item_total_price, 2) . "</h6>
                        </div>
                        <div class='col-1 text-end'>
                            <a href='delete_cart_item.php?id=$row[idproduct]' class='delete-icon'><i class='fas fa-trash'></i></a>
                        </div>
                    </div>";  //closing <div class='row d-flex ...'>
                    //echo '$row[name], $row[item_quantity]';
                }
            }
            ?>

        </div> <!--closing <div class="col-12 ..."> -->

        <!-- showing total price of cart -->
        <div class="col-lg-4 col-12">
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
            <a class="btn btn-green mt-3 w-100" href="checkout.php">Place Order</a>
        </div>
        
    </div>

</div> <!--closing <div class="container"> -->

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

    //decrease quantity of item on click
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