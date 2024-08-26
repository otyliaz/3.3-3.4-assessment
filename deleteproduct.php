
<?php
session_start();

require_once ('./includes/connect.inc');

if (!isset($_SESSION['admin'])) {
    header("Location: product.php?id=$idproduct");
    exit();
    //if not admin, then they can't delete product
}

if (isset($_GET['id'])) {
    $idproduct = $_GET['id'];

    //check if product exists
    $check_q = "SELECT * FROM product WHERE idproduct = $idproduct";
    $check_r = $conn->query($check_q);

    if ($check_r->num_rows > 0) { 

    $query="DELETE FROM product WHERE idproduct = $idproduct"; 
    $result = $conn->query($query);

        if ($result){
            header ("Location: shop.php");
            
        } else {
            echo 'There was an error in executing the query. Please try again later.';
            header ("Location: shop.php");
            exit();
        }
        
    } else {
        echo 'The product does not exist.';
        header ("Location: shop.php");
        exit();
    }
}

else {
    echo 'The page you are looking for does not exist.';
    header ("Location: shop.php");
    exit();
}
 
