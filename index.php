<!DOCTYPE html>
<html lang="en">
<head>
    <title>HOME</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<div?php 
session_start();
require_once('./includes/connect.inc');
?>

<body>
<nav class="navbar navbar-expand-sm bg-light">
    <div class="container-fluid">   

        <ul class="navbar-nav align-items-center">
            <li class="navbar-header">
                <a class="navbar-brand" href="index.php"><img id="logo" src="./images/logo.png" alt="CAS 100" height="60px" width= "60px"></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#">Link 1</a>  
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
<div class="container">
<div class="row">

    <div class="col-md-6">
        <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel">

            <!-- indicator lines on carousel at bottom-->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./images/history.jpg" class="w-100 h-100" alt="CAS school photo">
                </div>
                <div class="carousel-item">
                    <img src="./images/pic2.png" class="w-100 h-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="./images/pic3.png" class="w-100 h-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="col-md-6">
        <p>Celebrating 100 years of Christian education!</p>
    </div>

</div>
</div>
</body>
</html>


