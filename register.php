<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - CAS Centenary</title>
    <?php include ('./includes/basehead.html'); ?>
    <style>
        .container {
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .event-checkbox {
            margin-bottom: 10px;
        }
    </style>
</head>

<?php
session_start();
require_once("includes/connect.inc");
include('./includes/nav.php');

if (isset($_SESSION['iduser'])) {
    $iduser = $_SESSION['iduser'];
} else {
    header("Location: login.php");
    exit();
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
            $insert_q = "INSERT INTO `registration` (iduser, idevent) VALUES ($iduser, $idevent)";
            $insert_r = $conn->prepare($insert_query);
            if (!$insert_r) {
                echo "Error registering for event: " . mysqli_error($conn);
            }
        }
    }

    $conn->close();
    header("Location: success.php"); // Redirect to a success page or another relevant page
    exit();
}

$display_q = "SELECT * FROM event";
$display_r = $conn->query($display_q);

if (!$display_r) {
    echo "Error fetching events: " . $conn->error;
    exit();
}
?>

<body>
<div class="container">
    <h2 class="my-4 text-center">Book Now!</h2>
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

        <div class="form-group">
            <label for="events" class="fw-bold">Select Events:</label>
            <p>This selection does not have to be final. It will help us obtain an approximate number of participants at each event.</p>
            <?php
            if ($display_r->num_rows == 0) {
                echo '<p class="text-center">There are no events available at the moment. Check back again later!</p>';
            } else {
                while ($row = $display_r->fetch_assoc()) {
                    echo "<div class='form-check'>
                            <input type='checkbox' name='selected_events[]' class='form-check-input' id='event" . $row['idevent'] ."' value='" . $row['idevent'] . "'>
                            <label class='form-check-label' for='event" . $row['idevent'] . "'>
                                " . $row['name'] . ": " . $row['description'] . "
                            </label>
                          </div>";
                }
            }
            ?>
        </div>
        
        <button class="btn btn-blue w-100 mt-3" type="submit" name="register">Register!</button>
    </form>
</div>

<?php include './includes/footer.html' ?>

</body>
</html>
