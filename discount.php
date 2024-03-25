<?php

include 'auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the value from the form
    $discount = $_POST["discount"];
    $realtotal = $_POST["realtotal"];
        if ($discount == "elecpro40"){
        echo $realtotal*0.4;
        $_SESSION['discount'] = 0.4;
        }
        else{
            echo "Invalid Discount Code.";
            $_SESSION['discount'] = 0;
        }
}
?>