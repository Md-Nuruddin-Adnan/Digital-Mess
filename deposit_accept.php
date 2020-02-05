<?php
require_once('includes/auth.php');
require_once("includes/db.php");

$id = $_GET['id'];

$deposits_accept_query = "UPDATE deposits SET status = 2 WHERE id = '$id'";
mysqli_query($db_connect, $deposits_accept_query);

header("location: deposit.php");

?>