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
    <?php
        if (isset($_POST['register'])) {
    
        $staffName = stripslashes($_REQUEST['staffName']);
        $staffName = mysqli_real_escape_string($conn, $staffName);
        $gender = stripslashes($_REQUEST['gender']); 
        $gender = mysqli_real_escape_string($conn, $gender);
        $age = stripslashes($_REQUEST['age']); 
        $age = mysqli_real_escape_string($conn, $age);
        $email = stripslashes($_REQUEST['email']); 
        $email = mysqli_real_escape_string($conn, $email);
        $contactNo = stripslashes($_REQUEST['contactNo']); 
        $contactNo = mysqli_real_escape_string($conn, $contactNo);
        $address = stripslashes($_REQUEST['address']); 
        $address = mysqli_real_escape_string($conn, $address);
        $salary = stripslashes($_REQUEST['salary']); 
        $salary = mysqli_real_escape_string($conn, $salary);
        $job = stripslashes($_REQUEST['job']); 
        $job = mysqli_real_escape_string($conn, $job);
        $password = stripslashes($_REQUEST['password']); 
        $password = mysqli_real_escape_string($conn, $password);

    
        $query = "SELECT * FROM `staff` WHERE email='$email'";
        $result = mysqli_query($conn, $query);
        $rows = mysqli_num_rows($result);

        if ($rows >= 1) {
            echo "<script>alert('Register failed! Email address already registered!');
                window.location.href = 'staff_login.php';</script>";
        } else {
       
            $query = "INSERT INTO `staff` (staffName, gender, age, email, contactNo, address, salary, job, password)
                      VALUES ('$staffName', '$gender', '$age', '$email', '$contactNo', '$address', '$salary', '$job', '$password')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<script>alert('You have registered successfully! Please proceed to log in.');
                    window.location.href = 'staff_login.php';</script>";
            } else {
                // In case of an error during insertion
                echo "<script>alert('Registration failed due to a database error.');
                    window.location.href = 'staff_register.php';</script>";
            }
        }
        } 
    ?>
    <!--Staff Login Section Begin-->
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
        </div>
        <div class="forms">
            <div class="form-content">
                <div class="login-form">
                    <div class="title">Staff Login</div>
                    <form action="staff.php" method="post" name="staff_login">
                    <div class="input-boxes">
                            <!-- <input type="hidden" name="staff_login" value=3 required> -->

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
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                    <?php endif; ?>

                    <div class="button input-box">
                        <input type="submit" value="Submit">
                    </div>
                    <div class="text sign-up-text">Want to be part of us? <label for="flip">Register as staff here</label></div>
                    <div class="text sign-up-text">Not a staff? <a href="register.php">Log in as user here</a></div>
                    </div>
                    </form>
                </div>

                <!-- Staff registration -->
            <div class="signup-form">
            <div class="title">Staff Registration</div>
                <form action="" method="post" name="register">
                    <input type="hidden" name="register" required>
                        <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-user"></i>
                            <input type="text" name="staffName" placeholder="Enter your name" required>
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
                                    name="contactNo"
                                    pattern="^(\+60(\s+)1)[02-46-9]-*[0-9]{7}$|^(\+60(\s+)1)[1]-*[0-9]{8}$"
                                    id="phone" placeholder="+60 1________" data-slots="_"  required>
                        </div>
                        <div class="input-box">
                        <i class="fas fa-venus-mars"></i>
                            <label style="padding-left: 60px;">Male<input type="radio" name="gender" value="M" required></label>
                            <label>Female<input type="radio" name="gender" value="F" required></label>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-briefcase"></i>
                            <input type="text" name="job" placeholder="Enter your job position eg: Sales/Admin" required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-dollar-sign"></i>
                            <input type="number" name="salary" placeholder="Enter your salary" required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-birthday-cake"></i>
                            <input type="number" name="age" placeholder="Enter your age" required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-address-book"></i>
                            <input type="text" name="address" placeholder="Enter your address" required>
                        </div>
                        <div class="button input-box">
                            <input type="submit" value="Submit" id="registerBtn">
                        </div>
                        <div class="text sign-up-text">Already part of us? <label for="flip">Login as staff here</label></div>
                        </div>
                </form>
            </div>
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