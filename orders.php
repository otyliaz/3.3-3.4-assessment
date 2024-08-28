<!DOCTYPE html>
<html lang="en">
<head>
    <title>CAS Centenary</title>
    <?php include './includes/basehead.html'; ?>
    <style>
        .container {
            margin-top: 20px;
        }
        .table thead th {
            text-align: center;
        }
        .table td, .table th {
            vertical-align: middle;
        }
    </style>
</head>

<?php
session_start();
require_once "includes/connect.inc";
include './includes/nav.php';

if (!isset($_SESSION['admin'])) {
    echo "You do not have permission to view this page.";
    header ("Location: index.php");
    exit();
}

$query = "SELECT user.iduser, user.username, user.email, user.fname, user.lname, user.grad_year, cart.idcart 
FROM user JOIN cart on user.iduser = cart.iduser";

if ($result = $conn->query($query)) {
    
    while($row = $result->fetch_assoc()) {
        $data_result[] = $row;
    }
} else {
    echo "Error fetching data: " . mysqli_error($conn);
}

?>

<body>
<div class="container">
    <h2 class="text-center">Users</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Graduation Year</th>
                <th>Order Items</th>
                <th>Booked Events</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (empty($data_result)) {
                echo "<tr>
                    <td colspan='7' class='text-center'>No users found.</td>
                </tr>";}
            else {
                foreach ($data_result as $row) { 
                    
                    $cart_q = "SELECT product.name AS product_name, product.price, cart_item.item_quantity, cart.ordered
                    FROM cart_item
                    JOIN product ON cart_item.idproduct = product.idproduct
                    JOIN cart ON cart.idcart = cart_item.idcart
                    WHERE cart_item.idcart = $row[idcart] AND cart.ordered=1";

                    $cart_r = $conn->query($cart_q);
                    
                    echo "
                    <tr>
                        <td>$row[iduser]</td>
                        <td>$row[username]</td>
                        <td>$row[fname]</td>
                        <td>$row[lname]</td>
                        <td>$row[grad_year]</td>
                        <td>";
                        
                        while($order = $cart_r->fetch_assoc()) {
                            echo $order['product_name'] . " x" . $order['item_quantity'] . "<br>";
                        }

                    echo "</td>
                        <td>view their events here</td>
                    </tr>";
                }
            } 
            
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
