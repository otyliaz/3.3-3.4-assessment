
<?php
session_start();
require_once ('./includes/connect.inc');

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
  } else {
    //echo "Product ID: $idproduct, Quantity: $quantity";

    $insert_q = "INSERT INTO cart_item (idcart, idproduct, item_quantity) VALUES ($idcart, $idproduct, $quantity)";
    $insert_r = $conn->query($insert_q);
    if ($insert_r) {
      echo "successful";
      header ("Location: cart.php");
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
    echo "the product you are looking for does not exist";
    // header ("Location: shop.php");
  }
}

else {
  echo 'the page you are looking for does not exist';
  // header ("Location: shop.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
    if ($row) { //if row (product id) exists,
    echo "<title> $row[name] - CAS Centenary</title>";}
    include ('./includes/basehead.html'); ?>
  </head>


<body>
<?php include('./includes/nav.php');?>

<div class="container">

<div class="row">

<div class="col-md-6">
<?php echo "<img src='";

$imagepath = "./images/$row[image_url]";

  if (file_exists($imagepath)) {
    echo $imagepath; }
  else {echo "./images/no_img.png";}
  
  echo "' alt='$row[name]'>" ?>
</div>

<div class='col-md-6'>
    <h5><?=$row['name']?></h5>
    <p>Price: $<?=$row['price']?></p>
    <form action='product.php?id=<?=$idproduct?>' method='post'>
      <input type='number' name='quantity' value='1' min='1' max='<?=$row['stock']?>' placeholder='Quantity' required>
      <input type='hidden' name='idproduct' value='<?=$row['idproduct']?>'>
      <input class="btn btn-primary" type='submit' value='Add To Cart'>
    </form>
    <p>Stock: <?=$row['stock']?></p>
    <p>Description: <?=$row['description']?></p>
    
    <?php
    //if the user is an admin, show an EDIT button.
    if (isset($_SESSION['admin']))
    {echo "<a class='btn btn-danger' href='editproduct.php?id=$row[idproduct]'>EDIT PRODUCT</a>";
    echo "<a class='btn btn-danger' href='deleteproduct.php?id=$row[idproduct]'>DELETE PRODUCT</a>";} ?>
</div>
            

</div> <!--closing row div-->
</div> <!--closing container div-->
</body>
</html>

