<?php
require('./config/constant.php');
session_start();

$inactive = 300; //5(min)*60 = 300 seconds

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['staffName'])) {
    header("Location: staff-login.php");
    exit();
}

//server-side check of inactivity (only making any request to server will respond(trigger the inactivity))
if (isset($_SESSION['last_log_in']) && (time() - $_SESSION['last_log_in']) > $inactive) {

    session_destroy(); //log staff out 
    echo "<script>alert('Due to inactivity, you have been logged out.'); window.location.href='staff-login.php';</script>";
    exit();
}

$_SESSION['last_log_in'] = time();  //update last activity time after inactivity check

?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ELECPRO</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">

    <!-- for client-side check of inactivity (request once user(staff) did not make any movement(trigger the inactivity function))  -->
    <script>
        setTimeout(function()
        {
            alert('Due to inactivity, you have been logged out.');
            window.location.href = "staff-login.php";
        }, 300000); //milliseconds, 1seconds = 10000ms
    </script> 

</head>

<body>
    <h2>Welcome back <?php echo $_SESSION['staffName']; ?></h2>
    <a href="create_product.php">Create New Product</a><br>
    <a href="update_product.php">Edit Product</a><br>
    <a href="view_product.php">View Product</a><br>
    <a href="delete_product.php">Delete Product</a><br>
    <a href="logout.php">Logout</a>

    <!-- Inactivity logout, no remember me & cookie set as for more secure log in of staff -->
    
</body>