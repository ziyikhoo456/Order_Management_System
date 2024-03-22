<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELECPRO | Login</title>

    <link rel="stylesheet" href="./css/login.css" type="text/css">
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
            <h1 class="text-white text-center">Have an account?</h3>    
            <div class="text-white text-center" style="font-size:14px">
                New user? <a href=""><span style="color:Aqua;">Register</span></a>
            </div>
            <div class="row justify-content-center">
                <!-- Sign In / Sign Up -->
                <form name="sign-in-sign-up" action="index.html" method="post">
                    <div class="my-3">
                        <div class="form-group">
                            <input type="text" class="form-control opacityInput border-0 text-white" id="username" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <p class="input-group">
                                <input type="password" class="form-control opacityInput border-0 text-white" id="password" placeholder="Password">
                                <span class="input-group-addon border-0 opacityInput" id="togglePassword">
                                    <i class="fa fa-eye text-white" style="cursor: pointer"></i>
                                </span>
                            </p>
                        </div>
                            <button type="submit" name="signInBtn" class="btn btn-light  w-100">Sign In</button>
                        </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMeCheck">
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
    <script src="js/login.js"></script>
</body>
</html>