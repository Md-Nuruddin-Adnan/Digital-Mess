<?php
require_once('includes/auth.php');
require_once("includes/db.php");

$id = $_GET['id'];

$consumption_restore_query = "UPDATE consumption SET delete_status = 1 WHERE id = '$id'";
mysqli_query($db_connect, $consumption_restore_query);

header("location: consumption_trash_view.php");
 
?>