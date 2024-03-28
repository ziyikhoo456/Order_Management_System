<?php 
    session_start();

    $timeout_duration = 600;

    //Check if customer ID and customer name are stored in session and if the session is timeout 
    if (!isset($_SESSION['custID']) || !isset($_SESSION['custName']) || (time() - $_SESSION['last_timestamp']) > $timeout_duration) {

        //Destroy the session and return to login/register page
        session_unset();
        session_destroy();
        header("Location: register.php?session_expired=1");
        exit();
        
    } else {
        //regenerate new session id and renew time stamp
        session_regenerate_id(true);
        $_SESSION['last_timestamp'] = time();
    }
?>
