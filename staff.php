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
