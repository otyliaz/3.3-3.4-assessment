<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - CAS Centenary</title>
    <?php include './includes/basehead.html'; ?>
</head>

<?php
session_start();
require_once 'includes/connect.inc';
include './includes/nav.php';

if (isset($_SESSION['iduser'])) {
    $iduser = $_SESSION['iduser'];
} else {
    header("Location: login.php");
    exit();
}

//check if they have already registered
// $check_q = "SELECT * FROM `registration` WHERE iduser = $iduser";
// $check_r = $conn->query($check_q);

$query = "SELECT event.name AS event_name, event.price
FROM registration 
JOIN user ON registration.iduser = user.iduser 
JOIN event ON event.idevent = registration.idevent 
WHERE registration.iduser = $iduser";

$result = $conn->query($query);

?>

<body>
<div class="container mt-5 pt-5">
    <h2 class="my-4 text-center">Booking Confirmation</h2>
    <p class="text-center">Thank you for booking your events. Please make sure to pay upon arrival.</p>
    
    <div class="event-list p-2 mx-auto my-4">
        <h5 class="text-center mb-4">You have booked:</h5>

        <?php 
        if ($result->num_rows > 0) {
            // base price
            $total_price = 20;
            echo 
            "<div class='row event-item my-2'>
                <div class='col-8'>
                    <p class='m-0'>Reunion event</p>
                </div>
                <div class='col-4'>
                    <p class='text-end m-0 event-price fw-bold'>$20.00</p>
                </div>
            </div>";

            while($row = $result->fetch_assoc()) {
                //loop through booked events, and add event price to total price
                $total_price += $row['price']; 

                echo 
                "<div class='row event-item my-2'>
                    <div class='col-8'>
                        <p class='m-0'>$row[event_name]</p>
                    </div>
                    <div class='col-4'>
                        <p class='text-end m-0 event-price fw-bold'>$" . number_format($row['price'], 2) . "</p>
                    </div>
                </div>";
            }

            //show total price
            echo 
            "<hr>
            <div class='row total-row'>
                <div class='col-8'>
                    <h5>Total:</h5>
                </div>
                <div class='col-4'>
                    <h5 class='text-end'>$" . number_format($total_price, 2) . "</h5>
                </div>
            </div>";

        } else { //they have no booked events, so redirect to register page
            header("Location: register.php");
            exit();
        }
        ?>

    </div>
</div>

<?php include './includes/footer.html' ?>

</body>
</html>
