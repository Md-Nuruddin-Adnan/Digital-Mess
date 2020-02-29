<?php
require_once('includes/db.php');

$member_id = $_POST["member_id"];
$shopping_date = $_POST["shopping_date"];

$show_member_query = "SELECT * FROM members WHERE id = '$member_id'";
$member_db = mysqli_query($db_connect, $show_member_query);
$member_information = mysqli_fetch_assoc($member_db);

$member_id = $member_information['id'];
$member_name = $member_information['member_name'];

$insert_query = "INSERT INTO shoppers (member_id, shopper_name, shopping_date) VALUES ('$member_id', '$member_name ', '$shopping_date')";
mysqli_query($db_connect, $insert_query);

header("location: shopper_list.php");

?>