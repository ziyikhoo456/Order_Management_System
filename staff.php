<?php
require('./config/constant.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staffname = $_POST['staffname'];
    $password = $_POST['password']; 

    $sql = "SELECT staffID, staffName, password 
            FROM staff 
            WHERE staffName = ? AND password = ?";

    $result = $conn->execute_query($sql, [$staffname, $password]);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

            //prevent session fixtion attk 
            session_regenerate_id();

            $_SESSION['loggedin'] = true;
            $_SESSION['staffID'] = $row['staffID'];
            $_SESSION['staffName'] = $row['staffName'];

            header("Location: staffdashboard.php");
            exit();
        
    }  
    else {
        //staff not found 
        $_SESSION['error'] = "Invalid staff credentials. Please try again or login as user.";
        header("Location: staff-login.php");
        exit();
    }
}
?>

<!-- <!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ELECPRO</title>


    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">

</head>
<body>
    
</body> -->



