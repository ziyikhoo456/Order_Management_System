<?php 
    session_start();

    $timeout_duration = 300;

    if (!isset($_SESSION['custID']) || !isset($_SESSION['custName']) || (time() - $_SESSION['last_timestamp']) > $timeout_duration) {
        session_unset();
        session_destroy();
        header("Location: register.php?session_expired=1");
        exit();
        
    } else {
        session_regenerate_id(true);
        $_SESSION['last_timestamp'] = time();
    }
?>
