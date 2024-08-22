
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

    $query="DELETE FROM product WHERE idproduct = $idproduct"; 
    $result = $conn->query($query);
}

else {
    echo 'the page you are looking for does not exist'; //redirect to error page
}
 
