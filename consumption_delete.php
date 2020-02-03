<?php
require_once("includes/db.php");

$id = $_GET['id'];

//This query show data as delete. But if you want to show delete date you have to access database directly.
$consumption_delete_temporary = "UPDATE consumption SET delete_status = 3 WHERE id = '$id'";
mysqli_query($db_connect, $consumption_delete_temporary);

header("location: consumption_trash_view.php");
 
?>