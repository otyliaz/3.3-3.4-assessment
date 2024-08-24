
<nav class="navbar navbar-expand-sm bg-light">
    <div class="container-fluid">   

        <ul class="navbar-nav align-items-center">
            <li class="navbar-header">
                <a class="navbar-brand" href="index.php"><img id="logo" src="./images/logo.png" alt="CAS 100" height="60px" width= "60px"></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="shop.php">Shop</a>  
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cart.php">My Cart</a>
            </li> 
            <li class="nav-item">
                <a class="nav-link" href="register.php">Register</a>
            </li> 
        </ul>

        <ul class="navbar-nav navbar-right align-items-center">
            <?php 
            if(isset($_SESSION['iduser'])){
                //echo '<i class="fa fa-user-circle" aria-hidden="true"></i>'.$_SESSION['username'];
                echo '
                <li class="nav-item">
                <a class="nav-link"><i class="fa fa-user-circle" aria-hidden="true"></i>'.$_SESSION['username'].'</a>
                </li> 
                <li class="btn btn-danger">
                <a class="nav-link" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Log out</a>
                </li>
                ';
            }
            else {
                echo '
                <li class="nav-item">
                <a class="nav-link" href="signup.php"><i class="fa fa-user-circle" aria-hidden="true"></i>Sign up</a>
                </li> 
                <li class="nav-item">
                <a class="nav-link" href="login.php"><i class="fa fa-sign-in" aria-hidden="true"></i>Log in</a>
                </li>';
            } 
            ?>
            </li>
        </ul>
        
    </div>
</nav>