<html>
<body>
  <?php
  include("../../../Resources/Dashboard/header.php");
  ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Hello!
        <small>Indresh Jotangia</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Branch List</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Branches</h3>
            </div>
            <div class="box-body">
                <form action="insert_branch.php" method="post">
                  <div class="col-md-6">
                    <input type="text" class="form-control" name="branch_name" placeholder="Enter Branch Name"></div>
                    
                    <button type="submit" class="btn btn-success" value="Submit"><i class="fa fa-check"></i>Submit</button>
                  </form>

                  <?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 4/6/17
 * Time: 5:16 PM
 */
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Branch.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
  Constants::DB_USERNAME,
  Constants::DB_PASSWORD,
  Constants::DB_NAME);

echo "<br>List of Department - Branches<br>";
$branch = new Branch($dbConnect->getInstance());
$result = $branch->getBranch(0);

if ($result != null) {
  $i = 0;
  echo '<div class="table-container1">';
  echo "<table class='table table-bordered table-hover example2'>";
  echo "<thead><tr><th>Sr No.</th><th>Name</th><th>Edit</th><th>Delete</th></tr></thead>";
  echo "<tbody>";
  while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $name = htmlentities($row['name'], ENT_QUOTES);
        // echo "<tr><td>" . $name . "</td><td><form action='editBranch.php' method='post'>
        // <input type='hidden' value='" . $id . "' name='branchId'><input type='hidden' value='" . $name . "' name='branchName'>
        // <input type='submit' value='Edit'></form></td><td><form action='delete_branch.php' method='post'>
        // <input type='hidden' value='" . $id . "' name='branchId'><input type='hidden' value='" . $name . "' name='branchName'>
        // <input type='submit' value='Delete'></form></td></tr>";

    echo "<tr>";
    $i++;
    echo "<td>";
    echo $i;
    echo "</td>";

    echo "<td>";
    echo $name;
    echo "</td>";

    echo "<td>";
    echo "<form action='editBranch.php' method='post'><input type='hidden' value='$id' name='edit'>
    <button type='submit' class='btn btn-primary' value='Edit'><i class='fa fa-pencil'></i>Edit</button></form>";
    echo "</td>";

    echo "<td>";
    echo "<form action='delete_branch.php' method='post'><input type='hidden' value='$id' name='delete'>
    <button type='submit' class='btn btn-danger' value='Delete'>Delete<i class='fa fa-trash'></i></button></form>";
    echo "</td>";
  }
  echo "</tbody>";
  echo "</table>";
  echo "</div>";
} else {
  echo "No Records Found";
}
?>
<!-- </div> -->
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</section>
</div>
<?php
include("../../../Resources/Dashboard/footer.php");

?>
</body>
</html>