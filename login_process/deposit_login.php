<?php
session_start();
$_SESSION['login_success'] = "successfully login";
header("location: ../deposit.php")
?>