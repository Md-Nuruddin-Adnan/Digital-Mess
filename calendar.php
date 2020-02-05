<?php
require_once('includes/auth.php');
require_once('includes/db.php');
require_once('includes/dashboard/header.php');
require_once('functions.php');

//Total members data
$show_consumption_query = "SELECT * FROM consumption WHERE delete_status = 1";
$datas = mysqli_query($db_connect, $show_consumption_query);

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


<link rel="stylesheet" href="calendar/css/fullcalendar.min.css">
<!-- <link rel="stylesheet" href="calendar/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="calendar/css/calendar.css">

<div class="content-wrapper">


<!-- === New content start === -->

  <!-- === ? section start === -->
      <div class="row">
        <div class="col-md-12">
          <h1 class="text-center">Calender</h1>
          <div id="calendar"></div>
        </div>
          <!-- BEGIN MODAL -->
          <div class="modal fade" id="event-modal" tabindex="-1">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header text-center border-bottom-0 d-block">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Add New Event</h4>
                  </div>
                  <div class="modal-body">

                  </div>
                  <div class="modal-footer border-0 pt-0">
                      <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-success save-event waves-effect waves-light">Create event</button>
                      <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Delete</button>
                  </div>
              </div>
          </div>
      </div>


          <!-- Modal Add Category -->
          <div class="modal fade" id="add-category" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center border-bottom-0 d-block">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title mt-2">Add a category</h4>
                    </div>
                    <div class="modal-body p-4">
                        <form role="form">
                            <div class="form-group">
                                <label class="control-label">Category Name</label>
                                <input class="form-control form-white" placeholder="Enter name" type="text" name="category-name"/>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Choose Category Color</label>
                                <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color">
                                    <option value="success">Success</option>
                                    <option value="danger">Danger</option>
                                    <option value="info">Info</option>
                                    <option value="pink">Pink</option>
                                    <option value="primary">Primary</option>
                                    <option value="warning">Warning</option>
                                    <option value="inverse">Inverse</option>
                                </select>
                            </div>

                        </form>

                        <div class="text-right">
                            <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-custom ml-1 waves-effect waves-light save-category" data-dismiss="modal">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MODAL -->
      </div>
  <!-- ===//end of ? section === -->
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


  <script src="calendar/js/jquery-3.4.1.min.js"></script>
  <script src="calendar/js/popper.js"></script>
  <script src="calendar/js/bootstrap.min.js"></script>
  <script src="calendar/js/jquery_ui_min.js"></script>
  <script src="calendar/js/moment.js"></script>
  <script src="calendar/js/fullcalendar.min.js"></script>
  <script src="calendar/js/calendar.js"></script>

<?php
require_once('includes/dashboard/footer.php');
?>
