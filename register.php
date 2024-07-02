<!DOCTYPE html>
<html lang="en">
<head>
    <title>HOME</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<?php
require_once("connect.inc");

//var_dump($_SERVER['REQUEST_METHOD']);
//if they submit the form,
if(isset($_POST['register'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];

    //query
    $select = "SELECT `username` FROM users WHERE `username` = ?";
    
    if ($stmt = mysqli_prepare($conn, $select)) {

        // bind parameters
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);

        // store the result
        mysqli_stmt_store_result($stmt);

        //check if username already exists
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $nametaken = 'This username is already taken. Please choose another one.';
        } 
        else {
            if ($_POST['password'] == $_POST['confirm']) {
                // hash the password
                $passworden = hash('sha256', $password);

                $query = "INSERT INTO `users` (`username`, `password`) VALUES (?, ?)";

                if ($stmt2 = mysqli_prepare($conn, $query)) {

                    //bind parameters
                    mysqli_stmt_bind_param($stmt2, "ss", $name, $passworden);
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

<p>Already have an account? Click <a href="/login.php">here</a> to login.</p>

<!--form-->
<form action="register.php" method="post"> 
    <div class="form-group">
        <label for="name">Username:</label><br>
        <input class="form-control" type="text" name="name" id="name" placeholder="Type here..." required> 
        <!-- if the username already exists, then print the error-->
        <?php if (isset($nametaken)) {
            echo '<p class="error">' . $nametaken . '</p>';}
        ?>
    </div>
    <div class="form-group">
        <label for="password">Password:</label><br>
        <input class="form-control" type="password" name="password" id="password" placeholder="Type here..." minlength="8" required>
    </div>
    <div class="form-group">
        <label for="confirm">Confirm passsword:</label><br>
        <input class="form-control" type="password" name="confirm" id="confirm" placeholder="Type here..." minlength="8" required> 
        <!-- if the passwords don't match, then print the error-->
        <?php if (isset($confirmerror)) {
            echo '<p class="error">' . $confirmerror . '</p>';}
        ?>
    </div>

    <input type="submit" name="register" value="Sign up!">
</form>


</div>

</body>
</html>