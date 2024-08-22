<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign up - CAS Centenary</title>
    <?php include ('./includes/basehead.html'); ?>
</head>

<?php
require_once("includes/connect.inc");

if(isset($_POST['register'])) {
    $username = $_POST['username'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $grad_year = $_POST['grad_year'];

    // selects to see if username already exists
    $select = "SELECT `username` FROM user WHERE `username` = ?";
    
    if ($stmt = mysqli_prepare($conn, $select)) {

        // bind parameters
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        // store the result
        mysqli_stmt_store_result($stmt);

        // if username already exists -> error
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $nametaken = 'This username is already taken. Please choose another one.';
        } 
        else {
            if ($_POST['password'] == $_POST['confirm']) {
                // hash the password
                $passworden = hash('sha256', $password);

                $query = "INSERT INTO `user` (`username`, `password`, `email`, `fname`, `lname`, `grad_year` ) VALUES (?, ?, ?, ?, ?, ?)";

                if ($stmt2 = mysqli_prepare($conn, $query)) {

                    //bind parameters
                    mysqli_stmt_bind_param($stmt2, "sssssi", $username, $passworden, $email, $fname, $lname, $grad_year);
                    mysqli_stmt_execute($stmt2);

                    //redirect to login after registering
                    header("Location: login.php");
                    exit();
                }
                else {
                    echo "Error: " . mysqli_error($conn);
                }
            } 
            else {
                $confirmerror = "Your passwords don't match, please try again.";
            }
        }
        //close the statement
        mysqli_stmt_close($stmt);
    } 
    else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<body>

<div class="container">
<h2>Sign up!</h2>

<p>Already have an account? Click <a href="login.php">here</a> to login.</p>

<!--form-->
<form action="register.php" method="post"> 
    <div class="form-group">
        <label for="username">Username:</label>
        <input class="form-control" type="text" name="username" id="username" placeholder="Type here..." required> 
        <!-- if the username already exists, then print the error-->
        <?php if (isset($nametaken)) {
            echo '<p class="error">' . $nametaken . '</p>';}
        ?>
    </div>
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
        <label for="password">Password:</label>
        <input class="form-control" type="password" name="password" id="password" placeholder="Type here..." minlength="8" required>
    </div>
    <div class="form-group">
        <label for="confirm">Confirm passsword:</label>
        <input class="form-control" type="password" name="confirm" id="confirm" placeholder="Type here..." minlength="8" required> 
        <!-- if the passwords don't match, then print the error-->
        <?php if (isset($confirmerror)) {
            echo '<p class="error">' . $confirmerror . '</p>';}
        ?>
    </div>
    <div class="form-group">
        <label for="grad_year">Graduation year:</label>
        <input class="form-control" type="number" name="grad_year" id="grad_year" placeholder="Type here..." required>
    </div>
    <input class="btn btn-primary" type="submit" name="register" value="Sign up!">
</form>


</div>

</body>
</html>