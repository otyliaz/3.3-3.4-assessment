
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

    if ($stmt = $conn->$query) {
        //bind parameters
        $stmt->bind_param("ss", $username, $passworden);
        $stmt->execute();
        
        //store the result
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            // found match in database

            //fetch results
            $stmt->bind_result($iduser, $admin);
            $stmt->fetch();

            // set session variables
            $_SESSION['iduser'] = $iduser;
            $_SESSION['username'] = $username;
            $_SESSION['admin'] = $admin;

            //checks if user has a cart when they log in
            $cart_q = "SELECT idcart FROM cart WHERE iduser = $iduser";
            $cart_r = $conn->query($cart_q);

            if ($cart_r->num_rows == 0) {  //if they don't have a cart created
                $create_cart_q = "INSERT INTO cart (iduser, ordered) VALUES ($iduser, 0)";
                $create_cart_r = $conn->query($create_cart_q);

            }
            
            //successfully logged in
            header("Location: index.php");
            exit();
        
        } else {
            $invalid = 'Your username or password is invalid. Please try again.';}

        //close the statement
        $stmt->close();
    
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>


<body>

<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 offset-md-2">
            <h2 class="my-4">Log in to access all our features.</h2>
            <p>Don't have an account? Click <a href="signup.php">here</a> to create one!</p>

            <!-- login form -->
            <div class="form-container">
                <form action="login.php" method="post">
                    <?php 
                    if (isset($invalid)) {
                        // if username and password don't match, print error
                        echo '<p class="error p-2 my-3 text-center">' . $invalid . '</p>';
                        } 
                    ?>
                    <div class="form-group mb-3">
                        <label for="username">Username:</label>
                        <input class="form-control" type="text" name="username" id="username" placeholder="Type here..." required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password:</label>
                        <input class="form-control" type="password" name="password" id="password" min=7 placeholder="Type here..." required>
                    </div>
                    <input class="btn btn-blue w-100" type="submit" name="login" value="Log in!">
                </form>
            </div>

        </div> <!----closing div class="col-12 ...."--->
    </div> <!--closing row--->
</div>

<?php include './includes/footer.html'?>


</body>
</html>