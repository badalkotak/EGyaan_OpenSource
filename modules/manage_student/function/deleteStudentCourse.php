<html>
<head>
    <title>Delete Course - Student | EGyaan</title>
    
</head>
<script type="text/javascript" src="../../../Resources/jQuery/jquery-3.2.1.js"></script>
<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 20/6/17
 * Time: 6:15 PM
 */
include("../../../Resources/sessions.php");
include('../../../Resources/Dashboard/header.php');

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Student.php");
require_once("../classes/StudentCourseRegistration.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
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
            <h1>Hello!<small>User</small></h1>
            <ol class="breadcrumb">
                <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                <li class="active"><b>List Of Notes</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!--start of Table box-->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">List Of Notes:</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
    
    
    
                                <?php
                                if (isset($_REQUEST['studentId']) && !empty(trim($_REQUEST['studentId']))) {
                                    $studentId = $_REQUEST['studentId'];

                                    $student = new Student($dbConnect->getInstance());
                                    $studentCourseRegistration = new StudentCourseRegistration($dbConnect->getInstance());

                                    $getStudentData = $student->getStudent($studentId, 0);
                                    if ($getStudentData != null) {
                                        while ($array = $getStudentData->fetch_assoc()) {
                                            $firstName = $array['firstname'];
                                            $lastName = $array['lastname'];
                                        }
                                        echo "<h5>List of Courses enrolled for <b>" . $firstName . " " . $lastName . "</b></h5>";

                                        $getData = $studentCourseRegistration->getStudentCourse($studentId);
                                        if ($getData != null) {
                                            $i = 1;
                                            echo "<table class='table table-bordered table-hover example2'>";
                                            echo "<thead><tr><th>Sr. no.</th><th>Course Name</th><th>Delete</th></tr></thead><tbody>";
                                            while ($row = $getData->fetch_assoc()) {
                                                $studentCourseRegistrationId = $row['courseRegId'];
                                                $studentCourseRegistrationCourseId = $row['courseRegCourseId'];
                                                $courseName = $row['courseName'];
                                                echo "<tr><td>" . $i . "</td><td>" . $courseName . "</td>

                                                <td><button type='submit' id='" . $studentCourseRegistrationId . "'  value='Delete' class='btn btn-danger'><i class='fa fa-trash'></i>
                                                &nbsp;Delete</button></td></tr>";
                                                $i++;
                                            }
                                            echo "</tbody></table>";
                                        } else {
                                            echo "No Courses Enrolled ";
                                        }
                                    } else {
                                        echo Constants::STATUS_FAILED;
                                    }
                                } else {
                                    echo Constants::EMPTY_PARAMETERS;
                                }
                                ?>
                            
                            </div>
                        <!-- /.box-body -->
                    </div>
                    <!--end of Table box-->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    
    <?php 
    include('../../../Resources/Dashboard/footer.php');
?>
    
<script type="text/javascript">
    $(document).ready(function () {
        $(".delete-branch-button").click(function (event) {
            event.preventDefault();
            var id = $(this).attr("id");
//            console.log(id);
            var result = confirm('<?php echo Constants::DELETE_CONFIRMATION?>');
            if (result) {
                $.ajax(
                    {
                        type: "POST",
                        url: "delete_student_course.php",
                        data: "studentCourseRegistrationId=" + id,
//                        dataType:  "json ",
                        success: function (json) {
                            var parsedJson = jQuery.parseJSON(json);
                            if (parsedJson.statusMsg == "<?php echo Constants::STATUS_SUCCESS?>") {
                                alert(parsedJson.Msg);
                                location.reload();
                            } else {
                                alert(parsedJson.Msg);
                                location.reload();
                            }
                        },
                        error: function (a, b, c) {
                            console.log("Error ");
                        }
                    });
            } else {
                return false;
            }
        });
    });
</script>

</body>
</html>

