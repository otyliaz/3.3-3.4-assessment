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
    header ("Location: login.php");
}


if (isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $grad_year = $_POST['grad_year'];

    $update_query = "UPDATE `user` SET `email`=?, `fname`=?, `lname`=?, `grad_year`=? WHERE iduser=?";
    if ($stmt = $conn->prepare($update_query)) {
        $stmt->bind_param("sssii", $email, $fname, $lname, $grad_year, $iduser);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error updating user: " . $conn->error;
    }

    if (isset($_POST['selected_events'])) {
        $events = $_POST['selected_events'];
        foreach ($events as $event_id) {
            $insert_query = "INSERT INTO `registration` (iduser, idevent) VALUES (?, ?)";
            if ($stmt = $conn->prepare($insert_query)) {
                $stmt->bind_param("ii", $iduser, $event_id);
                $stmt->execute();
                $stmt->close();
            } else {
                echo "Error registering for event: " . $conn->error;
            }
        }
    }

    $conn->close();
    header("Location: success.php"); // Redirect to a success page or another relevant page
    exit();
}

$display_query = "SELECT * FROM event";
$display_result = $conn->query($display_query);

if (!$display_result) {
    echo "Error fetching events: " . $conn->error;
    exit();
}
?>

<body>
<div class="container">
    <h2 class="my-4 text-center">This page is to register for an event</h2>
    <form action="register.php" method="post"> 
        <div class="form-group">
            <label for="fname">First Name:</label>
            <input class="form-control mb-2" type="text" name="fname" id="fname" placeholder="Type here..." required>
        </div>
        <div class="form-group">
            <label for="lname">Last Name:</label>
            <input class="form-control mb-2" type="text" name="lname" id="lname" placeholder="Type here..." required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input class="form-control mb-2" type="text" name="email" id="email" placeholder="Type here..." required>
        </div>
        <div class="form-group">
            <label for="grad_year">Graduation Year:</label>
            <input class="form-control mb-2" type="number" name="grad_year" id="grad_year" placeholder="Type here..." required>
        </div>

        <div class="row mt-2">
            <?php
            if ($display_result->num_rows == 0) {
                echo '<p class="text-center">There are no events available at the moment. Check back again later!</p>';
            } else {
                while ($row = $display_result->fetch_assoc()) {
                    echo "<div class='col-md-4'>
                            <div class='card mb-2'>
                                <div class='card-body'>
                                    <h5 class='card-title'>$row[name]</h5> 
                                    <p class='card-text'>$row[description]</p>
                                    <input type='checkbox' name='selected_events[]' class='select-event' id='event" . $row['idevent'] ."' value='" . $row['idevent'] . "'>
                                    <label for='event" . $row['idevent'] . "' class='btn btn-blue select-btn'>Select</label>
                                </div>
                            </div>
                        </div>";
                }
            }
            ?>
        </div>
        <input class="btn btn-blue w-100 mt-3" type="submit" name="register" value="Register!">
    </form>
</div>

<?php include './includes/footer.html'?>

</body>
</html>
