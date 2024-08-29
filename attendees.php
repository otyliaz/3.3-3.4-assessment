<!DOCTYPE html>
<html lang="en">
<head>
    <title>CAS Centenary</title>
    <?php include './includes/basehead.html'; ?>
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

$query = "SELECT user.iduser, user.username, user.email, user.fname, user.lname, user.grad_year, cart.idcart, cart.paid
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
    <h2 class="text-center pt-3">Users</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Graduation Year</th>
                <th>Booked Events</th>
                <th>Order Items</th>
                <th>Paid</th>
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
                    
                    $cart_q = "SELECT product.name AS product_name, product.price, cart_item.item_quantity, cart.ordered, cart.idcart
                    FROM cart_item
                    JOIN product ON cart_item.idproduct = product.idproduct
                    JOIN cart ON cart.idcart = cart_item.idcart
                    WHERE cart_item.idcart = $row[idcart] AND cart.ordered=1";

                    $cart_r = $conn->query($cart_q);
                    
                    $event_q = "SELECT event.name AS event_name 
                    FROM registration 
                    JOIN user ON registration.iduser = user.iduser 
                    JOIN event ON event.idevent = registration.idevent 
                    WHERE registration.iduser = $row[iduser]";

                    $event_r = $conn->query($event_q);

                    echo "
                    <tr>
                        <td>$row[iduser]</td>
                        <td>$row[username]</td>
                        <td>$row[fname]</td>
                        <td>$row[lname]</td>
                        <td>$row[grad_year]</td>
                        <td>";
                        
                    while($event = $event_r->fetch_assoc()) {
                        echo $event['event_name'] . "<br>";
                    }
                        
                    echo "</td>
                        <td>";
                        
                    while($order = $cart_r->fetch_assoc()) {
                        echo $order['product_name'] . " x" . $order['item_quantity'] . "<br>";
                    }
                echo "</td>
                    <td>";

                    //if they've paid, show tick
                    if ($row['paid'] == 1) { 
                        echo "<p class='mb-0 text-center'> Paid <i class='fa fa-check-square' aria-hidden='true'></i></p>";
                    } else if ($cart_r->num_rows > 0){ // if they have items ordered,
                        echo "<a class='btn btn-red' href='mark_paid.php?idcart=$row[idcart]'>Mark as paid</a>";
                    }
                    
                echo "</td>
                    </tr>";
                }
            } 
            
            ?>
        </tbody>
    </table>
</div>

<?php include './includes/footer.html'?>
</body>
</html>
