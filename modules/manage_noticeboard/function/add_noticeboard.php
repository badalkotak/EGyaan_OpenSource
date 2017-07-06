<!DOCTYPE html>
<html>
<?php
include("../../../Resources/sessions.php");
include("../../../Resources/Dashboard/header.php");
    
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
?>

<script type="text/javascript" src="../../../Resources/jquery.min.js">
</script>
<script type="text/javascript" src="get_branch.js">
</script>
<script type="text/javascript" src="add_noticeboard.js">
</script>
    
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
                    <li class="treeview">
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
<!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Hello!<small>User</small></h1>
            <ol class="breadcrumb">
                <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                <li class="active"><b>Add Noticeboard</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Noticeboard:</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="insert_get_noticeboard.php" method="post" enctype="multipart/form-data" id=add_notice>
                                <?php
                                if($role_id==Constants::ROLE_ADMIN_ID)
                                {
                                    $dbConnect = new DBConnect(Constants::SERVER_NAME,
                                                               Constants::DB_USERNAME,
                                                               Constants::DB_PASSWORD,
                                                               Constants::DB_NAME);

                                    if(isset($_REQUEST['type']) && $_REQUEST['type']=="b")
                                    {
                                        require_once("../../manage_branch/classes/Branch.php");
                                        $branch = new Branch($dbConnect->getInstance());
                                        $selectData = $branch->getBranch(0);

                                        $type=$_REQUEST['type'];
                                        if(isset($_REQUEST['title']))
                                        {
                                            $title=$_REQUEST['title'];
                                        }
                                        else
                                        {
                                            $title="";
                                        }
                                        if(isset($_REQUEST['notice']))
                                        {
                                            $notice=$_REQUEST['notice'];
                                        }
                                        else
                                        {
                                            $notice="";
                                        }

                                        echo'<div class="form-group"><input type=text class="form-control" name=title id=title placeholder="Enter Title" value='.$title.'></div>
                                        
                                        <div class="form-group"><textarea name="notice" class="form-control" style="resize: vertical;"  id="notice" placeholder="Enter Notice" >'.$notice.'</textarea></div> 
                                        
                                        <div class="form-group"><input type=file name=file id=file ></div>
                                        
                                        <div class="form-group">
                                            <label>Type Of Notice :</label>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <label><input type="radio" name="type" id="type" value="b" checked>&nbsp;Branch</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label><input type="radio" name="type" id="type" value="c">&nbsp;Common</label>
                                            </div>
                                        </div>
                                        
                                        <div id=branch class="form-group clearfix">';
                                        if($selectData)
                                        {
                                            while ($row = $selectData->fetch_assoc()) 
                                            {
                                                $id=$row['id'];
                                                $name=$row['name'];
                                                echo'<label><input type=checkbox name=select_branch[] id=select_branch[] value=' .$id. '>'.$name.'</label>';
                                            }
                                        }
                                        echo'</div>';
                                        if($_REQUEST['u']=="u")
                                        {
                                            echo'<div class="form-group">
                                                    <label>
                                                        <input type="checkbox" name="u" id="u" value="u" checked>&nbsp;Urgent 
                                                    </label>
                                                </div>';
                                        }
                                        else
                                        {
                                            echo'<div class="form-group">
                                                    <label>
                                                        <input type="checkbox" name="u" id="u" value="u">&nbsp;Urgent
                                                    </label>
                                                </div>';
                                        }
                                        echo '<div class="form-group"><button type=submit class="btn btn-success"  id=add_notice_submit><span class="fa fa-check"></span>&nbsp;Submit</button></div>';
                                    }
                                    else
                                    {
                                ?>

                                <div class="form-group">
                                    <input type="text" name="title" id="title"  class="form-control" placeholder="Enter Title" />
                                </div>
                                
                                <div class="form-group">
                                    <textarea name="notice" class="form-control" placeholder="Enter Notice" style="resize: vertical;" id="notice"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <input type="file" name="file" id="file" />
                                </div>
                                
                                <div class="form-group">
                                    <label>Type Of Notice :</label>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label><input type="radio" name="type" value=b />&nbsp;Branch</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label><input type="radio" name="type"  value=c  />&nbsp;Common</label>
                                    </div>
                                </div>
                                
                                <div id=branch class="form-group clearfix">
                                </div>
                                
                                <div class="form-group">
                                    <label><input type="checkbox" name="u" id="u" value="u"  />&nbsp;Urgent</label>
                                </div>
                                
                                <div class="form-group">
                                    <button type=submit class="btn btn-success" id=add_notice_submit> <span class="fa fa-check"></span>&nbsp;Submit</button>
                                </div>
                                
                                <div id=errormessage class="form-group">
                                </div>

                                <?php
                                    }
                                }
                                else
                                {
                                    echo Constants::NO_USER_ERR;
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php
    include("../../../Resources/Dashboard/footer.php");
    ?>
    </body>
</html>
