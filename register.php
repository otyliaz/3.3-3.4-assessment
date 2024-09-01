<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - CAS Centenary</title>
    <?php include './includes/basehead.html'; ?>
</head>

<?php
session_start();
require_once "includes/connect.inc";
include './includes/nav.php';

if (isset($_SESSION['iduser'])) {
    $iduser = $_SESSION['iduser'];
} else {
    header("Location: login.php");
    exit();
}

//check if they have already registered
$check_q = "SELECT * FROM `registration` WHERE iduser = $iduser";
$check_r = $conn->query($check_q);
// $row = $check_r->fetch_assoc(); 

// echo $row;
// echo $iduser;
// if the user has already registered, redirect to new page
if ($check_r->num_rows > 0) {
    header ("Location: registered.php");
    exit();
}

if (isset($_POST['register'])) {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $grad_year = trim($_POST['grad_year']);

    if (empty($grad_year)) {
        $grad_year = null;
    }

    if (isset($_POST['selected_events'])) {
        $events = $_POST['selected_events'];
    } else {
        $events = [];
    }

    //php built-in validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Please enter a valid email.";
    } else {

        if (!empty($events)) {
            foreach ($events as $idevent) {
                $insert_q = "INSERT INTO `registration` (iduser, idevent) VALUES ($iduser, $idevent)";
                $insert_r = $conn->query($insert_q);
            }

            if ($grad_year !== null) {
                $update_q = "UPDATE `user` SET `email`=?, `fname`=?, `lname`=?, `grad_year`=? WHERE iduser=?";
                $stmt = $conn->prepare($update_q);
                $stmt->bind_param("sssii", $email, $fname, $lname, $grad_year, $iduser);
            } else {
                $update_q = "UPDATE `user` SET `email`=?, `fname`=?, `lname`=? WHERE iduser=?";
                $stmt = $conn->prepare($update_q);
                $stmt->bind_param("sssi", $email, $fname, $lname, $iduser);
            }
            
            if ($stmt->execute()) {
                $stmt->close();
                header("Location: registered.php"); 
                exit(); 
            } else {
                echo "Error updating user: " . mysqli_error($conn);
            }

        } else {
            $event_error = "Please choose at least one event.";
        }

    }

}

$display_q = "SELECT * FROM event";
$display_r = $conn->query($display_q);

if (!$display_r) {
    echo "Error fetching events: " . mysqli_error($conn);
    exit();
}
?>

<body>
    
<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 offset-md-2">   
            <h2 class="my-4">Event Booking</h2>
            
            <div class="form-container">
                <form action="register.php" method="post"> 
                                            
                <?php if (isset($event_error)) {
                    echo '<p class="error p-2 my-3 text-center">' . $event_error . '</p>';
                    }  ?>
                    <div class="form-group mb-3">
                        <label for="fname">First Name:</label>
                        <input class="form-control" type="text" name="fname" id="fname" minlength="2" placeholder="Type here..." required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="lname">Last Name:</label>
                        <input class="form-control" type="text" name="lname" id="lname" minlength="2" placeholder="Type here..." required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email:</label>
                        <input class="form-control" type="text" name="email" id="email" placeholder="Type here..." required>
                        <?php if (isset($email_error)) {
                        echo '<p class="error p-2 my-2 text-center">' . $email_error . '</p>';
                    } ?>
                    </div>
                    <div class="form-group mb-3">
                        <label for="grad_year">Graduation Year (optional): </label>
                        <input class="form-control mb-2" type="number" name="grad_year" id="grad_year" min="1925" max="2024" placeholder="Type here...">
                    </div>

                    <div class="form-group">
                        <h5><label for="events">Select Events:</label></h5>
                        <p></p>
                        <?php
                        if ($display_r->num_rows == 0) {
                            echo '<p class="text-center">There are no events available at the moment. Check back again later!</p>';
                        } 
                        else {
                            echo '<p>The base price for attending the reunion is 20 dollars.</p>';
                            while ($row = $display_r->fetch_assoc()) {
                                echo "<div class='form-check align-items-center mb-2'>
                                    <input type='checkbox' name='selected_events[]' class='form-check-input ' id='event" . $row['idevent'] ."' value='" . $row['idevent'] . "'>
                                    <label class='form-check-label fw-bold' for='event" . $row['idevent'] . "'>
                                        " . $row['name'] . "
                                    </label>";
                                if (isset ($row['description'])) {
                                    echo "<p class='m-0'>$row[description]</p>";}
                                
                                if (isset ($row['location'])) {                                
                                    echo "<p class='m-0'>Location: $row[location]</p>"; }
                                    
                                    if ($row['price'] > 0) {

                                        echo "<p>Price: $" . number_format($row['price'], 2) . "</p>"; 
                                    } else {
                                        echo "<p>Price: Free of charge. </p>";
                                    }
            
                                    echo "</div>";
                            }
                        }
                        ?>
                    
                    </div>
                    
                    <button class="btn btn-blue w-100" type="submit" name="register">Register!</button>
                </form>
            </div>

        </div>
    </div>
</div>
</body>


<?php include './includes/footer.html' ?>

</body>
</html>
