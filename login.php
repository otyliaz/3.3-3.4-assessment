<?php
session_start()
?>

<!DOCTYPE html>
<html lang="en">
<head>  
    <title>Login - CAS Centenary</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<?php
require_once("includes/connect.inc");

//var_dump($_SERVER['REQUEST_METHOD']);
if(isset($_POST['login'])) {
        
    $username = $_POST['username'];
    $password = $_POST['password'];

    //hash password
    $passworden = hash('sha256', $password);

    // if username matches password........
    $query = "SELECT iduser FROM user WHERE username = ? and password = ? ";

    if ($stmt = mysqli_prepare($conn, $query)) {
        //bind parameters
        mysqli_stmt_bind_param($stmt, "ss", $username, $passworden);
        mysqli_stmt_execute($stmt);
        
        //store the result
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
            echo $username . ', you are logged in.';
            
            //fetch results
            mysqli_stmt_bind_result($stmt, $iduser);
            mysqli_stmt_fetch($stmt);

            //set iduser as a session variable
            $_SESSION['iduser'] = $iduser;

            //set fname as a session variable
            // $_SESSION['fname'] = $fname;

            //set username as a session variable
            $_SESSION['username'] = $username;
            header("Location: index.php");
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