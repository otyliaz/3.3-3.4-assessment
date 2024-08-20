
<!DOCTYPE html>
<html lang="en">
<head>  
    <title>Login - CAS Centenary</title>
    <?php include ('./includes/basehead.html'); ?>
</head>

<?php
session_start();
require_once("includes/connect.inc");

//var_dump($_SERVER['REQUEST_METHOD']);
if(isset($_POST['login'])) {
        
    $username = $_POST['username'];
    $password = $_POST['password'];

    //hash password
    $passworden = hash('sha256', $password);

    // if username matches password........
    $query = "SELECT `iduser`, `admin` FROM user WHERE username = ? and password = ? ";

    if ($stmt = mysqli_prepare($conn, $query)) {
        //bind parameters
        mysqli_stmt_bind_param($stmt, "ss" , $username, $passworden);
        mysqli_stmt_execute($stmt);
        
        //store the result
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
            echo $username . ', you are logged in.';
            
            //fetch results
            mysqli_stmt_bind_result($stmt, $iduser, $admin);
            mysqli_stmt_fetch($stmt);

            // set session variables
            $_SESSION['iduser'] = $iduser;
            $_SESSION['username'] = $username;
            $_SESSION['admin'] = $admin;

            header("Location: index.php");
            exit();
        } 

        else {
            $invalid = 'Your username or password is invalid. Please try again.';}

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

<h2>Log in!</h2>

<p>Don't have an account? Click <a href="register.php">here</a> to create one!</p>

<!--login form-->
    <form action="login.php" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input class="form-control" type="text" name="username" id="username" placeholder="Type here..." required> 
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input class="form-control" type="password" name="password" id="password" placeholder="Type here..." required> 
            <?php if (isset($invalid)) {
                //if error, print error
                echo '<p class="error">' . $invalid . '</p><br>';}
            ?>
        </div>
        <input class="btn btn-primary" type="submit" name="login" value="Log in!">
    </form>

</div>

</body>
</html>