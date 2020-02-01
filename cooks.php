<?php
session_start();
if(!isset($_SESSION['login_success'])){
  header("location: index.php");
}

require_once('includes/db.php');
require_once('includes/dashboard/header.php');
require_once('functions.php');

// form validation
if(isset($_POST['submit'])){
// form data validation
$cook_name = check_data($_POST['cook_name']);
$cook_name = mysqli_real_escape_string($db_connect, $cook_name);

$cook_mobile = check_data($_POST['cook_mobile']);
$cook_mobile  = mysqli_real_escape_string($db_connect, $cook_mobile );

$cook_address = check_data($_POST['cook_address']);
$cook_address = mysqli_real_escape_string($db_connect, $cook_address);

$cook_salary = check_data($_POST['cook_salary']);
$cook_salary = mysqli_real_escape_string($db_connect, $cook_salary);

  if(empty($cook_name)){
    $name_err = "Please enter a name";
  }
  else if(filter_var($cook_name, FILTER_SANITIZE_NUMBER_INT) || strlen($cook_name) < 3){
    $name_err = "Please enter a valid name";
  }
  else if(empty($cook_mobile)){
    $number_err = "Please enter mobile number";
  }
  else if(!filter_var($cook_mobile, FILTER_SANITIZE_NUMBER_INT) || strlen($cook_mobile) < 11){
    $number_err = "Please enter a valid number";
  }
  else if(empty($cook_address)){
    $cook_address_err = "Please enter address";
  }
  else if(empty($cook_salary)){
    $cook_salary_err = "Please enter a salary amount";
  }
  else if(!filter_var($cook_salary, FILTER_VALIDATE_INT)){
    $cook_salary_err = "Please enter a valid amount";
  }
  else {

    $cook_update_query = "UPDATE cooks SET cook_name = '$cook_name', cook_mobile = '$cook_mobile', cook_address = '$cook_address', cook_salary = '$cook_salary'";
    mysqli_query($db_connect, $cook_update_query);

    $success_msg = "Cook Update Succefully";

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
<div class="row">
    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-md-center">
            <i class="mdi mdi-basket icon-lg text-success"></i>
            <div class="ml-3">
              <p class="mb-0">Cook Bill</p>
              <h6><?=cook_salary()?> TK</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-md-center">
            <i class="mdi mdi-rocket icon-lg text-warning"></i>
            <div class="ml-3">
              <p class="mb-0">Total Members</p>
              <h6><?=total_member()?></h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-md-center">
            <i class="mdi mdi-chart-line-stacked icon-lg text-danger"></i>
            <div class="ml-3">
              <p class="mb-0">Bill Per Members</p>
              <h6><?= cook_salary() / total_member();?> TK</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- === cooks information start === -->
  <div class="card mt-2 mb-4 pt-4">
    <div class="card-hader text-center">
    <h2> Cooks Informatioan </h2>
   </div>
    <div class="card-body">
      <table class="table">
        <tbody>
          <tr>
            <th scope="row">Name: </th>
            <td><?=cook_information('cook_name')?></td>
          </tr>
          <tr>
            <th scope="row">Mobile: </th>
            <td>+880 <?=cook_information('cook_mobile')?></td>
          </tr>
          <tr>
            <th scope="row">Address: </td>
            <td><?=cook_information('cook_address')?></td>
          </tr>
          <tr>
            <th scope="row">Salary: </th>
            <td><?=cook_information('cook_salary')?> Tk</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <!-- ===//end of cooks information === -->

<!-- === form start === -->
<div class="card">
    <div class="card-header text-center text-dark bg-white" >
      <h2> Update Informatioan </h2>
    </div>
    <div class="card-body">
    <?php if(isset($success_msg)) :?>
      <div class="alert alert-success mt-2"> <?=$success_msg;?> </div>
    <?php endif?>
      <form action="" method="POST">
        <div class="form-group">
          <label for="cook_name">Cook Name: </label>
          <input type="text" id="cook_name" class="form-control" name="cook_name" 
          <?php if(isset($cook_name)) :?>
            value="<?=$cook_name;?>" 
          <?php endif?>
          >
          <?php if(isset($name_err)) :?>
            <div class="alert alert-danger mt-2"> <?=$name_err;?> </div>
          <?php endif?>
        </div>
        <div class="form-group">
          <label for="cook_mobile">Cook Number: </label>
          <input type="text" id="cook_mobile" class="form-control" name="cook_mobile"
          <?php if(isset($cook_mobile)) :?>
            value="<?=$cook_mobile;?>" 
          <?php endif?>
          >
          <?php if(isset($number_err)) :?>
            <div class="alert alert-danger mt-2"> <?=$number_err;?> </div>
          <?php endif?>
        </div>
        <div class="form-group">
          <label for="cook_address">Cook Address: </label>
          <input type="text" id="cook_address" class="form-control" name="cook_address"
          <?php if(isset($cook_address)) :?>
            value="<?=$cook_address;?>" 
          <?php endif?>
          >
          <?php if(isset($cook_address_err)) :?>
            <div class="alert alert-danger mt-2"> <?=$cook_address_err;?> </div>
          <?php endif?>
        </div>
        <div class="form-group">
          <label for="cook_salary">Cook Salary: </label>
          <input type="text" id="cook_salary" class="form-control" name="cook_salary"
          <?php if(isset($cook_salary)) :?>
            value="<?=$cook_salary;?>" 
          <?php endif?>
          >
   
          <?php if(isset($cook_salary_err)) :?>
            <div class="alert alert-danger mt-2"> <?=$cook_salary_err;?> </div>
          <?php endif?>
        </div>
        <div class="form-group text-center">
         <input type="submit" value="update" class="btn btn-danger px-5" name="submit"></input>
        </div>
      </form>
    </div>
  </div>
<!-- ===// end of form === -->

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
