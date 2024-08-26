
<nav class="navbar navbar-expand-sm mb-2">
    <div class="container-fluid">   

        <ul class="navbar-nav align-items-center">
            <li class="navbar-header">
                <a class="navbar-brand" href="index.php"><img id="logo" src="./images/logo.png" alt="CAS 100" height="60px" width= "60px"></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>  
            </li>
            <li class="nav-item">
                <a class="nav-link" href="shop.php">Shop</a>  
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
                <a id="nav-username"><i class="fa fa-user-circle" aria-hidden="true"></i>'.$_SESSION['username'].'</a>
                </li> 
                <li class="nav-item">
                <a class="nav-link btn ms-3" id="logout-link" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Log out</a>
                </li>
                ';
            }
            else {
                echo '
                <li class="nav-item">
                <a class="nav-link btn" id="signup-link" href="signup.php"><i class="fa fa-user-circle" aria-hidden="true"></i>Sign up</a>
                </li> 
                <li class="nav-item">
                <a class="nav-link btn ms-2" id="login-link" href="login.php"><i class="fa fa-sign-in" aria-hidden="true"></i>Log in</a>
                </li>';
            } 
            ?>
            </li>
        </ul>
        
    </div>
</nav>

<script defer> //jquery for navbar shadow
$(document).ready(function() {
        $(window).scroll(function() {
            if ($(this).scrollTop() > 60) { //if they scroll more than 60px, add shadow
                $('.navbar').addClass('navbar-shadow');
            } else {
                $('.navbar').removeClass('navbar-shadow');
            }
        });
    });
</script>