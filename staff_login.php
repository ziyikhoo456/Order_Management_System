<?php
    session_start();
    require('config/constant.php');
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
    <div class="container">
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
                    <div class="title">Staff Login</div>
                <form action="staff.php" method="post" name="staff_login">
                    <div class="input-boxes">
                    <input type="hidden" name="login" value=1>

                    <div class="input-box">
                        <i class="fas fa-envelope"></i>
                        <input type="text" name="email" placeholder="Enter your email" required oninput="clearErrorMessage()">
                    </div>
                    <div class="input-box">
                        <i class="fas fa-lock"></i>
                        <input type="password" id ="loginPassword" name="password" placeholder="Enter your password" required oninput="clearErrorMessage()">
                        <span class="input-group-addon border-0 opacityInput" id="loginIconPassword">
                            <u><i class="fa fa-eye text-white" style="cursor: pointer"></i></u>
                     </span>
                    </div>
                    <?php if (isset($_SESSION['error'])): ?>
                        <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                    <?php endif; ?>
                    <div class="button input-box">
                        <input type="submit" value="Submit">
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