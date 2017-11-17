<html>
<body>
    <?php
    error_reporting(0);
    include("../../../Resources/sessions.php");
    include("../../../Resources/Dashboard/header.php");
    ?>
    
    <!--START OF SIDEBAR===========================================================================================================-->
    <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <?
                        if($profile!=null)
                            		{
                            			echo "<img src='../../manage_student/images/student/$profile' class=img-circle alt='User Image'>";
                            		}
                           			else
                            		{
                            			echo "<img src='../../../Resources/images/boy.png' class=img-circle alt='User Image'>";
                            		}
                        ?>
                    </div>
                    <div class="pull-left info">
                    <?
                    echo "<p>$display_name</p>";
                    ?>
                        <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
                    </div>
                </div>
                        <!-- search form -->
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
                <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="treeview active">
                        <a href="../../login/functions/Dashboard.php">
                            <i class="fa fa-home"></i> <span>Home</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-gears"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>
    
<!--END OF SIDEBAR=============================================================================================================-->
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

require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../../manage_privilege/classes/Privilege.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$privilege=new Privilege($dbConnect->getInstance());

$getDashboard=$privilege->getDashboardPrivilege($role_id);

if($getDashboard!=null)
{
    while($row=$getDashboard->fetch_assoc())
    {
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