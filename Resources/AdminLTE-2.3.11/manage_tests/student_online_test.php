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
            <div class="box-header">
              <h3 class="box-title">Online Tests</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Sr No.</th>
                  <th>Test Name</th>
                  <th>Marks</th>
                  <th>Last Date</th>
                  <th>Give Test</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>1</td>
                  <td>ABC</td>
                  <td>50</td>
                  <td>28th May,2017</td>
                  <td><button class="btn btn-sm btn-success">Give Test</button></td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>XYZ</td>
                  <td>100</td>
                  <td>27th May,2017</td>
                  <td>Submitted<i class="fa fa-check text-success"></i></td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>PQR</td>
                  <td>80</td>
                  <td>27th May,2017</td>
                  <td><button class="btn btn-sm btn-success">Give Test</button></td>
                </tr>
                
                </tbody>
                <tfoot>
                <tr>
                  <th>Sr No.</th>
                  <th>Test Name</th>
                  <th>Marks</th>
                  <th>Last Date</th>
                  <th>Give Test</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
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
