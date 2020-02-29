<?php
require_once('includes/auth.php');
require_once('includes/db.php');
require_once('includes/dashboard/header.php');
require_once('functions.php');

$member_id = $_GET['id'];

$member_select_query = "SELECT * FROM members WHERE id = '$member_id'";
$member_to_db = mysqli_query($db_connect, $member_select_query);
$member_info = mysqli_fetch_assoc($member_to_db);

// form validation
if(isset($_POST['submit'])){
// form data validation
$member_name = check_data($_POST['member_name']);
$member_name = mysqli_real_escape_string($db_connect, $member_name);

$member_email = check_data($_POST['member_email']);
$member_email  = mysqli_real_escape_string($db_connect, $member_email );

$member_mobile = check_data($_POST['member_mobile']);
$member_mobile = mysqli_real_escape_string($db_connect, $member_mobile);


  if(empty($member_name)){
    $name_err = "Please enter a name";
  }
  else if(filter_var($member_name, FILTER_SANITIZE_NUMBER_INT) || strlen($member_name) < 3){
    $name_err = "Please enter a valid name";
  }
  else if(empty($member_email)){
    $email_err = "Please enter email address";
  }
  else if(!filter_var($member_email, FILTER_VALIDATE_EMAIL)){
    $email_err = "Please enter a valid email";
  }
  else if(empty($member_mobile)){
    $number_err = "Please enter mobile number";
  }
  else if(!preg_match('/^\d{11}$/', $member_mobile)){
    $number_err = "Please enter a valid number";
  }
  else {
    $update_query = "UPDATE members SET member_name = '$member_name', member_email= '$member_email', member_mobile = '$member_mobile' WHERE id = '$member_id'";
    mysqli_query($db_connect, $update_query);
    
    $success_msg = $_SESSION['success_msg'] = $member_info['member_name']." updated successfully";

    header("location: dashboard.php");



  }

}
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
    <h2>  <?=$member_info['member_name']?></h2>
  </div>
  <div class="card-body">
    <form action="" method="POST">
      <div class="form-group">
        <label for="member_name">Name:</label>
        <input type="text" id="member_name" class="form-control" name="member_name" value="<?=$member_info['member_name']?>">
        <?php if(isset($name_err)) :?>
          <div class="alert alert-danger mt-2"> <?=$name_err;?> </div>
        <?php endif?>
      </div>
      <div class="form-group">
        <label for="member_email">Email Adress:</label>
        <input type="text" id="member_email" class="form-control" name="member_email" value="<?=$member_info['member_email']?>">
        <?php if(isset($email_err)) :?>
          <div class="alert alert-danger mt-2"> <?=$email_err;?> </div>
        <?php endif?>
      </div>
      <div class="form-group">
        <label for="member_mobile">Mobile Number:</label>
        <input type="text" id="member_mobile" class="form-control" name="member_mobile"  value="0<?=$member_info['member_mobile']?>" >
        <?php if(isset($number_err)) :?>
          <div class="alert alert-danger mt-2"> <?=$number_err;?> </div>
        <?php endif?>
      </div>
      <?php if(isset($success_msg)) :?>
        <div class="alert alert-success mt-2"> <?=$success_msg;?> </div>
      <?php endif?>
      <div class="form-group text-center">
        <input type="submit" value="Add New" class="btn btn-success px-5" name="submit">
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
