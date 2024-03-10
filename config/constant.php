<?php
    //Start Session
    session_start();

    define('SITEURL','http://localhost/ogani-master/');
    define('LOCALHOST','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_NAME','electronic_order');

    $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD,DB_NAME) or die(mysqli_error($conn)); //database connection, default is root/blank
    // $db_select = mysqli_select_db($conn,DB_NAME) or die(mysqli_error($conn)); //selecting database
?>