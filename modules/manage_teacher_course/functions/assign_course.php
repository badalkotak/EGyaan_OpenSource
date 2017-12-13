<?php
include("../../../Resources/sessions.php");

require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../classes/TeacherCourse.php");
require_once("../../manage_role/classes/Role.php");
require_once("../../manage_branch/classes/Branch.php");
require_once("../../manage_course/classes/Course.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$user_id=$_REQUEST['user_id'];
?>

<html>
<head>
    <?php
    include "../../../Resources/Dashboard/header.php"
    ?>
	<title>Assign Course</title>
	<script src="../../../Resources/jquery.min.js"></script>
</head>
<body>
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
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <br>
            <ol class="breadcrumb">
                <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="../../manage_user/functions/user.php">Manage Users</a></li>
                <li class="active"><b>Assign Course</b></li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Assign Course</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
	<form role="form" action="add_teacher_course.php" method="post">
		<div class="form-group">
            <label>Branch</label>
        <select class="form-control select2" name="branch" id="branch">
		<option value=-1>Select Branch</option>
		<?php
			$branch=new Branch($dbConnect->getInstance());

			$getBranch=$branch->getBranch();
			if($getBranch!=null)
			{
				while($row=$getBranch->fetch_assoc())
				{
					$branch_id=$row['id'];
					$branch_name=$row['name'];

					echo "<option value=$branch_id>$branch_name</option>";
				}
			}
		?>
		</select>
        </div>
	</form>
	<div id="batch_div"></div>
			<?php
				$course=new Course($dbConnect->getInstance());

				$getCourse=$course->getCourse("yes",$user_id,"no",0,0,null,0);

				$i=0;

				if($getCourse!=false)
				{
                    echo "<hr><div class='box-header'>
                            <h3 class='box-title'><b>Courses</b></h3>
                        </div>";
				    echo "<div class='table-container1'><table class='table table-bordered table-hover example2'>
							<thead>
								<th>Sr No.</th>
								<th>Branch</th>
								<th>Batch</th>
								<th>Course</th>
								<th>Delete</th>
							</thead>
							<tbody>";

					while($row=$getCourse->fetch_assoc())
					{
						$i++;
						$courseId=$row['courseId'];
						$courseName=$row['courseName'];

						$batchName=$row['batchName'];
						$branchName=$row['branchName'];

						echo "<tr>";

						echo "<td>";
						echo $i;
						echo "</td>";

						echo "<td>";
						echo $branchName;
						echo "</td>";

						echo "<td>";
						echo $batchName;
						echo "</td>";

						echo "<td>";
						echo $courseName;
						echo "</td>";

						echo "<td>";
						echo "<form action=delete_teacher_course.php method=post><button class='btn btn-danger' type=submit value=$courseId name=courseId><i class='fa fa-trash'></i>&nbsp;Delete</button></form>";
						echo "</td>";

						echo "</tr>";
					}

					echo "</tbody>
					</table></div>";
				}
				else
				{
					echo "No courses assigned yet!";
				}
			?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



<script>
$(document).ready(function(){
	$("#branch").change(function(){
		var branch_id=$("#branch").val();
		<?php
			echo "var user_id=$user_id";
		?>

		if(branch_id!=-1)
		{
			$.ajax({
				type: "POST",
				url: "getBatch.php",
				data: "branch_id="+branch_id,
				datatype: "json",

				success:function(json)
				{
					var status=json.status;
					var count=json.batch.length;
					var batch_dropdown="<input type=radio hidden value="+user_id+" id=user_id><div class='form-group'><label>Batch</label><select class='form-control' name=batch id=batch><option value=-1>Select Batch</option>";

					for(var i=0;i<count;i++)
					{
						batch_dropdown = batch_dropdown + "<option value="+json.batch[i].id+">"+json.batch[i].name+"</option>";
					}

					batch_dropdown = batch_dropdown + "</select></div><div id=course_div></div><script type=text/javascript src='getBatch.js'></ script>";

					$("#batch_div").html(batch_dropdown);
				}
			});
		}
		else
		{
			$("#batch_div").text("Please select the Branch!");
		}
	});

	// $("#batch").change(function(){
	// 	var batch_id=$("#batch").val();

	// 	console.log("Hua");
	// 	if(batch_id!=-1)
	// 	{
	// 		$.ajax({
	// 			type: "POST",
	// 			url: "getCourse.php",
	// 			data: "batch_id="+batch_id,
	// 			datatype: "json",

	// 			success:function(json)
	// 			{
	// 				console.log(json);
	// 			}
	// 		});
	// 	}
	// });
});
</script>
	<script src=getBatch.js></script>
	<script src=checkCourse.js></script>
<?php
include "../../../Resources/Dashboard/footer.php";
?>
</body>
</html>