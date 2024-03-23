<?php 
    require('config/constant.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELECPRO | Login</title>

    <link rel="stylesheet" href="./css/login-register.css" type="text/css">
    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
</head>
<body class="bg-transparent">
    <?php
        function is_post_request():bool
        {
            return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST'; 
        }

        if(is_post_request()){

            //check if the user has registered
            $email = stripslashes($_REQUEST['email']);
            $email = mysqli_real_escape_string($conn, $email);

            $sql =
            "SELECT custID 
            FROM customer
            WHERE email='admin@admin.com'";

            $result = $conn->execute_query($sql);
            // $result = $conn->execute_query($sql,[$email]);
            if($result){
                echo "
                <script>
                    alert('The email has already registered.');
                </script>";
            }
            else
            {
                $username = stripslashes($_POST['username']);
                $username = mysqli_real_escape_string($conn,$username);
                $password = stripslashes($_REQUEST['password']);
                $password = mysqli_real_escape_string($conn, $password);
                $phone = stripslashes($_REQUEST['phone']);
                $phone = mysqli_real_escape_string($conn, $phone);
                $address = stripslashes($_REQUEST['address']);
                $address = mysqli_real_escape_string($conn, $address);
    
                $sql = 
                "INSERT INTO customer(custName, password, email, contactNum, address)
                VALUES(?,?,?,?,?)";
                // VALUES('$username','$password','$email','$phone','$address')";
    
                $result = $conn->execute_query($sql,[$username,md5($password),$email,$phone,$address]);
    
                if($result){
                    header('Location: login.php');
                    exit();
                }
            }
        }
    ?>


    <div class="d-flex align-items-center min-vh-100">
        <div class="container">
            <h1 class="text-white text-center">Register</h1>
            <div class="text-white text-center" style="font-size:14px">
                Have account? <a href="login.php"><span style="color:Aqua;">Sign in</span></a>
            </div>    
            <div class="row justify-content-center">
                <!-- Sign In / Sign Up -->
                <form name="register" action="register.php" method="post">
                    <div class="my-3">
                        <div class="form-group">
                            <input type="text" class="form-control opacityInput border-0 text-white" name="username" id="username" placeholder="Username" required>
                        </div>

                        <div class="form-group">
                            <p class="input-group">
                                <input type="password" class="form-control opacityInput border-0 text-white" name="password" id="password" placeholder="Password" required>
                                <span class="input-group-addon border-0 opacityInput" id="togglePassword">
                                    <i class="fa fa-eye text-white" style="cursor: pointer"></i>
                                </span>
                            </p>
                        </div>

                        <div class="form-group">
                            <input type="email" class="form-control opacityInput border-0 text-white" name="email" id="email" placeholder="Email" required>
                        </div>

                        <div class="form-group">
                            <input type="tel" class="form-control opacityInput border-0 text-white" name="phone" pattern="^(\+60(\s+)1)[02-46-9]-*[0-9]{7}$|^(\+60(\s+)1)[1]-*[0-9]{8}$" id="phone" placeholder="+60 1_________" data-slots="_" required>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control opacityInput border-0 text-white" name="address" id="address" placeholder="Address" required>
                        </div>

                        <div>
                            <button type="submit" id="registerBtn" class="btn btn-light  w-100">Register</button>
                        </div>

                        <div id="registerMessage" class="text-white text-center" style="margin-top: 10px;">
                            <!-- The email has already registered.  -->
                        </div>    
                    </div>
                </form>
            </div>
        </div>
    </div>
    
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