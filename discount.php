<?php

include 'auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the value from the form
    // Just checking for discount is matching
    $discount = $_POST["discount"];
    $realtotal = $_POST["realtotal"];
        if ($discount == "elecpro40"){
        echo number_format((float)$realtotal*0.4,2,'.','');
        $_SESSION['discount'] = 0.4;
        }
        else{
            echo "Invalid Discount Code.";
            $_SESSION['discount'] = 0;
        }
}
?>