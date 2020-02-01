<?php
require_once("includes/db.php");

global $db_connect;

//input validation check 
function check_data($data){
  $trim_data = trim($data);
  $stripcslashes_data = stripcslashes($trim_data);
  $stripslashes_data = stripslashes($stripcslashes_data);
  $final_data = htmlspecialchars($stripslashes_data);

  return $final_data;
}

//Total Deposit
function total_deposit(){
  global $db_connect;
  $total_query = "SELECT SUM(deposit) AS deposit FROM members WHERE delete_status = 1";
  $total_deposit_to_db = mysqli_query($db_connect, $total_query);
  $total_deposit = mysqli_fetch_assoc($total_deposit_to_db);

  return $total_deposit['deposit'];
}

//Total Consumption
function total_consumption(){
  global $db_connect;
  $total_query = "SELECT SUM(total_consumption) AS consumption FROM consumption WHERE delete_status = 1";
  $total_consumption_to_db = mysqli_query($db_connect, $total_query);
  $total_consumption = mysqli_fetch_assoc($total_consumption_to_db);

  return $total_consumption['consumption'];
}

//cook information
function cook_information($data){
  global $db_connect;
  $select_query = "SELECT $data as information FROM cooks WHERE delete_status = 1";
  $query_to_db = mysqli_query($db_connect, $select_query);
  $final_information = mysqli_fetch_assoc($query_to_db);

  echo $final_information['information'];
}


//Total member
function total_member(){
  global $db_connect;
  $total_query = "SELECT COUNT(id) AS id FROM members WHERE delete_status = 1";
  $total_count_to_db = mysqli_query($db_connect, $total_query);
  $total_member = mysqli_fetch_assoc($total_count_to_db);

  return $total_member['id'];
}

//Total member
function cook_salary(){
  global $db_connect;
  $total_query = "SELECT SUM(cook_salary) AS cook_salary FROM cooks WHERE delete_status = 1";
  $total_count_to_db = mysqli_query($db_connect, $total_query);
  $total_salary = mysqli_fetch_assoc($total_count_to_db);

  return $total_salary['cook_salary'];
}


// Cook bill insert to main Table
function cook_bill_insert() {
  global $db_connect;
  $x =  cook_salary() / total_member();
  $update_query = "UPDATE members SET cooker_bill = '$x'";
  mysqli_query($db_connect, $update_query);
}
//cock bill inserted
cook_bill_insert();

// indivisual diposti amoutn insert to main table with sum
function single_diposit_insert($id){
  global $db_connect;
  $total_deposit = "SELECT SUM(deposit_amount) AS total_deposit FROM deposits WHERE member_id = '$id'";
  $total_deposit_to_db = mysqli_query($db_connect, $total_deposit);
  $total_deposit  = mysqli_fetch_assoc($total_deposit_to_db);
  $total_deposit = $total_deposit['total_deposit'];

  $insert_to_main = "UPDATE members SET deposit = '$total_deposit' WHERE id = '$id'";
  mysqli_query($db_connect, $insert_to_main);
}














?>