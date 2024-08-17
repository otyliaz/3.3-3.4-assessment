
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
                <a class="nav-link" href="#">Link 2</a>
            </li> 
        </ul>

        <ul class="navbar-nav navbar-right">
            <?php 
            if(isset($_SESSION['iduser'])){
                //echo '<i class="fa fa-user-circle" aria-hidden="true"></i>'.$_SESSION['username'];
                echo '<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-user-circle" aria-hidden="true"></i>'.$_SESSION['username'].
                '</a>
                <ul class="dropdown-menu dropdown-menu-dark">
                <li><a class="dropdown-item" href="logout.php">Log out</a></li>
                </ul>
                </li>';
            }
            else {
                echo '
                <li class="nav-item">
                <a class="nav-link" href="register.php"><i class="fa fa-user-circle" aria-hidden="true"></i>Sign up</a>
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