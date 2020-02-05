<?php
require_once('includes/auth.php');
require_once("includes/db.php");

$id = $_GET['id'];

$deposits_restore_query = "UPDATE deposits SET delete_status = 1 WHERE id = '$id'";
mysqli_query($db_connect, $deposits_restore_query);

header("location: deposit_trash_view.php");
 
?>