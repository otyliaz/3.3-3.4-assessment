<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - CAS Centenary</title>
    <?php include ('./includes/basehead.html'); ?>
</head>

<?php
session_start();
require_once("includes/connect.inc");
include('./includes/nav.php');
if (isset($_SESSION['iduser'])) {
    $iduser = $_SESSION['iduser'];
} else {
    echo "user does not exist or is not logged in";
    //header ("Location: login.php");
}

if(isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $grad_year = $_POST['grad_year'];

    $query = "INSERT INTO `user` (`email`, `fname`, `lname`, `grad_year` ) VALUES (?, ?, ?, ?)";

    if ($stmt = $conn->prepare($query)) {

        //bind parameters
        mysqli_stmt_bind_param($stmt, "sssi", $email, $fname, $lname, $grad_year);
        mysqli_stmt_execute($stmt);
    }
    else {
        echo "Error: " . mysqli_error($conn);
    }
}

$display_q = "SELECT * FROM event";
$display_r = $conn->query($display_q);

$conn->close();
?>

<body>

<div class="container">
<h2>This page is to register for an event</h2>

<!--form-->
<form action="register.php" method="post"> 
    <div class="form-group">
        <label for="fname">First Name:</label>
        <input class="form-control" type="text" name="fname" id="fname" placeholder="Type here..." required>
    </div>
    <div class="form-group">
        <label for="lname">Last Name:</label>
        <input class="form-control" type="text" name="lname" id="lname" placeholder="Type here..." required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input class="form-control" type="text" name="email" id="email" placeholder="Type here..." required>
    </div>
    <div class="form-group">
        <label for="grad_year">Graduation year:</label>
        <input class="form-control" type="number" name="grad_year" id="grad_year" placeholder="Type here..." required>
    </div>

    <div class="row mt-2">

    <?php
    if ($display_r->num_rows == 0) {
        echo '<p>There are no events available at the moment. Check back again later!</p>';
    } else {
        while($row = $display_r->fetch_assoc()) {
        echo "<div class='col-md-4'>
                <div class='card mb-2'>
                    <div class='card-body'>
                        <h5 class='card-title'>$row[title]</h5> 
                        <p class='card-text'>$row[description]</p>
                        <input type='checkbox' name='selected_events[]' class='select-event' id='event" . $row['idevent'] ."' value='" . $row['idevent'] . "'>
                        <label for='event" . $row['idevent'] . "' class='btn btn-primary select-btn'>Select</label>
                    </div>
                </div>
            </div>";
        }
    }
    ?>
    </div> <!--class="row"-->
    <input class="btn btn-primary" type="submit" name="register" value="Register!">
</form>


</div>

</body>
</html>