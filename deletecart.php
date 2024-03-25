<?php
require './config/constant.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the value from the form
    $delitem = $_POST['id'];
    $del_query="DELETE FROM cart WHERE custID='".$_SESSION['ID']."' AND prodID ='".$delitem."';";
    $result = mysqli_query($conn,$del_query) or die(mysqli_error($conn));
    echo var_dump($_POST);
}
?>