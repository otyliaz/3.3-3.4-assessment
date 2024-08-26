
<?php

if (isset($_SESSION['iduser'])) {
    $iduser = $_SESSION['iduser'];

    if (isset($_POST['idproduct']) && isset($_POST['quantity'])) {
        $idproduct = $_POST['idproduct'];
        $quantity = $_POST['quantity'];

        // update the quantity in the database
        $update_q = "UPDATE cart_item SET item_quantity = ? WHERE idcart = $row[idcart] AND idproduct = $idproduct";
        $update_r = $conn->query($update_q);

        if ($update_r) {
            echo "<p>successful update</p>";
            header ("Loaction: cart.php");
        }
    }
}

else {
    header("HTTP/1.0 404 Not Found");
    include '404.php';
    exit();
}