<?php
include 'auth.php';
require './config/constant.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the value from the form
    $delitem = $_POST['id'];
    // Delete item from cart database
    $del_query="DELETE FROM cart WHERE custID='".$_SESSION['custID']."' AND prodID ='".$delitem."';";
    $result = mysqli_query($conn,$del_query) or die(mysqli_error($conn));
    echo var_dump($_POST);
}
?>