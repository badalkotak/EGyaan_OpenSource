<!DOCTYPE html>
<html>
<?php
include("header.php");
?>
<body>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Hello!
        <small>Indresh Jotangia</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Test</a></li>
        <li class="active">Online Test</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Test Name: <b>ABC</b></h3>
              <h3 class="box-title pull-right">Marks:<b> 100</b></h3><br>
            <h3 class="box-title">Date: <b>28th May,2017</b></h3>
            </div>
            
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
                <div class="form-group">
                  <label>Question 1:</label><br>
                  <input type="radio" name="ans1" checked="true">Answer 1
                  <input type="radio" name="ans1">Answer 2
                  <input type="radio" name="ans1">Answer 3
                  <input type="radio" name="ans1">Answer 4
                </div>
                <div class="form-group">
                  <label>Question 2:</label><br>
                  <input type="radio" name="ans2">Answer 1
                  <input type="radio" name="ans2">Answer 2
                  <input type="radio" name="ans2">Answer 3
                  <input type="radio" name="ans2">Answer 4
                </div>
                <div class="form-group">
                  <label>Question 3:</label><br>
                  <input type="radio" name="ans3">Answer 1
                  <input type="radio" name="ans3">Answer 2
                  <input type="radio" name="ans3">Answer 3
                  <input type="radio" name="ans3">Answer 4
                </div>
                   </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <center><button type="submit" class="btn btn-success"><i class="fa fa-check"></i>Submit</button></center>
              </div>
            </form>
          </div>
          <!-- /.box -->
          </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
  include("footer.php");

  ?>
</body>
</html>
