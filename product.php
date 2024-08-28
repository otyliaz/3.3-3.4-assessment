<?php
session_start();
require_once './includes/connect.inc';

if (isset($_POST['idproduct'], $_POST['quantity'])) {
    
  if (isset($_SESSION['iduser'])) {
    $iduser = $_SESSION['iduser'];
  } else {
    echo "create an account to add items to cart! no thanks, i want to continue browsing";
    exit();
    //header ("Location: login.php");
  }

  //checking if user has a cart created
  $cart_q = "SELECT idcart FROM cart WHERE iduser = $iduser";
  $cart_r = $conn->query($cart_q);

  if ($cart_r->num_rows == 0) {  //if they don't have a cart created
      $create_cart_q = "INSERT INTO cart (iduser) VALUES ($iduser)";
      $create_cart_r = $conn->query($create_cart_q);

      //gets the id (auto_increment value) of the recently inserted row
      $idcart = $conn->insert_id; 

  }
  else { //if they have a cart already
    $row = $cart_r->fetch_assoc(); 
    $idcart = $row['idcart'];
  }

  $idproduct = $_POST['idproduct'];
  $quantity = $_POST['quantity'];

  //check if the product is already in the user's cart and how many
  $check_q = "SELECT item_quantity FROM cart_item WHERE idcart = $idcart AND idproduct = $idproduct";
  $check_r = $conn->query($check_q);

  if ($check_r->num_rows > 0) { //if the product is already in the cart
      $row = $check_r->fetch_assoc();
      $new_quantity = $row['item_quantity'] + $quantity;
      $update_q = "UPDATE cart_item SET item_quantity = $new_quantity WHERE idcart = $idcart AND idproduct = $idproduct";
      $update_r = $conn->query($update_q);
      if ($update_r) {
        header ("Location: cart.php");
        exit();
      } 
  } else {

    $insert_q = "INSERT INTO cart_item (idcart, idproduct, item_quantity) VALUES ($idcart, $idproduct, $quantity)";
    $insert_r = $conn->query($insert_q);
    if ($insert_r) {
      header ("Location: cart.php");
      exit();
    } 
  }
}

if (isset($_GET['id'])) {
  $idproduct = $_GET['id'];

  $query="SELECT * FROM product WHERE idproduct = $idproduct"; 
  $result = $conn->query($query);

  if ($result->num_rows > 0) { //if the idproduct exists
  $row = $result->fetch_assoc(); }

  else {
    header("HTTP/1.0 404 Not Found");
    include '404.php';
    exit();
    // header ("Location: shop.php");
  }
}

else {
  header("HTTP/1.0 404 Not Found");
    include '404.php';
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
    if ($row) { //if row (product id) exists,
    echo "<title> $row[name] - CAS Centenary</title>";}
    include './includes/basehead.html'; ?>
  </head>


<body>
<?php include './includes/nav.php';?>

<div class="container">

<div class="row">

<div class="col-md-6">
<?php echo "<img class='my-3 mt-4 img-product' src='";

$imagepath = "./item_images/$row[image_url]";

  if (file_exists($imagepath)) {
    echo $imagepath; }
  else {echo "./item_images/no_img.png";}
  
  echo "' alt='$row[name]'>" ?>
</div>

<div class='col-md-6'>
  <h2 class="mb-3 mt-5"><?=$row['name']?></h2>
  <h4 class="product-price">$<?php echo number_format($row['price'], 2); ?></h4>
  <p class="product-description mt-3"><?=$row['description']?></p>

  <?php 
  if ($row['stock'] < 1) {
    echo "<p>Sorry! This item is out of stock. Please check again another time.</p>";
  } else {
    echo "
  <p>$row[stock] in stock.</p>
  <form action='product.php?id=$idproduct' method='post' class='d-flex my-4'>
    <div class='qty-group'>
      <p class='m-0 text-center text-muted'>Quantity</p>
      <div class='d-flex'>
        <button class='btn btn-qty text-muted btn-decrease px-2' >
            <i class='fas fa-minus'></i>
        </button>

        <input min='1' max='$row[stock]' name='quantity' value='1' type='number' class='quantity-input' data-stock='$row[stock]'>
        <input type='hidden' name='idproduct' value='$row[idproduct]'>
        
        <button class='btn btn-qty text-muted btn-increase px-2'>
            <i class='fas fa-plus'></i>
        </button>
      </div>  
    </div>
    <button type='submit' class='btn btn-green ms-5'><i class='fa fa-shopping-cart' aria-hidden='true'></i>Add to cart</button>
    <input type='hidden' name='idproduct' value='$row[idproduct]'>
  </form>";
  }

  if (isset($_SESSION['admin'])) {
      echo "<a class='btn btn-red mt-3 me-2' href='editproduct.php?id=$row[idproduct]'>Edit product</a>";
      echo "<a class='btn btn-red mt-3' href='deleteproduct.php?id=$row[idproduct]'>Delete product</a>";
  } ?>
</div>
            

</div> <!--closing row div-->
</div> <!--closing container div-->

<?php include './includes/footer.html'?>

<script>
$(document).ready(function() {

  //increase quantity of item on click
  $('.btn-increase').on('click', function() {
    event.preventDefault(); // prevents the form from submitting
    let $input = $(this).siblings('.quantity-input');
    let currentValue = parseInt($input.val());
    let maxStock = parseInt($input.data('stock')); //getting stock from the form

    if (currentValue < maxStock) {
      $input.val(currentValue + 1);
    }
  });

  $('.btn-decrease').on('click', function() {
    event.preventDefault();
    let $input = $(this).siblings('.quantity-input');
    let currentValue = parseInt($input.val());
    if (currentValue > 1) {
      $input.val(currentValue - 1);
    }
  });
});
</script>
</body>
</html>