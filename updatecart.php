<?php
include 'auth.php';
require './config/constant.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the value from the form
    $sel_query="SELECT * FROM cart WHERE custID='".$_SESSION['custID']."';";
    $result = mysqli_query($conn,$sel_query) or die(mysqli_error($conn));
    while($row = mysqli_fetch_assoc($result)) {
        $newquantity = $_POST[$row['prodID']];
        if ($newquantity == 0){
            $delete = "DELETE FROM cart WHERE custID='".$_SESSION['custID']."' AND prodID ='".$row['prodID']."' ;";
            mysqli_query($conn, $delete) or die(mysqli_error($conn));
        }
        else{
        $update="UPDATE cart set prodQuantity='".$newquantity."' WHERE custID='".$_SESSION['custID']."' AND prodID ='".$row['prodID']."' ;";
        mysqli_query($conn, $update) or die(mysqli_error($conn));
        }
    }       
    echo "Done";
}
?>