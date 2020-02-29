<?php
require_once('includes/auth.php');
require_once('includes/db.php');
require_once('includes/dashboard/header.php');
require_once('functions.php');

//Total shoppers data
$show_shoppers_query = "SELECT * FROM shoppers ORDER BY shopping_date ASC";
$datas = mysqli_query($db_connect, $show_shoppers_query);

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
// require_once('includes/dashboard/right_sidebar_with_settings.php');
require_once('includes/dashboard/left_sidebar.php');
?>

<div class="content-wrapper">


<!-- === New content start === -->

<div class="card">
    <div class="card-header text-center text-dark bg-white" >
      <h2> New Shopper! </h2>
    </div>
    <div class="card-body">

    <div class="row">
      <div class="col-md-6 col-sm-12 m-auto">
        <div class="card">
        <form action="shopper_add.php" method="POST">
          <div class="form-group">
            <label for="shopper_name">Select a Shopper</label>
            <?php
            $member_select = "SELECT * FROM members WHERE delete_status = 1";
            $member_select_db = mysqli_query($db_connect, $member_select);
            ?>
            <select name="member_id" class="form-control" id="shopper_name" required>
              <option value="">Select a member</option>
              <?php foreach($member_select_db as $member_total_information): ?>
              <option value="<?=$member_total_information['id']?>"><?=$member_total_information['member_name']?></option>
              <?php endforeach;?>
            </select>
            </div>
            <div class="form-group">
              <label for="shopping_date">Select Date</label>
              <input name="shopping_date" type="date" class="form-control" id="datepicker"  required>
            </div>
            <div class="form-group text-center mb-5">
            <button type="submit" class="btn btn-sm btn-success">Add Shopper</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <h2 class="text-center text-dark mb-3"> Shopper list </h2>
        <table class="table table-sm table-striped table-responsive-xl table-bordered text-nowrap">
          <thead>
            <tr>
              <th>SL. NO</th>
              <th>ID. NO</th>
              <th>NAME</th>
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
              <td><?=$data['shopper_name']?></td>
              <td><?=$data['shopping_date']?></td>
              <td>
                <a href="consump_details.php?id=<?=$data['id']?>" class="btn btn-sm btn-warning">Edit</a>
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
