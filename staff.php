<?php
require('./config/constant.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password']; 

    $sql = "SELECT staffID, staffName, password 
            FROM `staff`
            WHERE email = ? AND password = ?";

    $result = $conn->execute_query($sql, [$email, $password]);

    if ($result && $result->num_rows == 1) {
        
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
        // $_SESSION['show_staff_login'] = true;
        header("Location: staff_login.php");
        exit();
    }
}
?>
