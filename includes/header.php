<?php
require __DIR__ . '/../config/config.php';
session_start();
ob_start();
define('BASE_URL', 'http://localhost/coffee-blend/');
?>
<?php 
function getProduct($conn,$id) {
    $product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch(PDO::FETCH_OBJ);
    return $product;
}
function getTotalPrice($conn,$cart) {
    $total = 0;
    foreach($cart as $item) {
        $product = getProduct($conn,$item['product_id']);
        $total += $product->price * $item['quantity'];
    }
    return $total;
}
?>
<?php 
$cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], associative: true) : []; //?
$totalItems = 0;
foreach ($cart as $item) {
    $totalItems += $item['quantity'];
}
// var_dump($totalItems) ;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Coffee - Free Bootstrap 4 Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/animate.css">

    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/magnific-popup.css">

    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/aos.css">

    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/ionicons.min.css">

    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/jquery.timepicker.css">


    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/flaticon.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/icomoon.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.html">Coffee<small>Blend</small></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a href="index.html" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="menu.html" class="nav-link">Menu</a></li>
                    <li class="nav-item"><a href="services.html" class="nav-link">Services</a></li>
                    <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>

                    <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li>

                    <?php if (isset($_SESSION['username'])) : ?>

                        <li class="nav-item cart dropdown" style="position: relative;">
                            <?php if($totalItems > 0 ): ?>
                                <span   style=" padding: 2px 5px; background-color: red; border-radius: 70% 70%;
                                                font-size: 8px; position: absolute; top:10%; right:10%;">
                                        <?php echo $totalItems; ?>
                                </span>
                          
                                <a href="cart.php" class="nav-link dropdown-toggle" id="cartDropdown" data-bs-toggle="dropdown" aria-expanded="false"><span class="icon icon-shopping_cart"></span></a>
                                <ul class="dropdown-menu" aria-labelledby="cartDropdown" style="background-color: white;">
                                        <?php foreach($cart as $item): 
                                            $product = getProduct($conn,$item['product_id']);
                                        ?>
                                        <li style="display: flex; justify-content: space-between; padding: 5px 20px; border-bottom: 1px solid #ccc;">
                                            <div class="col "><?php echo $product->name; ?></div>
                                            <div class="col ">x<?php echo $item['quantity']; ?> </div>
                                            <div class="col ">$<?php echo $product->price * $item['quantity']; ?></div>
                                        </li>
                                        <?php endforeach; ?>
                                        <li style="display: flex; justify-content: end; padding: 5px 5px; font-weight: bold;">
                                        <div>Total:</div> 
                                        <div>   <?php echo getTotalPrice($conn,$cart) ?></div>
                                        </li>
                                </ul>
                            <?php endif; ?>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $_SESSION['username']; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL ?>/auth/logout.php">Logout</a></li>
                            </ul>
                        </li>
                        
                    <?php else : ?>

                        <li class="nav-item"><a href="<?php echo BASE_URL ?>/auth/login.php" class="nav-link">login</a></li>
                        <li class="nav-item"><a href="<?php echo BASE_URL ?>/auth/register.php" class="nav-link">register</a></li>
                    
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- END nav -->