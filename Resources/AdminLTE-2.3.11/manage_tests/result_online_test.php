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
              <h3 class="box-title">Result</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Sr No.</th>
                  <th>Test Name</th>
                  <th>Date Of Test</th>
                  <th>Total Marks</th>
                  <th>Marks Obtained</th>
                  <th>PASS/FAIL</th>
                  <th>View Result</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>1</td>
                  <td>ABC</td>
                  <td>27th May,2017</td>
                  <td>50</td>
                  <td>47</td>
                  <td class="text-success"><b>PASS</b><i class="fa fa-check text-success"></i></td>
                  <td><a href="#"><i class="fa fa-eye" style="color: #696969"></i></a></td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>XYZ</td>
                  <td>27th May,2017</td>
                  <td>100</td>
                  <td>25</td>
                  <td class="text-red"><b>FAIL</b><i class="fa fa-remove text-red "></i></td>
                  <td><a href="#"><i class="fa fa-eye" style="color: #696969"></i></a></td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>PQR</td>
                  <td>27th May,2017</td>
                  <td>80</td>
                  <td>75</td>
                  <td class="text-success"><b>PASS</b><i class="fa fa-check text-success"></i></td>
                  
                  <td><a href="#"><i class="fa fa-eye" style="color: #696969"></i></a></td>
                </tr>
                
                </tbody>
                <tfoot>
                <tr>
                  <tr>
                  <th>Sr No.</th>
                  <th>Test Name</th>
                  <th>Date Of Test</th>
                  <th>Total Marks</th>
                  <th>Marks Obtained</th>
                  <th>PASS/FAIL</th>
                  <th>View Result</th>
                </tr>
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
