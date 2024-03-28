<?php

    //include('auth.php');
    //require('config/constant.php');
    include('header.php');

    //$name = $_SESSION['custName'];
    //$custID = $_SESSION['custID'];
    $prodID = $_GET['prodID'];


    // Check if prodID is null or empty
    if (empty($prodID)) {
        // Redirect to index.php
        header("Location: index.php");
        exit(); // Make sure to exit after the header redirect
    }



    $prod_query = "SELECT prodID, prodName, prodStock, prodPrice, shortDesc, longDesc, imageName, catName
        FROM Product, Category
        WHERE Product.categoryID = Category.categoryID
        AND prodID = $prodID";

    $result = mysqli_query($conn, $prod_query);
    $currencySymbol = "RM";

    if ($row = mysqli_fetch_assoc($result)) {

        $prodName = $row["prodName"];
        $prodPrice = $row["prodPrice"];
        $shortDesc = $row["shortDesc"];
        $longDesc = $row["longDesc"];
        $imgPath = "img/featured/" . $row["imageName"];
        $prodStock = $row["prodStock"];
        $catName = $row["catName"];
    }

    if (isset($_POST['addToCart']) && $_POST['addToCart'] == 1) {

        if ($_POST['quantity'] > $prodStock) {
            echo "<script>alert('The quantity of item has exceeded the limit!');
                window.location.href = 'shop-details.php?prodID=$prodID';</script>";
        }

        $prod_query = "SELECT * from `cart` WHERE prodID='$prodID' AND custID='$custID'";
        $result = mysqli_query($conn, $prod_query);
        $row = mysqli_fetch_assoc($result);

        if ($row > 0) {
            $oriQty = $row["prodQuantity"];
            $quantity = $_POST['quantity'] + $oriQty;

            $update = "UPDATE cart set prodQuantity='$quantity' 
                WHERE custID='$custID' AND prodID ='$prodID';";
            $result = mysqli_query($conn, $update) or die(mysqli_error($conn));

            if ($result) {
                echo "<script>window.location.href = 'shoping-cart.php';</script>";
            }
        } else {

            $quantity = $_POST['quantity'];

            $query = "INSERT into `cart` (custID, prodID, prodQuantity)
                        VALUES ('$custID', '$prodID', '$quantity')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<script>window.location.href = 'shoping-cart.php';</script>";
            }
        }
    }
?>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2><?php echo $catName ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large" src="<?php echo $imgPath ?>" alt="">
                        </div>

                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3><?php echo $prodName ?></h3>
                        <div class="product__details__rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <span>(18 reviews)</span>
                        </div>
                        <div class="product__details__price"><?php echo $currencySymbol . $prodPrice ?></div>
                        <p><?php echo $shortDesc ?></p>

                        <form method="post" action="">
                            <input type="hidden" name="addToCart" value="1">
                            <div class="product__details__quantity">
                                <div class="quantity">
                                    <input class="pro-qty" type="number" name="quantity" min="1" max=<?php echo $prodStock ?> value="1">
                                </div>
                            </div>

                            <input type="submit" class="primary-btn" value="ADD TO CART">
                        </form>

                        <ul>
                            <li><b>Availability</b> <span><?php echo $prodStock ?></span></li>
                            <li><b>Shipping</b> <span>01 day shipping. <samp>Free pickup today</samp></span></li>
                            <li><b>Weight</b> <span>0.5 kg</span></li>
                            <li><b>Share on</b>
                                <div class="share">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab" aria-selected="true">Description</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Products Infomation</h6>
                                    <p><?php echo "$longDesc" ?></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

<?php include('./footer.php'); ?>