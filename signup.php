<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign up - CAS Centenary</title>
    <?php include ('./includes/basehead.html'); ?>
</head>

<?php
require_once("includes/connect.inc");

if(isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // selects to see if username already exists
    $select = "SELECT `username` FROM user WHERE `username` = ?";
    
    if ($stmt = $conn->prepare($select)) {

        // bind parameters
        $stmt->bind_param("s", $username);
        $stmt->execute();

        // store the result
        $stmt->store_result();

        // if username already exists -> error
        if ($stmt->num_rows > 0) {
            $nametaken = 'This username is already taken. Please choose another one.';
        } 
        else {
            if ($_POST['password'] == $_POST['confirm']) {
                // hash the password
                $passworden = hash('sha256', $password);

                $query = "INSERT INTO `user` (`username`, `password`) VALUES (?, ?)";

                if ($stmt2 = $conn->prepare($query)) {

                    //bind parameters
                    mysqli_stmt_bind_param($stmt2, "ss", $username, $passworden);
                    mysqli_stmt_execute($stmt2);

                    //redirect to login after signing up
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
<form action="signup.php" method="post"> 
    <div class="form-group">
        <label for="username">Username:</label>
        <input class="form-control" type="text" name="username" id="username" placeholder="Type here..." required> 
        <!-- if the username already exists, then print the error-->
        <?php if (isset($nametaken)) {
            echo '<p class="error">' . $nametaken . '</p>';}
        ?>
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
    <input class="btn btn-primary" type="submit" name="signup" value="Sign up!">
</form>


</div>

</body>
</html>