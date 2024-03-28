<?php 

    include('./header.php');

    $grandTotal = 0;

    $sql=
    "SELECT * 
    FROM customer
    WHERE custID = ?";

    //get customer info
    $result=$conn->execute_query($sql,[$custID]);
    $count=mysqli_num_rows($result);
    if($count>0){
        while($rows=mysqli_fetch_assoc($result)){
            $id = $rows['custID'];
            $address = $rows['address'];
            $phone = $rows['contactNum'];
            $email = $rows['email'];
        }
    }

    function is_post_request():bool
    {
        return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST'; 
    }

    $productsID=[];
    $productsQuantity=[];

   
?>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/phone-banner.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Checkout</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
                            <span>Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h6><span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click here</a> to enter your code
                    </h6>
                </div>
            </div>
            <div class="checkout__form">
                <h4>Billing Details</h4>
                <form name="checkout-form" action="checkout.php" method="post">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="checkout__input">
                                <p>Name<span>*</span></p>
                                <input type="text" value=<?php echo $name?> disabled >
                            </div>
                            <div class="checkout__input">
                                <p>Address<span>*</span></p>
                                <input type="text" value=<?php echo$address?> disabled >
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Phone<span>*</span></p>
                                        <input type="tel" value=<?php echo'"'.$phone.'"'?> disabled >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="text" value=<?php echo$email?> disabled >
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            
                            <div class="checkout__input__checkbox">
                                <label for="diff-acc">
                                    Ship to a different address?
                                    <input type="checkbox" id="diff-acc" >
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input" id="shipping-address-div" style="display: none">
                                <p>Shipping Address<span>*</span></p>
                                <input type="text" id="diff-address" name="diff-address" >
                            </div>
                            <br><br>
                            
                            <div class="checkout__input">
                                <p>Order notes</p>
                                <input type="text" name="note"
                                    placeholder="Notes about your order, e.g. special notes for delivery.">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4>Your Order</h4>
                                <div class="checkout__order__products">Products <span>Total</span></div>
                                <ul>
                                    <?php
                                        // get cart info
                                        $sql = 
                                        "SELECT p.prodName, p.prodPrice, p.prodID, c.prodQuantity
                                        FROM cart c, product p
                                        WHERE c.prodID = p.prodID
                                        AND c.custID = ?";

                                        $result=$conn->execute_query($sql,[$id]);
                                        $count=mysqli_num_rows($result);

                                        if($count>0){
                                            while($rows = mysqli_fetch_assoc($result))
                                            {
                                                $prodName = $rows['prodName'];
                                                $prodTotalPrice = number_format((float)( $rows['prodPrice'] * $rows['prodQuantity']), 2, '.', '');
                                                $grandTotal += $prodTotalPrice;

                                                echo"<li>$prodName <span>RM $prodTotalPrice</span></li>";

                                                //the data in array will be used to store into order table later
                                                $productsID[] = $rows['prodID'];
                                                $productsQuantity[] = $rows['prodQuantity'];
                                            }
                                        }   

                                        $grandTotal = number_format((float)$grandTotal,2,'.','');

                                        //insert to order table, insert to payment table, update product stock quantity, empty cart
                                        if(is_post_request()){
                                            //if only if user purchase item
                                            if($grandTotal > 0)
                                            {
                                                //insert to order table
                                                //get max orderID
                                                $maxIdsql = "SELECT max(orderID) 'max' from ordering";
                                                $maxResult=$conn->execute_query($maxIdsql);

                                                $maxCount=mysqli_num_rows($maxResult);
                                                if($maxCount>0){
                                                    $maxCount = mysqli_fetch_assoc($maxResult)['max'] + 1;
                                                }
                                                
                                                $insertsql = "INSERT INTO ordering (orderID, prodID, prodQuantity) VALUES ";

                                                //sql script to update the product stock quantity
                                                $updatesqlfront = "
                                                UPDATE product
                                                SET prodStock = (CASE prodID ";
                                                $updatesqlend = "
                                                END)
                                                WHERE prodID IN(";

                                                //loop all purchased product
                                                for($count = 0; $count < count($productsID); $count++){
                                                    //insert to order table
                                                    $insertsql = $insertsql . "($maxCount, $productsID[$count],$productsQuantity[$count])";

                                                    //update stock quantity in product table
                                                    $updatesqlfront = $updatesqlfront . "WHEN $productsID[$count] THEN prodStock - $productsQuantity[$count] ";
                                                    $updatesqlend = $updatesqlend . "$productsID[$count]";

                                                    if($count != count($productsID)-1){
                                                        //add comma if not end for insert order and update stock
                                                        $insertsql = $insertsql.",";
                                                        $updatesqlend = $updatesqlend . ",";
                                                    }
                                                    else{
                                                        //add ')' if is last record for update stock
                                                        $updatesqlend = $updatesqlend . ")";
                                                    }
                                                }

                                                $conn->execute_query($insertsql);
                                            $conn->execute_query($updatesqlfront . $updatesqlend);

                                            //insert into payment table
                                            //status = pending/successful/fail/refund
                                            $sql="INSERT INTO payment (status, grandTotal, paymentDate, note, shipAddress, custID, orderID) VALUES('pending',?,?,?,?,?,?)";
                                            //check if the user use another address or any extra note
                                            if(isset($_POST['diff-address'])){
                                                $address = stripslashes($_POST['diff-address']);
                                                $address = mysqli_real_escape_string($conn, $address);
                                            }
                                            if(isset($_POST['note'])){
                                                $note = stripslashes($_POST['note']);
                                                $note = mysqli_real_escape_string($conn,$note);
                                            }
                                            else{
                                                $note="";
                                            }

                                            date_default_timezone_set("Asia/Kuala_Lumpur");
                                            $today = date("Y-m-d H:i:s"); 
                                            $conn->execute_query($sql,[$grandTotal,$today,$note,$address,$id,$maxCount]);

                                            //empty customer's cart
                                            $deletesql = "DELETE FROM cart WHERE custID=?";
                                            $conn->execute_query($deletesql, [$id]);

                                            //inform success payment
                                            echo"<script>alert('We have received your order.');
                                            window.location.href = 'index.php';</script>";
                                            }
                                        }
                                    ?>
                                </ul>
                                <div class="checkout__order__subtotal">Subtotal <span><?php echo"RM $grandTotal";?></span></div>
                                <div class="checkout__order__total">Total <span><?php echo"RM $grandTotal";?></span></div>
                                <p>Lorem ipsum dolor sit amet, consectetur adip elit, sed do eiusmod tempor incididunt
                                    ut labore et dolore magna aliqua.</p>
                                <div class="checkout__input__checkbox">
                                    <label for="payment">
                                        Pay by Cash
                                        <input type="checkbox" id="payment" >
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <button type="submit" class="site-btn" id="placeOrderBtn">PLACE ORDER</button>
                                <!-- <button type="submit" id="placeOrderBtn">PLACE ORDER</button> -->
                                <p class="text-danger" id="checkReminder">
                                    <!-- Please check 'Pay by Cash' -->
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    
    <!-- Checkout Section End -->

<?php include('./footer.php');?>
