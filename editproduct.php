
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

if (!isset($_SESSION['admin'])) {
    header("Location: product.php?id=$idproduct");
}

if(isset($_POST['edit'])) {
        
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];

    $query = "UPDATE product SET name='$name', price=$price, stock=$stock, description='$description', image_url='$image_url' WHERE idproduct = $idproduct";
    $result = $conn->query($query);

    if ($result){
        header("Location: product.php?id=$idproduct");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
    if ($row) { //if row (product id) exists,
    echo '<title> Edit product "'.$row['name'].'" - CAS Centenary</title>';}
    include ('./includes/basehead.html'); ?>
  </head>


<body>
<?php include('./includes/nav.php');?>

<div class="container">

    <form action="editproduct.php?id=<?=$idproduct?>" method="post"> 
    <div class="form-group">
        <label for="name">Product name:</label>
        <input class="form-control" type="text" name="name" id="name" value="<?=$row['name']?>" required> 
    </div>
    <div class="form-group">
        <label for="price">Price:</label>
        <input class="form-control" type="number" name="price" id="price" step="any" value="<?=$row['price']?>" required>
    </div>
    <div class="form-group">
        <label for="stock">Stock:</label>
        <input class="form-control" type="number" name="stock" id="stock" step=1 value="<?=$row['stock']?>" required>
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <input class="form-control" type="text" name="description" id="description" value="<?=$row['description']?>" required>
    </div>
    <div class="form-group">
        <label for="image_url">Image URL:</label>
        <input class="form-control" type="text" name="image_url" id="image_url" value="<?=$row['image_url']?>" placeholder="Optional">
    </div>
    <input class="btn btn-primary" type="submit" name="edit" value="Edit product">
    </form>

</div>
            

</body>
</html>

