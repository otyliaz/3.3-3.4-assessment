
<?php
session_start();

require_once './includes/connect.inc';

//if not admin, redirect back to product page
if (!isset($_SESSION['admin'])) {
    header("Location: product.php?id=$idproduct");
}

//get product id from URL
if (isset($_GET['id'])) {
    
    $idproduct = $_GET['id'];

    $query="SELECT * FROM product WHERE idproduct = $idproduct"; 
    $result = $conn->query($query);

    $row = $result->fetch_assoc();

    if ($result->num_rows != 1) {  
        header("HTTP/1.0 404 Not Found");
        include '404.php';
        exit();
    }

} else {
    header("HTTP/1.0 404 Not Found");
    include '404.php';
    exit();
}

if (isset($_POST['edit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];

    $update_q = "UPDATE product SET name = ?, price = ?, stock = ?, description = ?, image_url = ? WHERE idproduct = ?";
    if ($stmt = $conn->prepare($update_q)) {
        $stmt->bind_param("sdissi", $name, $price, $stock, $description, $image_url, $idproduct);
        $stmt->execute();
        $stmt->close();

        // redirect to shop if successful
        header("Location: shop.php");
        exit();

    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
    if ($row) { 
        //if row (product id) exists, put the product name into the page title
        echo '<title> Edit product "'.$row['name'].'" - CAS Centenary</title>';
    }
    include './includes/basehead.html'; ?>
  </head>


<body>
<?php include './includes/nav.php';?>

<div class="container">

    <h1 class="my-3">Edit Product</h1>

    <!-- edit form -->
    <form action="editproduct.php?id=<?=$idproduct?>" method="post"> 
    <div class="form-group mb-3">
        <label for="name">Product name:</label>
        <input class="form-control" type="text" name="name" id="name" value="<?=$row['name']?>" required> 
    </div>
    <div class="form-group mb-3">
        <label for="price">Price:</label>
        <input class="form-control" type="number" name="price" id="price" min=0 step="any" value="<?=$row['price']?>" required>
    </div>
    <div class="form-group mb-3">
        <label for="stock">Stock:</label>
        <input class="form-control" type="number" name="stock" id="stock" min=0 step="1" value="<?=$row['stock']?>" redivred>
    </div>
    <div class="form-group mb-3">
        <label for="description">Description:</label>
        <input class="form-control" type="text" name="description" id="description" value="<?=$row['description']?>" required>
    </div>
    <div class="form-group mb-3">
        <label for="image_url">Image URL:</label>
        <input class="form-control" type="text" name="image_url" id="image_url" value="<?=$row['image_url']?>" placeholder="Optional">
    </div>
    <input class="btn btn-red mt-2" type="submit" name="edit" value="Edit product">
    </form>

</div>
      
<?php include './includes/footer.html'?>

</body>
</html>

