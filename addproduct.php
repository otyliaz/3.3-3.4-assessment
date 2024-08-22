
<?php
session_start();

require_once ('./includes/connect.inc');

if (!isset($_SESSION['admin'])) {
    header("Location: shop.php");
}

if(isset($_POST['add'])) {
        
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];

    $query = "INSERT INTO product (name, price, stock, description, image_url) VALUES ('$name', $price, $stock, '$description', '$image_url')";
    $result = $conn->query($query);

    if ($result){
        header("Location: shop.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Add product - CAS Centenary</title>
    <?php include ('./includes/basehead.html'); ?>
  </head>


<body>
<?php include('./includes/nav.php');?>

<div class="container">

    <form action="addproduct.php" method="post"> 
    <div class="form-group">
        <label for="name">Product name:</label>
        <input class="form-control" type="text" name="name" id="name" placeholder="Type here" required> 
    </div>
    <div class="form-group">
        <label for="price">Price:</label>
        <input class="form-control" type="number" name="price" id="price" step="any" placeholder="Type here" required>
    </div>
    <div class="form-group">
        <label for="stock">Stock:</label>
        <input class="form-control" type="number" name="stock" id="stock" step=1 placeholder="Type here" required>
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <input class="form-control" type="text" name="description" id="description" placeholder="Type here" required>
    </div>
    <div class="form-group">
        <label for="image_url">Image URL:</label>
        <input class="form-control" type="text" name="image_url" id="image_url" placeholder="Optional">
    </div>
    <input class="btn btn-primary" type="submit" name="add" value="Add product">
    </form>

</div>
            

</body>
</html>