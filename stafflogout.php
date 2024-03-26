<?php
session_start();

if(session_destroy())
{
header("Location: staff-login.php");
exit();
}
?>