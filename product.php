
<?php
session_start();
require_once ('./includes/connect.inc');

if (isset($_GET['id'])) {
    $idproduct = $_GET['id'];

    $query="SELECT * FROM product WHERE idproduct = $idproduct"; 
    $result = $conn->query($query);

    if ($result->num_rows > 0) { //if the idproduct exists
    $row = $result->fetch_assoc(); }

    else {
      echo "the product you are looking for does not exist";
      header ("Location: shop.php");
    }
}

else {
    echo 'the page you are looking for does not exist';
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

$imagepath = "./images/$row[image_url].jpg";

  if (file_exists($imagepath)) {
    echo $imagepath; }
  else {echo "./images/no_img.png";}
  
  echo "' alt='$row[name]'>" ?>
</div>

<div class='col-md-6'>
    <h5><?=$row['name']?></h5>
    <p>Price: $<?=$row['price']?></p>
    <form action='cart.php' method='post'>
      <input type='number' name='quantity' value='1' min='1' max='<?=$row['stock']?>' placeholder='Quantity' required>
      <input type='hidden' name='product_id' value='<?=$row['id']?>'>
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

