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
    <div class="d-flex align-items-center min-vh-100">
        <div class="container">
            <h1 class="text-white text-center">Register</h3>
            <div class="text-white text-center" style="font-size:14px">
                Have account? <a href="login.php"><span style="color:Aqua;">Sign in</span></a>
            </div>    
            <div class="row justify-content-center">
                <!-- Sign In / Sign Up -->
                <form name="sign-in-sign-up" action="index.html" method="post">
                    <div class="my-3">
                        <div class="form-group">
                            <input type="text" class="form-control opacityInput border-0 text-white" id="username" placeholder="Username" required>
                        </div>

                        <div class="form-group">
                            <p class="input-group">
                                <input type="password" class="form-control opacityInput border-0 text-white" id="password" placeholder="Password" required>
                                <span class="input-group-addon border-0 opacityInput" id="togglePassword">
                                    <i class="fa fa-eye text-white" style="cursor: pointer"></i>
                                </span>
                            </p>
                        </div>

                        <div class="form-group">
                            <input type="email" class="form-control opacityInput border-0 text-white" id="email" placeholder="Email" required>
                        </div>

                        <div class="form-group">
                            <input type="tel" class="form-control opacityInput border-0 text-white" pattern="^(\+60(\s+)1)[02-46-9]-*[0-9]{7}$|^(\+60(\s+)1)[1]-*[0-9]{8}$" id="phone" placeholder="+60 1_________" data-slots="_" required>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control opacityInput border-0 text-white" id="address" placeholder="Address" required>
                        </div>

                        <div>
                            <button type="submit" id="registerBtn" class="btn btn-light  w-100">Register</button>
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