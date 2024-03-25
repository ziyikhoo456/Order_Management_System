<!DOCTYPE html>

<?php 

    include "./header.php";
    // include "auth.php";
    // require './config/constant.php';

    // $name = $_SESSION['custName'];
    // $custID = $_SESSION['custID'];

    $_SESSION['discount']=0;
   
    $total = 0;
    $realtotal = 0;

   

?>
    <!-- Hero Section Begin -->
    <section class="hero hero-normal">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>All departments</span>
                        </div>
                        <ul>
                            <li><a href="#">Fresh Meat</a></li>
                            <li><a href="#">Vegetables</a></li>
                            <li><a href="#">Fruit & Nut Gifts</a></li>
                            <li><a href="#">Fresh Berries</a></li>
                            <li><a href="#">Ocean Foods</a></li>
                            <li><a href="#">Butter & Eggs</a></li>
                            <li><a href="#">Fastfood</a></li>
                            <li><a href="#">Fresh Onion</a></li>
                            <li><a href="#">Papayaya & Crisps</a></li>
                            <li><a href="#">Oatmeal</a></li>
                            <li><a href="#">Fresh Bananas</a></li>
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
                                <input type="text" placeholder="What do yo u need?">
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
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Shopping Cart</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.php">Home</a>
                            <span>Order</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th id="shoppingcart" class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sel_query="SELECT * FROM cart WHERE custID='$custID';";
                                $result = mysqli_query($conn,$sel_query);
                                while($row = mysqli_fetch_assoc($result)) {
                                $warning='';
                                $sqlcartprod = mysqli_query($conn,"SELECT * FROM product WHERE prodID='".$row["prodID"]."' ");
                                $rowcartprod = mysqli_fetch_array($sqlcartprod);
                                if($rowcartprod['prodStock']==0){
                                    $update="UPDATE cart set prodQuantity='".$rowcartprod['prodStock']."' WHERE custID='$custID' AND prodID ='".$row['prodID']."' ;";
                                    mysqli_query($conn, $update) or die(mysqli_error($conn));
                                    $row['prodQuantity']=$rowcartprod['prodStock'];
                                    $warning='Current out of stock.';
                                }
                                else if($rowcartprod['prodStock']<$row['prodQuantity']){
                                    $update="UPDATE cart set prodQuantity='".$rowcartprod['prodStock']."' WHERE custID='$custID' AND prodID ='".$row['prodID']."' ;";
                                    mysqli_query($conn, $update) or die(mysqli_error($conn));
                                    $row['prodQuantity']=$rowcartprod['prodStock'];
                                    $warning='Changed to current maximum stock availability.';
                                }
                                $total += $rowcartprod['prodPrice']*$row['prodQuantity'];
                                echo '
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img src="img/featured/'.$rowcartprod['imageName'].'" width="101" alt="">
                                        <h5>'.
                                            $rowcartprod['prodName'].'
                                        </h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        <span id="price">'.
                                             $rowcartprod['prodPrice'].'
                                        </span>
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity">
                                            <div class="pro-qty">
                                                <input type="text" id="'.$row['prodID'].'" name="'.$row['prodID'].'"style="cursor: default" readonly value="'.intval($row['prodQuantity']).'">
                                            </div>
                                        </div>
                                        <span class="text-danger">'.$warning.'</span>
                                    </td>
                                    <td class="shoping__cart__total" id="'.$row['prodID'].'price">
                                        '.$rowcartprod['prodPrice']*$row['prodQuantity'].'
                                    </td>
                                    <td>
                                    <button class="delete-ajax" data-id="'.$row['prodID'].'" onclick="confirmDelete(this);"><span class="icon_close"></span></button>
                                    </td>
                                </tr>';
                                }
                                $realtotal = $total;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="#" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                        <button id="updatecart" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                            Update Cart</button>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>Discount Codes</h5>
                            <form id="discount_code">
                                <input type="text" id="discount" name="discount" placeholder="Enter your coupon code">
                                <input type="hidden" id="realtotal" name="realtotal" value="<?php echo $realtotal; ?>">
                                <button type="submit" class="site-btn">APPLY COUPON</button>
                            </form>
                        </div>
                        <span class="text-danger" id="invalid_code"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Cart Total</h5>
                        <ul>
                            <li>Subtotal <span>$<?php echo $total;?></span></li>
                            <span id=discountline type = "hidden"></span>
                            <li>Total <span id="result">$<?php echo $realtotal; ?></span></li>
                        </ul>
                        <a href="checkout.html" class="primary-btn">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->
    
<?php include('./footer.php');?>

    <script>
    $(document).ready(function() {
        // Submit form using AJAX
        $('#discount_code').submit(function(e) {
            e.preventDefault(); // Prevent default form submission

            // Get form data
            var formData = $(this).serialize();
            
            // Send AJAX request
            $.ajax({
                type: 'POST',
                url: 'discount.php', // PHP script to handle form submission
                data: formData,
                success: function(response) {
                    var discount = $('#discount').val();
                    var realtotal = $('#realtotal').val();
                    if (discount == 'elecpro40'){
                        $('#result').html('$'+(realtotal-response));
                        $('#discountline').html("<li>Discount <span>$"+response+"</span></li>")
                        $('#invalid_code').html(''); // Update result div with response from server
                    }
                    else{
                        $('#invalid_code').html(response);
                        $('#discountline').html('');
                        $('#result').html('$'+realtotal);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log error message if AJAX request fails
                }
            });
        });
    });
    </script>    
    
    <script>
        $(document).ready(function() {
            $('#updatecart').click(function() {
                // Retrieve values from elements
                <?php 
                    $sel_query="SELECT * FROM cart WHERE custID='$custID';";
                    $result = mysqli_query($conn,$sel_query);
                    while($row = mysqli_fetch_assoc($result)) {
                    echo "var name".$row['prodID']." = $('#".$row['prodID']."').val();";
                    }
                ?>
                // Send AJAX request
                $.ajax({
                    type: 'POST',
                    url: 'updatecart.php',
                    data: {
                        <?php 
                        $i = 0;
                        $result = mysqli_query($conn,$sel_query);
                        while($row = mysqli_fetch_assoc($result)) {
                        if ($i == 0 ){
                            $i=1;
                        }
                        else{
                            echo ",";
                        }
                        echo $row['prodID'].": name".$row['prodID'];
                        }
                        ?>
                    },
                    success: function(response) {
                        // Display response in output div
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    
     function confirmDelete(button) {
        if (confirm("Are you sure you want to delete this product record?")) {
            // If the user confirms, trigger the AJAX request
            deleteRecord(button);
        }
    }

    function deleteRecord(button) {
        var id = $(button).data('id'); // Get the ID associated with the button
        $.ajax({
            type: 'POST',
            url: 'deletecart.php',
            data: { id: id }, // Send the ID with the AJAX request
            success: function(response) {
                // Handle the response if needed
                location.reload(); // Reload the page after successful deletion
            },
            error: function(xhr, status, error) {
                // Handle errors if any
                console.error(xhr.responseText);
            }
        });
    }
    </script>
</body>

</html>