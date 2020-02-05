<?php
require_once('includes/auth.php');
require_once('includes/db.php');
require_once('includes/dashboard/header.php');
require_once('functions.php');

//Total members data
$show_consumption_query = "SELECT * FROM consumption WHERE delete_status = 1";
$datas = mysqli_query($db_connect, $show_consumption_query);

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
      <h2> Total Consumption </h2>
    </div>
    <div class="card-body">
    <table class="table table-sm table-striped table-responsive-xl table-bordered text-nowrap">
      <thead>
        <tr>
          <th>SL. NO</th>
          <th>ID. NO</th>
          <th>NAME</th>
          <th>TOTAL CONSUMPTION</th>
          <th>CONSUMPTION MESSAGE</th>
          <th>DATE</th>
          <th>ACTION</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $serial = 1;
      foreach($datas as $data):
      ?>
        <tr>
          <td><?=$serial++?></td>
          <td><?=$data['member_id']?></td>
          <td><?=$data['member_name']?></td>
          <td><?=$data['total_consumption']?></td>
          <td><?=$data['consumption_note']?></td>
          <td><?=$data['date']?></td>
          <td>
            <?php
              if($data['status'] == 1):
            ?>
              <a href="consumption_accept.php?id=<?=$data['id']?>" class="btn btn-sm btn-success">Accept</a>
              <a href="consumption_trash.php?id=<?=$data['id']?>" class="btn btn-sm btn-danger">Delete</a>
            <?php endif;?>
            <a href="consump_details.php?id=<?=$data['id']?>" class="btn btn-sm btn-warning">Details</a>
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
