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

//Total Deposit individul
function total_deposit_individula($id){
  global $db_connect;
  $total_query = "SELECT SUM(deposit) AS deposit FROM members WHERE id = '$id' AND delete_status = 1";
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

//Total Meal
function total_meal(){
  global $db_connect;
  $total_query = "SELECT SUM(total_meal) AS total_meal FROM members WHERE delete_status = 1";
  $total_meal_to_db = mysqli_query($db_connect, $total_query);
  $total_meal = mysqli_fetch_assoc($total_meal_to_db);

  return $total_meal['total_meal'];
}

//Total Meal for individula
function total_meal_individula($id){
  global $db_connect;
  $total_query = "SELECT SUM(total_meal) AS total_meal FROM members WHERE id = '$id' AND delete_status = 1";
  $total_meal_to_db = mysqli_query($db_connect, $total_query);
  $total_meal = mysqli_fetch_assoc($total_meal_to_db);

  return $total_meal['total_meal'];
}

//Total Cook  salary
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
  if(total_member() > 0) {
    $x =  cook_salary() / total_member();
    $update_query = "UPDATE members SET cooker_bill = '$x'";
    mysqli_query($db_connect, $update_query);

  }

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


//Meal Rate Calculation and insert into main table;
function meal_rate(){
  global $db_connect;

  $total_consumption = total_consumption();
  $total_member = total_meal();

  if( (total_meal() > 0) ){
    $meal_rate = total_consumption() / total_meal();
    $insert_to_main = "UPDATE members SET meal_rate = '$meal_rate'";
    mysqli_query($db_connect, $insert_to_main);
  
    return $meal_rate;
  }


}


// Final Calculation for Reporting
function final_calculation($id){
  global $db_connect;

  $total_deposit = total_deposit_individula($id);
  $total_meal = total_meal_individula($id);
  $meal_rate = meal_rate();
  $bill = $total_meal * meal_rate();

  if(total_member() > 0 ) {
    $cook_bill =  cook_salary() / total_member();

    $total_bill = $bill + $cook_bill;
    $balance =  $total_deposit - $total_bill;

    $update_query = "UPDATE members SET bill = '$bill', total_bill = '$total_bill', balance = '$balance' WHERE id = '$id'";
    mysqli_query($db_connect, $update_query);
  
  }
}


//Total trash count from consumption table
function consumption_trash_count(){
  global $db_connect;
  $total_query = "SELECT COUNT(id) AS consumption_trash_id FROM consumption WHERE delete_status = 2";
  $total_count_to_db = mysqli_query($db_connect, $total_query);
  $total_member = mysqli_fetch_assoc($total_count_to_db);

  return $total_member['consumption_trash_id'];
}


//Total trash count from deposite table
function deposit_trash_count(){
  global $db_connect;
  $total_query = "SELECT COUNT(id) AS deposit_trash_id FROM deposits WHERE delete_status = 2";
  $total_count_to_db = mysqli_query($db_connect, $total_query);
  $total_member = mysqli_fetch_assoc($total_count_to_db);

  return $total_member['deposit_trash_id'];
}


//Total trash count from all table
function total_trash_count(){
 $total_trash = consumption_trash_count() + deposit_trash_count();
 return $total_trash;
}




?>