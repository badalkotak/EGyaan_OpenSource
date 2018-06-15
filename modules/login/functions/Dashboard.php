<html>
<body>
    <?php
    error_reporting(0);
    include("../../../Resources/sessions.php");
    include("../../../Resources/Dashboard/header.php");
    ?>
    <div class="content-wrapper">
        
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Dashboard</h3>
          </div>
          <div class="box-body">
          <div class="row">
          <?php
          $i=0;
            include("../../../Resources/sessions.php");
// include("../../../Resources/no_javascript_message.php");

// require_once("../../../classes/DBConnect.php");
// require_once("../../../classes/Constants.php");
// require_once("../../manage_privilege/classes/Privilege.php");

// $dbConnect = new DBConnect(Constants::SERVER_NAME,
//     Constants::DB_USERNAME,
//     Constants::DB_PASSWORD,
//     Constants::DB_NAME);

// print("Role id:".$role_id);

$privilege=new Privilege($dbConnect->getInstance());

$getDashboard=$privilege->getDashboardPrivilege($role_id);

if($getDashboard!=null)
{
    while($row=$getDashboard->fetch_assoc())
    {
    	// var_dump($row);
        $i++;
        $privilege_folder=$row['folder'];
        $dashboard_name=$row['dashboard_name'];
        if($dashboard_name=="Result")
        {
          $i--;
          continue;
        }
        // <!-- echo "<a href=../../$privilege_folder><img src=../../$privilege_folder/icon.png></img><br>$dashboard_name<br></a>"; -->
        echo "<div class='col-md-3 col-sm-6 col-xs-6'>
              <center><a href='../../$privilege_folder'><image src='../../$privilege_folder/icon.png' height=100 width=88><br><h4>$dashboard_name</h4>
          </a></center>
            </div>";

            if($i==4)
            {
                $i=0;
                echo "</div><hr><div class='row'>";
            }
    }
}
            
          ?>

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
    <style>
a:link {
    color: black;
}

a:visited {
    color: black;
}


/* mouse over link */
a:hover {
    color: #f39c12;
}
</style>
</html>