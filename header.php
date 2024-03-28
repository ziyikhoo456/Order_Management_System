<?php
    include('auth.php');
    require('config/constant.php');

    $name = $_SESSION['custName'];
    $custID = $_SESSION['custID'];

    $currencySymbol = "RM";
    $total = 0;

    $sel_query="SELECT * FROM cart WHERE custID='$custID';";
    $result = mysqli_query($conn,$sel_query);
    $count = mysqli_num_rows($result);

    while($row = mysqli_fetch_assoc($result)) {
        $sqlcartprod = mysqli_query($conn,"SELECT * FROM product WHERE prodID='".$row["prodID"]."' ");
        $rowcartprod = mysqli_fetch_array($sqlcartprod);
        if($rowcartprod['prodStock']==0){
            $update="UPDATE cart set prodQuantity='".$rowcartprod['prodStock']."' WHERE custID='$custID' AND prodID ='".$row['prodID']."' ;";
            mysqli_query($conn, $update) or die(mysqli_error($conn));
            $row['prodQuantity']=$rowcartprod['prodStock'];
        }
        else if($rowcartprod['prodStock']<$row['prodQuantity']){
            $update="UPDATE cart set prodQuantity='".$rowcartprod['prodStock']."' WHERE custID='$custID' AND prodID ='".$row['prodID']."' ;";
            mysqli_query($conn, $update) or die(mysqli_error($conn));
            $row['prodQuantity']=$rowcartprod['prodStock'];
        }
        $total += $rowcartprod['prodPrice']*$row['prodQuantity'];
    }
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ELECPRO</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">

</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> elecpro@gmail.com</li>
                                <li>Free Shipping for all Order of RM100</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-pinterest-p"></i></a>
                            </div>
                            <div class="header__top__right__language">
                                <img src="img/language.png" alt="">
                                <div>English</div>
                                <span class="arrow_carrot-down"></span>
                                <ul>
                                    <li><a href="#">Spanish</a></li>
                                    <li><a href="#">English</a></li>
                                </ul>
                            </div>
                            <div class="header__top__right__language">
                                <span class="fa fa-user"></span> <?php echo $name ?></a>
                                <span class="arrow_carrot-down"></span>
                                    <ul>
                                        <li><a href="logout.php">Logout</a></li>
                                    </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="./index.html"><img src="img/logo2.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="./index.php">Home</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                            <li><a href="./shoping-cart.php"><i class="fa fa-shopping-bag"></i><span><?php echo $count?></span></a></li>
                        </ul>
                        <div class="header__cart__price">item: <span><?php echo $currencySymbol . $total ?></span></div>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->

    <!-- Hero Section Begin -->
    <?php 
        if (strpos($_SERVER['PHP_SELF'], 'index.php') !== false) {
            echo '<section class="hero">';
        } else {
            echo '<section class="hero hero-normal">';
        }    
    ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>All departments</span>
                        </div>
                        <ul>
                            <li><a href="#">Adapters</a></li>
                            <li><a href="#">Bluetooth Speakers</a></li>
                            <li><a href="#">Cables</a></li>
                            <li><a href="#">Cases</a></li>
                            <li><a href="#">Chargers</a></li>
                            <li><a href="#">Gaming Accessories</a></li>
                            <li><a href="#">Headphones</a></li>
                            <li><a href="#">Power Banks</a></li>
                            <li><a href="#">Smartwatch Bands</a></li>
                            <li><a href="#">Storage</a></li>
                            <li><a href="#">Styluses</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="#">
                                <div class="hero__search__categories">
                                    All Categories
                                    <span class="arrow_carrot-down"></span>
                                </div>
                                <input type="text" placeholder="What do you need?">
                                <button type="submit" class="site-btn">SEARCH</button>
                            </form>
                        </div>
                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5>+65 11.188.888</h5>
                                <span>support 24/7 time</span>
                            </div>
                        </div>
                    </div>
                    <?php
                        if (strpos($_SERVER['PHP_SELF'], 'index.php') !== false) {
                            echo '
                            <div class="hero__item set-bg" data-setbg="img/hero/elecBanner.png">
                                <div class="hero__text">
                                    <span>QUALITY PRODUCT</span>
                                    <h2>Electronic Items <br />100% Safe</h2>
                                    <p>Free Pickup and Delivery Available</p>
                                    <a href="#" class="primary-btn">SHOP NOW</a>
                                </div>
                            </div>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->