<?php
    require('./config/constant.php');
    session_start();

    $inactive = 300; //5(min)*60 = 300 seconds

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['staffName'])) {
    header("Location: staff_login.php");
    exit();
}

    //server-side check of inactivity (only making any request to server will respond(trigger the inactivity))
    if (isset($_SESSION['last_log_in']) && (time() - $_SESSION['last_log_in']) > $inactive) {

    session_destroy(); //log staff out 
    echo "<script>alert('Due to inactivity, you have been logged out.'); window.location.href='staff_login.php';</script>";
    exit();
}

$_SESSION['last_log_in'] = time();  //update last activity time after inactivity check

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Staff Dashboard | ELECPRO</title>
    <link rel="icon" href="img/logo2.png" type="image/png">
</head>

<body>
    <div class="dashboard-container">
    <h1 class="dashboard-title">Staff Dashboard</h1>
        <h2>Welcome back, <?php echo htmlspecialchars($_SESSION['staffName']); ?>!</h2>
        <div class="dashboard-buttons">
        <a href="create_product.php" class="dashboard-button create">
        Create New Product <i class="fa fa-plus-circle"></i>
        </a>
        <a href="view_product.php" class="dashboard-button view">
        View Product <i class="fa fa-eye"></i>
        </a>
        <a href="update_product.php" class="dashboard-button update">
        Edit Product <i class="fa fa-edit"></i>
        </a>
        <a href="delete_product.php" class="dashboard-button delete">
        Delete Product <i class="fa fa-trash"></i> 
        </a>
        <a href="logout.php" class="dashboard-button logout">
        Logout <i class="fa fa-sign-out"></i> 
        </a>
        </div>
    </div>
    <!-- Inactivity logout, no remember me & cookie set as for more secure log in of staff -->
</body>
</html>