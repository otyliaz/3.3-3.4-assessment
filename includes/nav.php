
<nav class="navbar navbar-expand-md mb-2">
    <div class="container-fluid">   
        <!-- logo -->
        <a class="navbar-brand" href="index.php"><img id="logo" src="./images/logo.png" alt="CAS 100" height="60px" width= "60px"></a>
        <!-- navbar hamburger button on small screens -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav align-items-center me-auto">   
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

            <ul class="navbar-nav align-items-center ms-auto">

                <?php 
                if(isset($_SESSION['iduser'])){
                    //echo '<i class="fa fa-user-circle" aria-hidden="true"></i>'.$_SESSION['username'];
                    echo '
                    <li class="d-none d-md-flex nav-item">
                    <a id="nav-username" class="mx-2"><i class="fa fa-user-circle" aria-hidden="true"></i>'.$_SESSION['username'].'</a>
                    </li> 
                    <li class="nav-item">
                    <a class="nav-link btn p-2 m-0" id="logout-link" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Log out</a>
                    </li>
                    ';
                }
                else {
                    echo '
                    <li class="nav-item">
                    <a class="nav-link btn p-2 mx-2" id="signup-link" href="signup.php"><i class="fa fa-user-circle" aria-hidden="true"></i>Sign up</a>
                    </li> 
                    <li class="nav-item">
                    <a class="nav-link btn p-2 m-0" id="login-link" href="login.php"><i class="fa fa-sign-in" aria-hidden="true"></i>Log in</a>
                    </li>';
                } 
                ?>
                </li>
            </ul>
            
        </div>
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