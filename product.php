
<?php
session_start();
require_once ('./includes/connect.inc');

if (isset($_GET['id'])) {
    $idproduct = $_GET['id'];

    $query="SELECT * FROM product WHERE idproduct = $idproduct"; 
    $result = $conn->query($query);

    $row = $result->fetch_assoc(); //since idproduct is unique, don't need to validate number of rows
}

else {
    echo 'the page you are looking for does not exist'; //redirect to error page
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

<div class="row">

<div class="col-md-6">
<img src='./images/<?=$row['image_url']?>.jpg' class='card-img-top' alt='$row[name]'>
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
    {echo "<button class='btn btn-danger' href='editproduct.php?id=$row[idproduct]'>EDIT PRODUCT</button>";} ?>


</div>
            
</div>
</body>
</html>

