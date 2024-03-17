<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the value from the form
    $discount = $_POST["discount"];
    $realtotal = $_POST["realtotal"];
        if ($discount == "elecpro40"){
        echo "$".$realtotal*0.6;
        }
        else{
            echo "$".$realtotal;
            echo "<br> Invalid Discount Code.";
        }
}
?>