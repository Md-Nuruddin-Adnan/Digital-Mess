<?php
require_once('includes/auth.php');
require_once("includes/db.php");

$id = $_GET['id'];

//This query show data as delete. But if you want to show delete date you have to access database directly.
$deposits_delete_temporary = "UPDATE deposits SET delete_status = 3 WHERE id = '$id'";
mysqli_query($db_connect, $deposits_delete_temporary);

header("location: deposit_trash_view.php");
 
?>