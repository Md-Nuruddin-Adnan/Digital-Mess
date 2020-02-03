<?php
require_once("includes/db.php");

$id = $_GET['id'];

$consumption_accept_query = "UPDATE consumption SET status = 2 WHERE id = '$id'";
mysqli_query($db_connect, $consumption_accept_query);

header("location: consumption.php");

?>