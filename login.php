
<!DOCTYPE html>
<html lang="en">
<head>  
    <title>Login - CAS Centenary</title>
    <?php include './includes/basehead.html'; ?>
</head>

<?php
session_start();
require_once 'includes/connect.inc';
include 'includes/nav.php';

//var_dump($_SERVER['REQUEST_METHOD']);
if(isset($_POST['login'])) {
        
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

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

            //checks if user has a cart when they log in, and if not, create one.
            //checking if user has a cart created
            $cart_q = "SELECT idcart FROM cart WHERE iduser = $iduser";
            $cart_r = $conn->query($cart_q);

            if ($cart_r->num_rows == 0) {  //if they don't have a cart created
                $create_cart_q = "INSERT INTO cart (iduser) VALUES ($iduser)";
                $create_cart_r = $conn->query($create_cart_q);

            }
            else { //if they have a cart already
                $row = $cart_r->fetch_assoc();
            }

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

<div class="container d-flex justify-content-center align-items-center p-0">
    <div class="row">
        <h2 class="my-4 text-center">Log in to access all our features.</h2>
        <p class="text-center">Don't have an account? Click <a href="signup.php">here</a> to create one!</p>

        <div class="container justify-content-center align-items-center p-0 form-container">
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input class="form-control mb-2 w-100" type="text" name="username" id="username" placeholder="Type here..." required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input class="form-control mb-2 w-100" type="password" name="password" id="password" min=7 placeholder="Type here..." required>
                <?php if (isset($invalid)) {
                    // if error, print error
                    echo '<p class="error p-2 mt-3 mb-0 text-center">' . $invalid . '</p>';
                } ?>
            </div>
            <input class="btn btn-blue w-100 mt-3" type="submit" name="login" value="Log in!">
        </form>
        </div>
    </div>
</div>

</body>
</html>