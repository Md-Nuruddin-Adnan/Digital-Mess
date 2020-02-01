<?php
session_start();
require_once('includes/db.php');
require_once('includes/dashboard/header.php');
require_once('functions.php');

if(isset($_POST['submit'])){
  $user_email = check_data($_POST['user_email']);
  $user_email  = mysqli_real_escape_string($db_connect, $user_email );

  $user_password = check_data($_POST['user_password']);
  $user_password = mysqli_real_escape_string($db_connect, $user_password);
  
  $login_query = "SELECT * FROM users WHERE user_email = '$user_email' AND user_password = '$user_password'";
  $login_to_db = mysqli_query($db_connect, $login_query);

  if($login_to_db->num_rows == 1){
    $_SESSION['login_success'] = "login succesfull";

    $data_to_array = mysqli_fetch_assoc($login_to_db);
  
    $_SESSION['user_name'] = $data_to_array['user_name'];
  
    header('location: dashboard.php');
  }
  else {
    $login_error = "User name or password is wrong";
  }
}



?>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
      <div class="row">
        <div class="content-wrapper full-page-wrapper d-flex align-items-center auth">
          <div class="row w-100">
            <div class="col-lg-8 mx-auto">
              <div class="row">
                <div class="col-lg-6 bg-white">
                  <div class="auth-form-light text-left p-5">
                    <h2>Login</h2>
                    <h4 class="font-weight-light">Hello! let's get started</h4>
                    <form class="pt-5" action="" method="POST">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Email</label>
                          <input name="user_email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email address">
                          <i class="mdi mdi-email"></i>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1">Password</label>
                          <input name="user_password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                          <i class="mdi mdi-eye"></i>
                        </div>
                        <?php if(isset($login_error)):?>
                          <div class="alert alert-danger"><?=$login_error?></div>
                        <?php endif?>
                        <div class="mt-5">
                          <input type="submit" name="submit" value="Login" class="btn btn-block btn-success btn-lg font-weight-medium">
                        </div>
                        <div class="mt-3 text-center">
                          <a href="#" class="auth-link text-black">Forgot password?</a>
                        </div>                  
                    </form>
                  </div>
                </div>
                <div class="col-lg-6 login-half-bg d-flex flex-row">
                  <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; 2018  All rights reserved.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- row ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
<?php
require_once('includes/dashboard/footer.php');
?>