<?php
require_once('includes/auth.php');
require_once('includes/db.php');
require_once('includes/dashboard/header.php');
require_once('functions.php');

//Total members data
$show_query = "SELECT * FROM members WHERE delete_status = 1";
$datas = mysqli_query($db_connect, $show_query);


?>
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

<style>
.table-sm th {
  padding: 1rem;
}

.table .no_entry {
  padding: 1rem;
  font-size: 2rem;
}
</style>
       
<div class="content-wrapper">
  <div class="row">
    <div class="col-md-6 col-lg-3 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-md-center">
            <i class="mdi mdi-basket icon-lg text-success"></i>
            <div class="ml-3">
              <p class="mb-0">Total Deposit</p>
              <h6>
                <?php 
                  if(total_deposit() <= 0){
                  echo '0.00';
                  }
                  else { echo total_deposit();}
                ?>
                TK
              </h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-md-center">
            <i class="mdi mdi-rocket icon-lg text-warning"></i>
            <div class="ml-3">
              <p class="mb-0">Total Consumption</p>
              <h6>
                <?php 
                  if(total_consumption() <= 0){
                  echo '0.00';
                  }
                  else { echo total_consumption();}
                ?>
                TK
              </h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-md-center">
            <i class="mdi mdi-diamond icon-lg text-info"></i>
            <div class="ml-3">
              <p class="mb-0">Meal Rate</p>
              <h6>
                <?php 
                  if(number_format(meal_rate(), 3) <= 0){
                  echo '0.00';
                  }
                  else { echo number_format(meal_rate(), 3);}
                ?>
                TK
              </h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-md-center">
            <i class="mdi mdi-chart-line-stacked icon-lg text-danger"></i>
            <div class="ml-3">
              <p class="mb-0">Balance</p>
              <h6>
                <?php 
                  if((total_deposit()-total_consumption()) <= 0){
                  echo '0.00';
                  }
                  else { echo total_deposit()-total_consumption();}
                ?>
                TK
              </h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- === This section is for calculation purpose ==== -->
  <ul class="d-none">
    <?php foreach($datas as $member_datas): ?>
    <li>
      <?php
       $id = $member_datas['id'];
       final_calculation($id);
       ?>
    </li>
    <?php endforeach;?>
  </ul><!--//calculation -->

<!-- === New content start === -->

  <div class="card">
    <div class="card-header text-center text-dark bg-white" >
      <h2> Summury of The Mess </h2>
    </div>
    <div class="card-body">
    <table class="table table-sm table-striped table-responsive-xl table-bordered text-nowrap">
      <thead>
        <tr>
          <th>SL. NO</th>
          <th>ID. NO</th>
          <th>NAME</th>
          <th>DEPOSIT</th>
          <th>TOTAL MEAL</th>
          <th>MEAL RATE</th>
          <th>BILL</th>
          <th>COOK BILL</th>
          <th>TOTAL BILL</th>
          <th>BALANCE</th>
          <th>ACTION</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $serial = 1;
      foreach($datas as $data):
      ?>
        <tr class="
          <?php if($data['deposit'] < $data['total_bill'] ): ?>
          bg-danger text-white
          <?php endif;?>
        ">
          <td width="3%"><?=$serial++?></td>
          <td width="7%"><?=$id=$data['id']?></td>
          <td><?=$data['member_name']?></td>
          <td><?=$data['deposit']?></td>
          <td><?=$data['total_meal']?></td>
          <td><?=number_format($data['meal_rate'], 2);?></td>
          <td><?=number_format($data['bill'], 2);?></td>
          <td><?=number_format($data['cooker_bill'], 2);?></td>
          <td><?=number_format($data['total_bill'], 2);?></td>
          <td><?=number_format($data['balance'], 2);?></td>
          <td>
            <!-- <a href="#" class="btn btn-sm btn-danger">Edit</a> -->
            <a href="member_edit.php?id=<?=$id=$data['id']?>" class="
              <?php if($data['deposit'] < $data['total_bill'] ): ?>
                btn btn-sm btn-danger shadow
                <?php endif;?>
              <?php if($data['deposit'] > $data['total_bill'] ): ?>
                btn btn-sm btn-danger 
              <?php endif;?>
            ">
              Edit
            </a>
          </td>
        </tr>
      <?php
        endforeach;
        if($datas->num_rows == 0):;
      ?>
        <tr>
          <td colspan="50" class="text-danger no_entry text-center">No entry found</td>
        </tr>
      <?php endif;?>
      </tbody>
    </table>
  </div>
  </div>
        <!-- ===// end of new content === -->
          
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © <?php echo date("d/m/y"); ?> <a href="index.php">Digital Mess</a>. All rights reserved.</span>
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


<style>
/* === responsive css === */
@media (max-width: 1400px){
.table-responsive-xl {
  display: block;
  width: 100%;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}

}
</style>
