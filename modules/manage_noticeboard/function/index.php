<!DOCTYPE html>
<html>
<?php
include("../../../Resources/sessions.php");
include("../../../Resources/Dashboard/header.php");
    
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Noticeboard.php");
require_once("../../manage_branch/classes/Branch.php");
require_once("../../manage_course/classes/Course.php");
    
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$user_id=$id;
// $email="badalkotak@gmail.com";
//$role_id=7;
//student

//select branch_id from egn_batch where id in (select batch_id from egn_student where email="badalkotak@gmail.com")
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
                    <li class="treeview">
                        <a href="../../login/functions/Dashboard.php">
                            <i class="fa fa-home"></i> <span>Home</span>
                        </a>
                    </li>
                    <?php
                    if($role_id==Constants::ROLE_ADMIN_ID)
                    {
                        echo '<li class="treeview">
                        <a href="../../manage_branch/function/branch.php">
                            <i class="fa  fa-sitemap"></i> <span>Manage Branch</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_batch/function/batch.php">
                            <i class="fa fa-users"></i> <span>Manage Batch</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_course/function/course.php">
                            <i class="fa fa-book"></i> <span>Manage Course</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_user/functions/user.php">
                            <i class="fa fa-user"></i> <span>Manage Users</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_student/function/student.php">
                            <i class="fa fa-graduation-cap"></i> <span>Manage Students</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_role/functions/role.php">
                            <i class="fa fa-user"></i> <span>Manage Role</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_fees/function/manage_fees.php">
                            <i class="fa fa-file-text-o"></i> <span>Manage Fees</span>
                        </a>
                    </li>
                    <li class="treeview active">
                        <a href="../../manage_noticeboard/function/index.php">
                            <i class="fa fa-calendar-minus-o"></i> <span>Noticeboard</span>
                        </a>
                    </li>';
                    }else if($role_id==Constants::ROLE_TEACHER_ID){
                        echo'<li class="treeview">
                        <a href="../../manage_notes/function/insert_page.php">
                            <i class="fa fa-book"></i> <span>Notes</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="">
                            <i class="fa fa-send-o"></i> <span>Submissions</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_test/function/manage_test.php">
                            <i class="fa fa-pencil-square-o"></i> <span>Tests</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_timetable/function/view_teacher_timetable.php">
                            <i class="fa fa-calendar"></i> <span>Timetable</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_syllabus/function/insert_page.php">
                            <i class="fa fa-book"></i> <span>Syllabus</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_attendance/functions/attendanceMarking.php">
                            <i class="fa fa-bar-chart"></i> <span>Attendance</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../discussion_forum/functions/forum.php">
                            <i class="fa fa-wechat"></i> <span>Discussion Forum</span>
                        </a>
                    </li>
                    <li class="treeview active">
                        <a href="../../manage_noticeboard/index.php">
                            <i class="fa  fa-calendar-minus-o"></i> <span>Noticeboard</span>
                        </a>
                    </li>';
                    }else if($role_id==Constants::ROLE_STUDENT_ID){
                        echo'';
                    }
                    ?>
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
            <br>
            <ol class="breadcrumb">
                <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                <li class="active"><b>Noticeboard</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <h2 class="page-header">Notice</h2>
<!--------------------------------------------------------------------------------------------------------------------------->
            <?php
            if($role_id==Constants::ROLE_STUDENT_ID)
            {
                $noticeboard = new Noticeboard($dbConnect->getInstance());
                $selectData=$noticeboard->getNested2("egn_batch","egn_student","branch_id",1,1,1,1,"id","batch_id",1,1,"email",$email);
                if($selectData!=null)
                {
            ?>
<!--------------------------------------------------------------------------------------------------------------------------->
            <div class="row"><!--start of row1-->
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Branch Student</h3>
                        </div>
                        <div class="box-body">
                            <div class="box-group" id="accordion">
<!--------------------------------------------------------------------------------------------------------------------------->
                    <?php
                    while($row=$selectData->fetch_assoc())
                    {
                        $student_branch=$row['branch_id'];
                        $var1="type";
                        $var2=1;
                        $var3=1;
                        $urgent=1;
                        $id=1;
                        $selData=$noticeboard->getNoticeboard($var1,$student_branch,$var2,$urgent,$var3,$id);
                        if($selData!=null)
                        {
                            while($row=$selData->fetch_assoc())
                            {
                                $title=$row['title'];
                                $notice=$row['notice'];
                                $id=$row['id'];
                                $file=$row['file'];
                                $urgent=$row['urgent_notice'];
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->
                                <div class="panel box box-primary">
                                    <div class="box-header with-border">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>Title :
<!--------------------------------------------------------------------------------------------------------------------------->         
                                <?php
                                echo $title;
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->
                                                </h4>
                                            </div>    
<!--------------------------------------------------------------------------------------------------------------------------->           
                                <?php
                                //echo '<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id>read more..</button> </a>';
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->
                                            <div class="col-md-6">
<!--------------------------------------------------------------------------------------------------------------------------->   
                                <?php
                                echo "<a data-toggle='collapse' data-parent='#accordion' href='#notice".$id."'><button type='button' class='btn btn-default btn-sm'>Read More <span class='fa fa-ellipsis-h'></span></button></a>&nbsp;";
                                if($file!=null)
                                {
                                    echo "<a href=".$file." class='btn btn-default btn-sm'>
                                    <i class='fa fa-paperclip'></i> Attached Notice</a>&nbsp;";
                                }
                                if($urgent=="u")
                                {
                                    echo '<h4 class="alert-message"><i class="icon fa fa-exclamation-triangle"></i><b>Urgent Notice</b></h4>';
                                }
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->           
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="notice<?php echo $id ?>" class="panel-collapse collapse out">
                                                <div class="box-body">
<!--------------------------------------------------------------------------------------------------------------------------->           
                                    <?php
                                    echo'<h4>Description :</h4><p class="text-justify">'.$notice.'</p>';
                                    ?>
<!--------------------------------------------------------------------------------------------------------------------------->           
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<!--------------------------------------------------------------------------------------------------------------------------->           
                            <?php
                            }	
                        }
                        else
                        {
							echo '<h5>No Branch Notice!</h5>';
                        }	  
                    }
                    ?>
<!--------------------------------------------------------------------------------------------------------------------------->           
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end of row1-->
<!--000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000-->
            <?php
                }
                else
                {
                    $student_branch="";
				}
			}
			else if($role_id==Constants::ROLE_TEACHER_ID)
            {
                //select branch_id from egn_batch where id in (select batch_id from egn_course WHERE id in (select course_id from egn_teacher_course where user_id=3))
                //$sql="Select * from $table1 where $var1=$value1 and $var2=$value2 and  $var3 in ( select $value3 from $table 2 where $var4=$value4 and $var5=$value5 and $var6 in (select $value6 from $table3 where $var7=$value7 and $var8=$value8 ))"
                $course = new Course($dbConnect->getInstance());
                $branchData=$course->getCourse("yes", $user_id, 'no',0, 0,null,0);
				if($branchData!=null)
				{
            ?>
<!--------------------------------------------------------------------------------------------------------------------------->			
            <h2 class="page-header">Teacher Branch</h2>
<!--------------------------------------------------------------------------------------------------------------------------->
                    <?php
                    while($row=$branchData->fetch_assoc())
					{
						$teacher_branch=$row['branchId'];
						$teacher_branch_name=$row['branchName'];
                        ?>
<!--------------------------------------------------------------------------------------------------------------------------->            
            <div class="row"><!--start of row4-->
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
<!--------------------------------------------------------------------------------------------------------------------------->                                                      <?php
								echo"<h3 class='box-title'>".$teacher_branch_name."</h3>";
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->                     
                        </div>
                        <div class="box-body">
                            <div class="box-group" id="accordion">
<!--------------------------------------------------------------------------------------------------------------------------->                                             <?php
						$var1="type";
						$var2=1;
						$var3=1;
						$urgent=1;
						$id=1;
						$noticeboard = new Noticeboard($dbConnect->getInstance());
						$selectData=$noticeboard->getNoticeboard($var1,$teacher_branch,$var2,$urgent,$var3,$id);
						if($selectData)
						{
							while($row=$selectData->fetch_assoc())
							{
								$title=$row['title'];
								$notice=$row['notice'];
								$id=$row['id'];
								$file=$row['file'];
								$urgent=$row['urgent_notice'];
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->           
                                    <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Title :
<!--------------------------------------------------------------------------------------------------------------------------->           
                                <?php
                                echo $title.$id;
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->			
                                                    </h4>
                                                </div>
                                                <div class="col-md-6">
<!--------------------------------------------------------------------------------------------------------------------------->		
                            <?php
                                //echo '<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id >read     more..</button> </a>';
                                echo "<a data-toggle='collapse' data-parent='#accordion' href='#notice".$id."'><button type='button' class='btn btn-default btn-box-tool' data-widget='collapse'>Read 
                                more <span class='fa fa-ellipsis-h'></span>
                                </button></a>&nbsp;";
                                if($file!=null)
                                {
                                    echo "<a href=".$file." class='btn btn-default btn-box-tool'>
                                    <i class='fa fa-paperclip'></i> Attached Notice</a>";
                                }
                                if($urgent=="u")
                                {
                                    echo '<h4 class="alert-message pull-right"><i class="icon fa fa-exclamation-triangle"></i><b>Urgent Notice</b></h4>';
                                }
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->                     
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="notice<?php echo $id ?>" class="panel-collapse collapse out">
                                                <div class="box-body">
<!--------------------------------------------------------------------------------------------------------------------------->                                                     <?php
                                echo'<h4>Description :</h4><p class="text-justify">'.$notice.'</p>';
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->                     
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<!--------------------------------------------------------------------------------------------------------------------------->                                                  <?php
                            }  
                        }
								else
                                {
									echo "<h5>No Branch Notice!</h5>";
								}
                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end of row3-->
<!--------------------------------------------------------------------------------------------------------------------------->                                                  <?php
							}
						}
						else{
							$teacher_branch="";
						}
					}
					else if($role_id==Constants::ROLE_ADMIN_ID)
                    {
						$branch = new Branch($dbConnect->getInstance());
						$branchData=$branch->getBranch(0);
						if($branchData!=null)
						{
            ?>
<!--000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000-->					
            <h2 class="page-header">Admin Branch</h2>
<!--------------------------------------------------------------------------------------------------------------------------->
            <?php
							while($row=$branchData->fetch_assoc())
							{	
								$teacher_branch=$row['id'];
								$teacher_branch_name=$row['name'];
                                ?>
<!---------------------------------------------------------------------------------------------------------------------------> 
            <div class="row"><!--start of row4-->
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                                <?php
								echo"<h3 class='box-title'>".$teacher_branch_name."</h3>";
                                ?>
                        </div>
                        <div class="box-body">
                            <div class="box-group" id="accordion">
<!--------------------------------------------------------------------------------------------------------------------------->                                <?php
								$var1="type";
								$var2=1;
								$var3=1;
								$urgent=1;
								$id=1;
								$noticeboard = new Noticeboard($dbConnect->getInstance());
								$selectData=$noticeboard->getNoticeboard($var1,$teacher_branch,$var2,$urgent,$var3,$id);
								if($selectData)
								{
									while($row=$selectData->fetch_assoc())
									{
										$title=$row['title'];
										$notice=$row['notice'];
										$id=$row['id'];
										$file=$row['file'];
										$urgent=$row['urgent_notice'];
			?>
<!--------------------------------------------------------------------------------------------------------------------------->
                                <div class="panel box box-primary">
                                    <div class="box-header with-border">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>Title :
<!--------------------------------------------------------------------------------------------------------------------------->			<?php
												echo $title;
			?>
<!--------------------------------------------------------------------------------------------------------------------------->					
                                                </h4>
                                            </div>
                                            <div class="col-md-6">
<!--------------------------------------------------------------------------------------------------------------------------->			<?php
//												echo'
//												<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id                                                    >read more..</button> </a>';
                                        
                                                echo "<a data-toggle='collapse' data-parent='#accordion' href='#notice".$id."'><button type='button' class='btn btn-default btn-box-tool' data-widget='collapse'>Read More <span class='fa fa-ellipsis-h'></span></button></a>&nbsp;";
												echo'<a href="delete_noticeboard.php?delete='.$id.'" onclick=del_confirm()><button type=button name=delete id=delete  class="btn btn-default btn-box-tool btn-sm"><span class="fa fa-trash"></span>Delete</button></a>&nbsp;';
												if($file!=null)
												{
													echo "<a href=".$file." class='btn btn-default btn-box-tool'>
                                                    <i class='fa fa-paperclip'></i> Attached Notice</a>";
												}
												if($urgent=="u"){
													echo '<h4 class="alert-message pull-right"><i class="icon fa fa-exclamation-triangle"></i><b>Urgent Notice</b></h4>';
												}
                                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->                     
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="notice<?php echo $id ?>" class="panel-collapse collapse out">
                                                <div class="box-body">
<!--------------------------------------------------------------------------------------------------------------------------->                                                                  <?php
                                            echo'<h4>Description :</h4><p class="text-justify">'.$notice.'</p>';
                                            ?>
<!--------------------------------------------------------------------------------------------------------------------------->                     
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<!--------------------------------------------------------------------------------------------------------------------------->                                            <?php
                                            }	
										}
										else{
											echo "<h5>No Branch Notice!</h5>";
										}
                                        ?>
<!--------------------------------------------------------------------------------------------------------------------------->
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end of row4-->
<!--------------------------------------------------------------------------------------------------------------------------->                                    <?php
									}
								}
								else{
									$teacher_branch="";
								}
							}
			?>
<!--000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000-->	
                            <div class="row"><!--start of row5-->
                                <div class="col-md-12">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Common Notice</h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="box-group" id="accordion">
                        	<?php
							$var1="type";
							$var2=1;
							$var3=1;
							$type="c";
							$urgent=1;
							$id=1;
                                                
							$noticeboard = new Noticeboard($dbConnect->getInstance());
							$selectData=$noticeboard->getNoticeboard($var1,$type,$var2,$urgent,$var3,$id);
							if($selectData)
                            {
								while($row=$selectData->fetch_assoc())
								{
									$title=$row['title'];
									$notice=$row['notice'];
									$id=$row['id'];
									$file=$row['file'];
									$urgent=$row['urgent_notice'];
			?>
<!--------------------------------------------------------------------------------------------------------------------------->   
                                                <div class="panel box box-primary">
                                                    <div class="box-header with-border">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h4>Title :
<!--------------------------------------------------------------------------------------------------------------------------->			<?php
											echo $title;
			?>
<!---------------------------------------------------------------------------------------------------------------------------> 
                                                                </h4>
                                                            </div>
                                                            <div class="col-md-6">
<!--------------------------------------------------------------------------------------------------------------------------->			<?php
//											echo'
//											<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id                                                             >read more..</button> </a>';
                                            echo "<a data-toggle='collapse' data-parent='#accordion' href='#notice".$id."'><button type='button' class='btn btn-default btn-box-tool' data-widget='collapse'>Read More <span class='fa fa-ellipsis-h'></span>
                                            </button></a>&nbsp;";
											if($role_id==Constants::ROLE_ADMIN_ID){
												echo'<a href="delete_noticeboard.php?delete='.$id.'" onclick=del_confirm()><button type=button name=delete id=delete class="btn btn-default btn-box-tool btn-sm"><span class="fa fa-trash"></span> Delete</button> </a>';
											}
											if($file!=null)
											{
												echo "<a href=$file class='btn btn-default btn-box-tool'>
                                                <i class='fa fa-paperclip'></i> Attached Notice</a>";
											}
											if($urgent=="u"){
												echo '<h4 class="alert-message pull-right"><i class="icon fa fa-exclamation-triangle"></i><b>Urgent Notice</b></h4>';   
											}
                                            ?>
<!--------------------------------------------------------------------------------------------------------------------------->                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div id="notice<?php echo $id ?>" class="panel-collapse collapse out">
                                                                <div class="box-body">
<!--------------------------------------------------------------------------------------------------------------------------->                                                  <?php
                                                echo'<h4>Description :</h4><p class="text-justify">'.$notice.'</p>';
                                                ?>
<!--------------------------------------------------------------------------------------------------------------------------->   
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
<!--------------------------------------------------------------------------------------------------------------------------->                                        <?php
										}
									}
									else{
										echo "<h5>No Common Notice!</h5>";
									}
			?> 
<!--------------------------------------------------------------------------------------------------------------------------->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end of row5-->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php
    include("../../../Resources/Dashboard/footer.php");
?>
    </body>
</html>
