<?php
require_once('includes/auth.php');
require_once('includes/db.php');
require_once('includes/dashboard/header.php');
require_once('functions.php');

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
  else if(!filter_var($member_mobile, FILTER_SANITIZE_NUMBER_INT) || (strlen($member_mobile) < 11 || strlen($member_mobile) > 11 )){
    $number_err = "Please enter a valid number";
  }
  else {
    $show_query = "SELECT * FROM members WHERE member_email = '$member_email'";
    $datas = mysqli_query($db_connect, $show_query);

    $show_query_for_number = "SELECT * FROM members WHERE  member_mobile = '$member_mobile'";
    $number_datas = mysqli_query($db_connect, $show_query_for_number);

    if(!$datas->num_rows == 0){
      $email_err = "This email is already used";
    }
    else if (!$number_datas->num_rows == 0){
      $number_err = "This number is already used";
    }
    else {
      $insert_to_master_query = "INSERT INTO members (member_name, member_email, member_mobile) VALUES ('$member_name', '$member_email', '$member_mobile')";
      mysqli_query($db_connect, $insert_to_master_query);
      
      $success_msg = "One new member add successfully";

      header("location: dashboard.php");
    }


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
    <h2> Add New Member </h2>
  </div>
  <div class="card-body">
    <form action="" method="POST">
      <div class="form-group">
        <label for="member_name">Name:</label>
        <input type="text" id="member_name" class="form-control" name="member_name" 
        <?php if(isset($member_name)) :?>
          value="<?=$member_name;?>" 
        <?php endif?>
        >
        <?php if(isset($name_err)) :?>
          <div class="alert alert-danger mt-2"> <?=$name_err;?> </div>
        <?php endif?>
      </div>
      <div class="form-group">
        <label for="member_email">Email Adress:</label>
        <input type="text" id="member_email" class="form-control" name="member_email" 
        <?php if(isset($member_email)) :?>
          value="<?=$member_email;?>" 
        <?php endif?>
        >
        <?php if(isset($email_err)) :?>
          <div class="alert alert-danger mt-2"> <?=$email_err;?> </div>
        <?php endif?>
      </div>
      <div class="form-group">
        <label for="member_mobile">Mobile Number:</label>
        <input type="text" id="member_mobile" class="form-control" name="member_mobile" 
        <?php if(isset($member_mobile)) :?>
          value="<?=$member_mobile;?>" 
        <?php endif?>
        >
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
