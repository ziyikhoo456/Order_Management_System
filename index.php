<?php   
    include('./header.php');

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


    <!-- Hero Section Begin -->
    <section class="hero">
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
                    <div class="hero__item set-bg" data-setbg="img/hero/elecBanner.png">
                        <div class="hero__text">
                            <span>QUALITY PRODUCT</span>
                            <h2>Electronic Items <br />100% Safe</h2>
                            <p>Free Pickup and Delivery Available</p>
                            <a href="#" class="primary-btn">SHOP NOW</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/adapter.jpg">
                            <h5><a href="#">Adapter</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/cases.jpg">
                            <h5><a href="#">Cases</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/headphones.jpg">
                            <h5><a href="#">Headphones</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/powerbank.jpg">
                            <h5><a href="#">Power Banks</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/smartwatch.jpg">
                            <h5><a href="#">Smartwatch</a></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Product Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>All Product</h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            <li class="active" data-filter="*">All</li>
                            <li data-filter=".Headphone">HeadPhone</li>
                            <li data-filter=".Powerbank">PowerBank</li>
                            <li data-filter=".Smartwatch">Smartwatch</li>
                            <li data-filter=".Cable">Cable</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                <?php 
                
                    $sel_query="SELECT prodID, prodName, prodStock, prodPrice, imageName, catName
                    FROM Product, Category
                    WHERE Product.categoryID = Category.categoryID
                    ORDER BY prodID asc;";
                    $result = mysqli_query($conn, $sel_query);
                    

                    while($row = mysqli_fetch_assoc($result)) {

                        $prodID = $row["prodID"];
                        $catName = $row["catName"];
                        $prodName = $row["prodName"];
                        $prodPrice = $row["prodPrice"];
                        $imgPath = "img/featured/" . $row["imageName"];

                        echo "
                            <div class=\"col-lg-3 col-md-4 col-sm-6 mix $catName\">
                            <a href=\"shop-details.php?prodID=$prodID\">
                                <div class=\"featured__item\">
                                    <div class=\"featured__item__pic set-bg\" data-setbg=\"$imgPath\"></div>
                                    <div class=\"featured__item__text\">
                                        <h6>$prodName</h6>
                                        <h5> $currencySymbol $prodPrice</h5>
                                    </div>
                                </div>
                            </a>
                            </div>
                       ";
                    }
                    
                ?> 
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <!-- Banner Begin -->
    <div class="banner mb-5" >
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="img/banner/banner2-1.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="img/banner/banner2-2.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

<?php include('footer.php') ?>