<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign up - CAS Centenary</title>
    <?php include './includes/basehead.html'; ?>
</head>

<body>
<?php
require_once "./includes/connect.inc";
include './includes/nav.php';

if (isset($_POST['signup'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

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
                    // bind parameters
                    $stmt2->bind_param("ss", $username, $passworden);
                    $stmt2->execute();

                    // redirect to login after signing up
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
        // close the statement
        $stmt->close();
    } 
    else {
        echo "Error: " . mysqli_error($conn);
    }
}

$conn->close();
?>
<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 offset-md-2">
            <h2 class="my-4 text-center">Sign up!</h2>
            <p class="text-center">Already have an account? Click <a href="login.php">here</a> to login.</p>
            <div class="form-container">
                <form action="signup.php" method="post">
                    <div class="form-group mb-3">
                        <label for="username">Username:</label>
                        <input class="form-control" type="text" name="username" id="username" placeholder="Type here..." required> 
                        <?php if (isset($nametaken)) {
                            echo '<p class="error p-2 my-2 text-center">' . $nametaken . '</p>';
                        } ?>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password:</label>
                        <input class="form-control" type="password" name="password" id="password" placeholder="Type here..." minlength="8" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="confirm">Confirm password:</label>
                        <input class="form-control" type="password" name="confirm" id="confirm" placeholder="Type here..." minlength="8" required> 
                        <?php if (isset($confirmerror)) {
                            echo '<p class="error p-2 mt-3 mb-0 text-center">' . $confirmerror . '</p>';
                        } ?>
                    </div>
                    <input class="btn btn-blue w-100" type="submit" name="signup" value="Sign up!">
                </form>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.html'?>

</body>
</html>
