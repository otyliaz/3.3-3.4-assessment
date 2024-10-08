<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Attendees - CAS Centenary</title>
    <?php include './includes/basehead.html'; ?>
</head>

<?php
session_start();
require_once "includes/connect.inc";
include './includes/nav.php';

//if not admin, redirect the user o index
if (!isset($_SESSION['admin'])) {
    header ("Location: index.php");
    exit();
}

// huge query
$query = "SELECT user.iduser, user.username, user.email, user.fname, user.lname,
 user.grad_year, cart.idcart, cart.paid as order_paid, user.event_paid
FROM user JOIN cart on user.iduser = cart.iduser";

//if query is successful
if ($result = $conn->query($query)) {
    while($row = $result->fetch_assoc()) {
        //puts all fetched data into an array
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
                <th>Events Paid</th>
                <th>Order Items</th>
                <th>Order Paid</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // if no results found,
            if (empty($data_result)) {
                echo "<tr>
                    <td colspan='7' class='text-center'>No users found.</td>
                </tr>";}
            else {
                // go through each data result
                foreach ($data_result as $row) { 

                    //select user cart info
                    $cart_q = "SELECT product.name AS product_name, product.price, cart_item.item_quantity, cart.ordered, cart.idcart
                    FROM cart_item
                    JOIN product ON cart_item.idproduct = product.idproduct
                    JOIN cart ON cart.idcart = cart_item.idcart
                    WHERE cart_item.idcart = $row[idcart] AND cart.ordered=1";

                    $cart_r = $conn->query($cart_q);
                    
                    //select user event booking info
                    $event_q = "SELECT event.name AS event_name, event.price 
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
                        
                    //if they have registered for an event
                    if ($event_r->num_rows > 0) {
                        //$20 base price for the event
                        $total_event_price = 20;

                        //loop through items
                        while($event = $event_r->fetch_assoc()) {
                            $total_event_price += $event['price'];
                            echo $event['event_name'] . "<br>";
                        }
                        echo "$" .number_format($total_event_price, 2);
                    }
                        
                    echo "</td>
                        <td>";

                    //if they've paid for event, show tick
                    if ($row['event_paid'] == 1) { 
                        echo "<p class='mb-0 text-center'> Paid <i class='fa fa-check-square' aria-hidden='true'></i></p>";
                    } else if ($event_r->num_rows > 0){ // if they have registered,
                        echo "<a class='btn btn-red' href='mark_event_paid.php?iduser=$row[iduser]'>Mark as paid</a>";
                    }

                    echo "</td>
                        <td>";
                        
                    //if ordered cart has items,
                    if ($cart_r->num_rows > 0) {
                        $order_price = 0;
                        //loop through items
                        while($order = $cart_r->fetch_assoc()) {
                            $order_price += $order['price'];
                            echo $order['product_name'] . " x" . $order['item_quantity'] . "<br>";
                            }
                        echo "$" .number_format($order_price, 2);
                    }
                echo "</td>
                    <td>";

                    //if they've paid for cart, show tick
                    if ($row['order_paid'] == 1) { 
                        echo "<p class='mb-0 text-center'> Paid <i class='fa fa-check-square' aria-hidden='true'></i></p>";
                    } else if ($cart_r->num_rows > 0){ // if they have items ordered,
                        echo "<a class='btn btn-red' href='mark_order_paid.php?idcart=$row[idcart]'>Mark as paid</a>";
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
