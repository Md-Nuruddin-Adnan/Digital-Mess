<?php
require_once('includes/auth.php');
require_once('includes/db.php');
require_once('includes/dashboard/header.php');
require_once('functions.php');

// form validation
if(isset($_POST['submit'])){
// form data validation
$id = check_data($_POST['id']);
$id = mysqli_real_escape_string($db_connect, $id);

$member_id = check_data($_POST['member_id']);
$member_id = mysqli_real_escape_string($db_connect, $member_id);

$total_deposit = check_data($_POST['total_deposit']);
$total_deposit = mysqli_real_escape_string($db_connect, $total_deposit);

//validation start
  if(empty($id )){
    $id_err = "Please enter ID. NO.";
  }
  else if(!filter_var($id , FILTER_VALIDATE_INT)){
    $id_err = "Please enter a valid ID. NO";
  }
  else if(empty($member_id)){
    $number_err = "Please select a Member";
  }
  else if(empty($total_deposit)){
    $total_deposit_err = "Please enter shopping amount";
  }
  else if(!filter_var($total_deposit, FILTER_SANITIZE_NUMBER_INT)){
    $total_deposit_err = "Please enter a valid amount";
  }
  else {

    if(!($member_id == $id)){
      $number_err = "This id is not for this name";
    }
    else {
      $select_query = "SELECT * FROM members WHERE id = '$member_id' AND delete_status = 1";
      $select_query_to_db = mysqli_query($db_connect, $select_query);

      $datas_from_members = mysqli_fetch_assoc($select_query_to_db);

      $member_name = $datas_from_members['member_name'];
      $member_mobile = $datas_from_members['member_mobile'];

      $insert_query = "INSERT INTO deposits (member_id, deposit_name, deposit_amount) VALUES ('$member_id', '$member_name', '$total_deposit')";
       mysqli_query($db_connect, $insert_query);

       //insert deposit to main tabel
       single_diposit_insert($member_id);

       //update information to main table
      //  final_calculation($member_id);
       
      $success_msg = $member_name."'s Dposit Successfull";
    }

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

<div class="card">
  <div class="card-header text-center text-dark bg-white" >
    <h2> Todays Deposit </h2>
  </div>
  <div class="card-body">
    <form action="" method="POST">

      <div class="form-group">
        <label for="id">ID. No: </label>
        <input type="text" class="form-control" name="id">
        <?php if(isset($id_err)) :?>
          <div class="alert alert-danger mt-2"> <?=$id_err;?> </div>
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
        <label for="total_deposit">Deposit Amount: </label>
        <input type="text" class="form-control" name="total_deposit">
        <?php if(isset($total_deposit_err)) :?>
          <div class="alert alert-danger mt-2"> <?=$total_deposit_err;?> </div>
        <?php endif?>
        <?php if(isset($success_msg)) :?>
          <div class="alert alert-success mt-2"> <?=$success_msg;?> </div>
        <?php endif?>
      </div>

      <div class="form-group text-center">
        <input type="submit" value="Submit" class="btn btn-danger px-5" name="submit">
      </div>

    </form>

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
