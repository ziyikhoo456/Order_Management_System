<?php 
    session_start();
?>

<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>

    <?php 
        require('config/constant.php');
        
        if (isset($_POST['login']) && $_POST['login'] == 1){ 
            $email = stripslashes($_REQUEST['email']); 
            $email = mysqli_real_escape_string($conn, $email); 
            $password = stripslashes($_REQUEST['password']); 
            $password = mysqli_real_escape_string($conn,$password);
            $query = "SELECT *  
            FROM `customer`
            WHERE email='$email' 
            AND password='".md5($password)."'";

            $result = mysqli_query($conn, $query) or die(mysqli_error($conn)); 
            $rows = mysqli_num_rows($result);

            if($rows==1){

               $userData = mysqli_fetch_assoc($result); 
                $_SESSION['custName'] = $userData['custName'];
                $_SESSION['custID'] = $userData['custID'];
                $_SESSION['last_timestamp'] = time();

                // $name =  $_SESSION['custName'];
                // $custID = $_SESSION['custID'];

                // echo "<script>alert('$name, $custID');
                // window.location.href = 'index.php';</script>";
               
                header("Location: index.php");
                exit(); 
            }else{ 
                echo "<script>alert('Email/Password is incorrect!');
                    window.location.href = 'register.php';</script>";
            }
        }
       
        else if (isset($_POST['register']) && $_POST['register'] == 2){
            $name = stripslashes($_REQUEST['name']);
            $name = mysqli_real_escape_string($conn,$name);  
            $email = stripslashes($_REQUEST['email']); 
            $email = mysqli_real_escape_string($conn,$email); 
            $password = stripslashes($_REQUEST['password']); 
            $password = mysqli_real_escape_string($conn,$password);
            $contactNum = stripslashes($_REQUEST['contactNum']); 
            $contactNum = mysqli_real_escape_string($conn,$contactNum); 
            $address = stripslashes($_REQUEST['contactNum']); 
            $address = mysqli_real_escape_string($conn,$address);

            //$reg_date = date("Y-m-d H:i:s");
            $query = "SELECT *  
            FROM `customer`
            WHERE email='$email'";
            
            $result = mysqli_query($conn,$query);
            $rows = mysqli_num_rows($result);

            if ($rows >= 1){
                echo "<script>alert('Register fail! Duplicate email address!');
                    window.location.href = 'register.php';</script>";

            } else {

                $query = "INSERT into `customer` (custName, email, contactNum, address, password)
                VALUES ('$name', '$email', '$contactNum', '$address', '".md5($password)."')"; 
                $result = mysqli_query($conn,$query);

                if($result){
                    echo "<script>alert('You have registered successfully！Please proceed to log in.');
                        window.location.href = 'register.php';</script>";
                }

            }
            

        }else{

            // if (isset($_GET['session_expired']) && $_GET['session_expired'] == 1) {
            //     echo "<script>alert('Your session has expired. Please log in again.');</script>";
            //     session_destroy();
            //     header("Location: register.php");
            // }
           

            ?>
            <div class="container">
                <input type="checkbox" id="flip">
                <div class="cover">
                <div class="front">
                    <img src="img/frontImg.jpg" alt="">
                    <div class="text">
                    <span class="text-1">ELECPRO</span>
                    <span class="text-2">Let's start</span>
                    </div>
                </div>
                <div class="back">
                    <img class="backImg" src="img/backImg.jpg" alt="">
                    <div class="text">
                    <span class="text-1">Complete miles of journey <br> with one step</span>
                    <span class="text-2">Let's get started</span>
                    </div>
                </div>
                </div>
                <div class="forms">
                    <div class="form-content">
                    <div class="login-form">
                        <div class="title">Login</div>
                    <form action="#" method="post" name="login">
                        <div class="input-boxes">
                        <input type="hidden" name="login" value=1>

                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="text" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" id ="loginPassword" name="password" placeholder="Enter your password" required>
                            <span class="input-group-addon border-0 opacityInput" id="loginIconPassword">
                                <u><i class="fa fa-eye text-white" style="cursor: pointer"></i></u>
                            </span>
                        </div>
                        <div class="text"><a href="#">Forgot password?</a></div>
                        <div class="button input-box">
                            <input type="submit" value="Submit">
                        </div>
                        <div class="text sign-up-text">Don't have an account? <label for="flip">Sign up now</label></div>
                        </div>
                        <div class="text sign-up-text">Already a staff? <label>Log in as staff here</label></div>
                    </form>
                </div>
                    <div class="signup-form">
                    <div class="title">Signup</div>
                    <form action="#" method="post" name="register">
                        <input type="hidden" name="register" value="2" required>
                        <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-user"></i>
                            <input type="text" name="name" placeholder="Enter your name" required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" placeholder="Enter your email" required>
                        </div>
                       
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" id ="registerPassword" name="password" placeholder="Enter your password" required>
                            <span class="input-group-addon border-0 opacityInput" id="registerIconPassword">
                                <u><i class="fa fa-eye text-white" style="cursor: pointer"></i></u>
                            </span>
                        </div>

                        <div class="input-box">
                            <i class="fas fa-phone"></i>
                            <input type="tel" class="form-control opacityInput border-0 text-white" 
                                name="contactNum"
                                pattern="^(\+60(\s+)1)[02-46-9]-*[0-9]{7}$|^(\+60(\s+)1)[1]-*[0-9]{8}$"
                                id="phone" placeholder="+60 1_________" data-slots="_"  required>
                        </div>

                        <div class="input-box">
                            <i class="fas fa-address-book"></i>
                            <input type="text" name="address" placeholder="Enter your address" required>
                        </div>
                        <div class="button input-box">
                            <input type="submit" value="Submit" id="registerBtn">
                        </div>
                        <div class="text sign-up-text">Already have an account? <label for="flip">Login now</label></div>
                        </div>
                </form>
                </div>
                </div>
                </div>
            </div>
            <?php 
        } 
        ?>

        <!-- Js Plugins -->
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.nice-select.min.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/jquery.slicknav.js"></script>
        <script src="js/mixitup.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/login-register.js"></script>
</body>
</html>


