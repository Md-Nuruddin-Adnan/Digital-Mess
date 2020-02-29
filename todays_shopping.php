<?php
require_once('includes/auth.php');
require_once('includes/db.php');
require_once('includes/dashboard/header.php');
require_once('functions.php');

// form validation
if(isset($_POST['submit'])){
// form data validation
$shopping_date = check_data($_POST['shopping_date']);
$shopping_date = mysqli_real_escape_string($db_connect, $shopping_date);

$member_id = check_data($_POST['member_id']);
$member_id = mysqli_real_escape_string($db_connect, $member_id);

$total_consumption = check_data($_POST['total_consumption']);
$total_consumption = mysqli_real_escape_string($db_connect, $total_consumption);

$consumption_note = check_data($_POST['consumption_note']);
$consumption_note = mysqli_real_escape_string($db_connect, $consumption_note);


//validation start
  if(empty($shopping_date)){
    $shopping_date_err = "Please select a date";
  }
  else if(empty($member_id)){
    $number_err = "Please select a Member";
  }
  else if(empty($total_consumption)){
    $total_consumption_err = "Please enter shopping amount";
  }
  else if(!filter_var($total_consumption, FILTER_SANITIZE_NUMBER_INT)){
    $total_consumption_err = "Please enter a valid amount";
  }
  else if(filter_var($consumption_note, FILTER_SANITIZE_NUMBER_INT) || strlen($consumption_note) > 50){
    $consumption_note_err = "Please right a correct note";
  }
  else {

    $select_query = "SELECT * FROM members WHERE id = '$member_id' AND delete_status = 1";
    $select_query_to_db = mysqli_query($db_connect, $select_query);

    $datas_from_members = mysqli_fetch_assoc($select_query_to_db);

    $member_name = $datas_from_members['member_name'];
    $member_mobile = $datas_from_members['member_mobile'];

    $insert_query = "INSERT INTO consumption (member_id, member_name, member_mobile, total_consumption, consumption_note, date) VALUES ('$member_id', '$member_name', '$member_mobile', '$total_consumption ', '$consumption_note', '$shopping_date')";
     mysqli_query($db_connect, $insert_query);

     //update meal rete in main table
     meal_rate();

     
    $success_msg = "Todays shopping amout diposit successfully";

  }
}

//Total members data
$show_members_query = "SELECT * FROM members WHERE delete_status = 1";
$datas = mysqli_query($db_connect, $show_members_query);
?>

<style>
.form-control {
  border: 1px solid #dddddd;
  border-radius: 4px;
}
</style>

<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
<?php
require_once('includes/dashboard/top_nav.php');
?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
<div class="row row-offcanvas row-offcanvas-right">

<?php
require_once('includes/dashboard/right_sidebar_with_settings.php');
require_once('includes/dashboard/left_sidebar.php');
?>

<div class="content-wrapper">


<!-- === New content start === -->
<div class="row">
  <div class="col-xl-6 col-lg-12 m-auto">
    <div class="card">
      <div class="card-header text-center text-dark bg-white" >
        <h2> Todays Shoppoing </h2>
      </div>
      <div class="card-body">
        <form action="" method="POST">
          <div class="form-group">
            <label for="shopping_daate"></label>
            <input type="date" id="shopping_date" class="form-control" placeholder="select a date" name="shopping_date">
            <?php if(isset($shopping_date_err)) :?>
              <div class="alert alert-danger mt-2"> <?=$shopping_date_err;?> </div>
            <?php endif?>
          </div>
          <div class="form-group">
            <label for="member_id">Person: </label>
            <select class="form-control" name="member_id" id="member_id">
            <option value="">Select a person</option>
            <?php foreach($datas as $data): ?>
              <option value="<?=$data['id']?>"><?=$data['member_name']?></option>
            <?php endforeach;?>
            </select>
            <?php if(isset($number_err)) :?>
              <div class="alert alert-danger mt-2"> <?=$number_err;?> </div>
            <?php endif?>
          </div>
          <div class="form-group">
            <label for="total_consumption">Amount: </label>
            <input type="text" class="form-control" name="total_consumption">
            <?php if(isset($total_consumption_err)) :?>
              <div class="alert alert-danger mt-2"> <?=$total_consumption_err;?> </div>
            <?php endif?>
          </div>
          <div class="form-group">
            <label for="consumption_note">Shopping Note (optional):</label>
            <textarea name="consumption_note" id="consumption_note" rows="6" class="form-control" placeholder="write a short note..."></textarea>
            <?php if(isset($consumption_note_err)) :?>
              <div class="alert alert-danger mt-2"> <?=$consumption_note_err;?> </div>
            <?php endif?>

            <!-- Success message -->
            <?php if(isset( $success_msg)) :?>
              <div class="alert alert-success mt-2"> <?= $success_msg;?> </div>
            <?php endif?>
          </div>
          <div class="form-group text-center">
            <input type="submit" value="Submit" class="btn btn-danger px-5" name="submit">
          </div>
        </form>

      </div>
      </div>

  </div>
</div>
<!-- ===// end of new content === -->

<!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2020 <a href="dashboard.php">Digital Mess</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- row-offcanvas ends -->
  </div>
  <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<?php
require_once('includes/dashboard/footer.php');
?>
