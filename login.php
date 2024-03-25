<?php 
    require('config/constant.php');
    include('auth.php');
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
        //check if the user selected logout
        if(isset($_GET['fn'])){
            if($_GET['fn'] == "logout"){
                logout();
            }
        }

        function is_post_request():bool
        {
            return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST'; 
        }
    ?>

    <div class="d-flex align-items-center min-vh-100">
        <div class="container">
            <?php
                if(is_post_request()){
                            
                    $username = stripslashes($_POST['username']);
                    $username = mysqli_real_escape_string($conn,$username);
                    $password = stripslashes($_POST['password']);
                    $password = mysqli_real_escape_string($conn, $password);

                    $sql = 
                    "SELECT custName
                    FROM customer
                    WHERE custName=? AND password=?";

                    $result=$conn->execute_query($sql,[$username,md5($password)]);
                    $count=mysqli_num_rows($result);

                    if($count < 1)
                    {
                        //login fail
                        echo"<div  class='alert alert-danger' role='alert'>Invalid email or password</div>";
                    }
                    else{
                        $_SESSION['username'] = $username;

                        //prevent session fixation attack
                        session_regenerate_id();

                        if(isset($_POST['rememberMeCheck'])){
                            $cookie_name = "user";
                            $cookie_value = $username;
                            $expiration_time = time() + 60*60*24*30;
                            setcookie($cookie_name,$cookie_value,$expiration_time,"/");
                        }

                        //login success
                        header('Location: index.php');
                    }
                }
                else{
                    $username="";
                }
            ?>
            <h1 class="text-white text-center">Have an account?</h1>    
            <div class="text-white text-center" style="font-size:14px">
                New user? <a href="register.php"><span style="color:Aqua;">Register</span></a>
            </div>
            <div class="row justify-content-center">
                <!-- Sign In / Sign Up -->
                <form name="sign-in" action="login.php" method="post">
                    <div class="my-3">
                        <div class="form-group">
                            <input type="text" class="form-control opacityInput border-0 text-white" name="username" id="username" placeholder="Username" value="<?php echo $username?>" required>
                        </div>
                        <div class="form-group">
                            <p class="input-group">
                                <input type="password" class="form-control opacityInput border-0 text-white" id="password" name="password" placeholder="Password" required>
                                <span class="input-group-addon border-0 opacityInput" id="togglePassword">
                                    <i class="fa fa-eye text-white" style="cursor: pointer"></i>
                                </span>
                            </p>
                        </div>
                        <div>
                            <button type="submit" id="signInBtn" class="btn btn-light  w-100">Sign In</button>
                        </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="rememberMeCheck" id="rememberMeCheck">
                        <label class="form-check-label text-white" for="rememberMeCheck">Remember Me</label>
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