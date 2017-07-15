<?php
/**
 * Created by PhpStorm.
 * User: adityajthakker
 * Date: 28/12/16
 * Time: 11:45 AM
 */
require_once "../../../classes/DBConnect.php";
require_once "../../../classes/Constants.php";
include("../../../Resources/sessions.php");
$dbconnect = new DBConnect(Constants::SERVER_NAME,
                           Constants::DB_USERNAME,
                           Constants::DB_PASSWORD,
                           Constants::DB_NAME);
$connection = $dbconnect->getInstance();

function getTeacherCourse($connection, $teacherStatus, $teacherId, $multiQuery, $batchId, $courseId, $batchName, $branchId)
{
    if ($teacherStatus == "yes" && $teacherId > 0 && $multiQuery == 'no' && $batchId == 0 && $courseId == 0 && $batchName == null && $branchId == 0) { //This will give course details for Teacher
        $sql = "SELECT eBranch.id AS branchId,eBranch.name AS branchName,eBatch.id AS batchId,eBatch.name 
        AS batchName,eBatch.branch_id AS batchBranchId,eCourse.id AS courseId,eCourse.name AS courseName,eCourse.batch_id 
        AS courseBatchId,eTeacherCourse.id AS teacherCourseId,eTeacherCourse.user_id 
        AS teacherCourseUserId,eTeacherCourse.course_id AS teacherCourseCourseId FROM `egn_teacher_course` 
        AS eTeacherCourse,`egn_course` AS eCourse,`egn_batch` 
        AS eBatch,`egn_branch` AS eBranch WHERE eTeacherCourse.course_id = eCourse.id AND eCourse.batch_id = eBatch.id 
        AND eBatch.branch_id = eBranch.id AND eTeacherCourse.user_id = '$teacherId'";
    }
    elseif ($teacherStatus == 'no' && $teacherId == 0 && $multiQuery == 'no' && $batchId == 0 && $courseId > 0
            && $batchName == null && $branchId == 0)
    { //This will give course details in General
        $sql = "SELECT * FROM `egn_course` WHERE id = '$courseId'";
    }
    elseif ($teacherStatus == "no" && $teacherId > 0 && $multiQuery == 'no' && $batchId == 0 && $courseId == 0 && $batchName == null && $branchId == 0)
    { //This will give course details for Student
        $sql = "SELECT * FROM `egn_course_reg` AS cr, `egn_course` AS c WHERE cr.course_id = c.id 
        AND student_id='$teacherId'";
    }
    elseif ($teacherStatus == "no" && $teacherId == 0 && $multiQuery == 'yes' && $batchId == 0 && $courseId == 0 && $batchName == null && $branchId == 0)
    {
        $sql = "SELECT eBranch.id AS branchId,eBranch.name AS branchName,eBatch.id AS batchId,eBatch.name 
        AS batchName,eBatch.branch_id AS batchBranchId,eCourse.id AS courseId,eCourse.name AS courseName,eCourse.batch_id 
        AS courseBatchId FROM `egn_course` AS eCourse,`egn_batch` AS eBatch,`egn_branch` AS eBranch 
        WHERE eCourse.batch_id = eBatch.id AND eBatch.branch_id = eBranch.id";
    }
    elseif ($teacherStatus == "no" && $teacherId == 0 && $multiQuery == 'yes' && $batchId > 0 && $courseId == 0 && $batchName == null && $branchId == 0)
    {
        $sql = "SELECT eBranch.id AS branchId,eBranch.name AS branchName,eBatch.id AS batchId,eBatch.name 
        AS batchName,eBatch.branch_id AS batchBranchId,eCourse.id AS courseId,eCourse.name AS courseName,eCourse.batch_id 
        AS courseBatchId FROM `egn_course` AS eCourse,`egn_batch` AS eBatch,`egn_branch` AS eBranch 
        WHERE eCourse.batch_id = eBatch.id AND eBatch.branch_id = eBranch.id AND eCourse.batch_id = '$batchId'";
    }
    elseif ($teacherStatus == "no" && $teacherId == 0 && $multiQuery == 'yes' && $batchId == 0 && $courseId == 0 && $batchName != null && $branchId == 0)
    {
        $sql = "SELECT eBranch.id AS branchId,eBranch.name AS branchName,eBatch.id AS batchId,eBatch.name 
        AS batchName,eBatch.branch_id AS batchBranchId,eCourse.id AS courseId,eCourse.name AS courseName,eCourse.batch_id 
        AS courseBatchId FROM `egn_course` AS eCourse,`egn_batch` AS eBatch,`egn_branch` AS eBranch 
        WHERE eCourse.batch_id = eBatch.id AND eBatch.branch_id = eBranch.id AND eBatch.name = '$batchName'";
    }
    elseif ($teacherStatus == "no" && $teacherId > 0 && $multiQuery == 'yes' && $batchId > 0 && $courseId == 0 && $batchName == null && $branchId > 0)
    {
        $sql = "SELECT DISTINCT c.id,c.name 
        FROM egn_batch as batch ,egn_course as c ,egn_users as u ,egn_role as r, egn_teacher_course as tc 
        WHERE batch.branch_id = " . $branchId . " AND c.batch_id = batch.id AND tc.course_id=c.id AND tc.user_id=u.id AND u.id=" . $teacherId . " AND batch.id = " . $batchId . " AND u.role_id = r.id AND r.is_teacher=1
        ORDER BY c.name";
    }
    else
    {
        // $sql = "SELECT * FROM `egn_course`";
        $sql = "SELECT eBranch.id AS branchId,eBranch.name AS branchName,eBatch.id AS batchId,eBatch.name 
        AS batchName,eBatch.branch_id AS batchBranchId,eCourse.id AS courseId,eCourse.name AS courseName,eCourse.batch_id 
        AS courseBatchId FROM `egn_course` AS eCourse,`egn_batch` AS eBatch,`egn_branch` AS eBranch 
        WHERE eCourse.batch_id = eBatch.id AND eBatch.branch_id = eBranch.id";
    }
    $result = $connection->query($sql);
    //        var_dump($result);
    if ($result->num_rows > 0)
    {
        return $result;
    }
    else
    {
        return false;
    }
}
function getStudentCourse($connection, $id)
{
    if ($id > 0) {
        $sql = "SELECT eCourseReg.id AS courseRegId,eCourseReg.student_id AS courseRegStudentId,eCourseReg.course_id AS courseRegCourseId,eCourse.id AS courseId,eCourse.name AS courseName,eCourse.batch_id AS courseBatchId FROM `egn_course_reg` AS eCourseReg,`egn_course` AS eCourse 
        WHERE eCourseReg.course_id = eCourse.id AND eCourseReg.student_id = '" . $id . "'";
    }
    else {
        $sql = "SELECT * FROM `egn_course_reg`";
    }
    $result = $connection->query($sql);
    
    if ($result->num_rows > 0) {
        return $result;
    }
    else {
        return false;
    }
}
$courses_name = array();
$courses_id = array();
if($_SESSION["role"] == Constants::ROLE_TEACHER_ID) {
    $courses = getTeacherCourse($connection, "yes", $_SESSION["id"], "no", 0, 0, null, 0);
    
    while($row = $courses->fetch_assoc()){
        $courses_name[] = $row["courseName"] . " - " . $row["batchName"] . " - " . $row["branchName"];
        $courses_id[] = $row["courseId"];
    }
}
else{
    $courses = getStudentCourse($connection, $_SESSION["id"]);
    while($row = $courses->fetch_assoc()){
        $courses_name[] = $row["courseName"];
        $courses_id[] = $row["courseId"];
    }
    //    print_r($courses_name);
}
function redirect($url)
{
    header("Location: " . $url);
}

// session_start();
// if(!isset($_SESSION["role"]) || !isset($_SESSION["id"])){
//     redirect("../../login/functions/login.php");
// }

// if($_SESSION["role"] != Constants::ROLE_STUDENT_ID && $_SESSION["role"] != Constants::ROLE_TEACHER_ID){
//     session_unset();
//     session_destroy();
//     redirect("../../login.php?status=" . Constants::STATUS_FAILED . "&message=" . "Invalid Access. You Have Been Logged Out");
// }

?>



<!--START OF HEADER.PHP CODE==============================================================================================================-->

<!DOCTYPE html>
<html lang="en">
    <?php
    error_reporting();
    $user_id=$_SESSION['id'];
    $role_id=$_SESSION['role'];
    require_once("../../../classes/DBConnect.php");
    require_once("../../manage_user/classes/User.php");
    require_once("../../manage_batch/classes/Batch.php");
    require_once("../../manage_student/classes/Student.php");
    require_once("../../../classes/Constants.php");
    
    $dbConnect = new DBConnect(Constants::SERVER_NAME,
                               Constants::DB_USERNAME,
                               Constants::DB_PASSWORD,
                               Constants::DB_NAME);
    
    if($role_id==Constants::ROLE_STUDENT_ID || $role_id==Constants::ROLE_PARENT_ID)
    {
        $student=new Student($dbConnect->getInstance());
        $batch=new Batch($dbConnect->getInstance());
        $getStudentDetails=$student->getStudent($user_id,0);
        
        while($row=$getStudentDetails->fetch_assoc())
        {
            if($role_id==Constants::ROLE_STUDENT_ID)
            {
                $firstname=$row['firstname'];
                $lastname=$row['lastname'];
                $profile=$row['student_profile_photo'];
            }
            else
            {
                $firstname=$row['parent_name'];
                $lastname=$row['lastname'];
                $profile=$row['parent_profile_photo'];
            }
            
            $batch_id=$row['batch_id'];
            $display_name=$firstname." ".$lastname;
            
            $getBatch=$batch->getBatch("no",0,$batch_id,"no",0);
            while($batchRow=$getBatch->fetch_assoc())
            {
                $batch_name=$batchRow['batchName'];
                $branch_name=$batchRow['branchName'];
            }	
        }
    }
    else
    {
        if($role_id===Constants::ROLE_ADMIN_ID)
        {
            $display_name="Admin";
        }
        else
        {
            $user=new User($dbConnect->getInstance());
            $getUserDetails=$user->getUser($user_id);
            
            while($row=$getUserDetails->fetch_assoc())
            {
                $display_name=$row['name'];
                $batch_name="";
                $branch_name="";
            }
        }
    }
    ?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>EGyaan | Forum</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="../../../Resources/AdminLTE-2.3.11/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        
        <!-- Select2 -->
        <link rel="stylesheet" href="../../../Resources/AdminLTE-2.3.11/plugins/select2/select2.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../../../Resources/AdminLTE-2.3.11/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="../../../Resources/AdminLTE-2.3.11/dist/css/skins/_all-skins.min.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <!-- <<<<<<< HEAD -->
        <!-- Site wrapper -->
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="../../../Resources/AdminLTE-2.3.11/index2.html" class="logo">
                    <!--mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><img src="../../../Resources/images/E_logo_transparent_small.png"></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><img src="../../../Resources/images/EGYAAN_logo_transparent_small_white.png"></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <nav class="navbar navbar-static-top">
                                <div class="navbar-custom-menu">
                                    <ul class="nav navbar-nav">
                                        <!-- Messages: style can be found in dropdown.less-->
                                        <li class="dropdown messages-menu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-envelope-o"></i>
                                                <span class="label label-success">4</span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="header">You have 4 messages</li>
                                                <li>
                                                    <!-- inner menu: contains the actual data -->
                                                    <ul class="menu">
                                                        <li><!-- start message -->
                                                            <a href="#">
                                                                <div class="pull-left">
                                                                     <img src="../../../Resources/images/boy.png" class="img-circle" alt="User Image"> 
                                                                </div>
                                                                <h4>
                                                                    Support Team
                                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                                </h4>
                                                                <p>Why not buy a new awesome theme?</p>
                                                            </a>
                                                        </li>
                                                        <!-- end message -->
                                                    </ul>
                                                </li>
                                                <li class="footer"><a href="#">See All Messages</a></li>
                                            </ul>
                                        </li>
                                        <!-- Notifications: style can be found in dropdown.less -->
                                        <li class="dropdown notifications-menu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-bell-o"></i>
                                                <span class="label label-danger">10</span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="header">You have 10 notifications</li>
                                                <li>
                                                    <!-- inner menu: contains the actual data -->
                                                    <ul class="menu">
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="footer"><a href="#">View all</a></li>
                                            </ul>
                                        </li>
                                        
                                        <!-- User Account: style can be found in dropdown.less -->
                                        <li class="dropdown user user-menu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                <?php
                                                if($profile!=null)
                                                {
                                                    echo "<img src='../../manage_student/images/student/$profile' 
                                                    class=user-image alt='User Image'>";
                                                }
                                                else
                                                {
                                                    echo "<img src='../../../Resources/images/boy.png' class=user-image alt='User Image'>";
                                                }
                                                echo "<span class=hidden-xs>$display_name</span>";
                                                ?>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <!-- User image -->
                                                <li class="user-header">
                                                    <?php
                                                    if($profile!=null)
                                                    {
                                                        echo "<img src='../../manage_student/images/student/$profile' class=img-circle alt='User Image'>";
                                                    }
                                                    else
                                                    {
                                                        echo "<img src='../../../Resources/images/boy.png' class=img-circle alt='User Image'>";
                                                    }
                                                    ?>
                                                    <p>
                                                        <?php
                                                        if($batch_name!="")
                                                        {
                                                            echo "$display_name - $branch_name";
                                                        }
                                                        else
                                                        {
                                                            echo "$display_name";
                                                        }
                                                        ?>
                                                    </p>
                                                </li>
                                                <!-- Menu Body -->
                                                <li class="user-body">
                                                    <div class="row">
                                                        <?
                                                        echo '<div class="col-xs-12 text-center">';
                                                        echo "$batch_name";
                                                        echo '</div>';
                                                        ?>
                                                    </div>
                                                    <!-- /.row -->
                                                </li>
                                                <!-- Menu Footer-->
                                                <li class="user-footer">
                                                    <div class="pull-left">
                                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                                    </div>
                                                    <div class="pull-right">
                                                        <a href="../../login/functions/logout.php" class="btn btn-default btn-flat">Sign out</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <!-- Control Sidebar Toggle Button -->
                                        <li>
                                            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                            </header>
                        
<!-- =============================================== -->
                        
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
        
<!--END OF HEADER.PHP CODE==============================================================================================================-->

<!--START OF CONTENT DIV=============================================================================================================-->

                        <div class="content-wrapper">
                            <!-- Content Header (Page header) -->
                            <section class="content-header">
                                <h1>Hello!<small>User</small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                                    <li class="active"><b>Forum</b></li>
                                </ol>
                            </section>
                            
                            <!-- Main content -->
                            <section class="content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!--start of Table box-->
                                        <div class="box">
                                            <div class="box-header">
                                                <h3 class="box-title">Add Forum:</h3>
                                            </div>
                                            <!-- /.box-header -->
                                            <div class="box-body">

<!--=============================================================================================================-->
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <form id="add_thread" method="post" action="add_thread.php">
                                                            <div class="form-group">
                                                                <input class="form-control" id="title" type="text" placeholder="Enter Thread Title" name="title"/>
                                                            </div>

                                                            <div class="form-group">
                                                                <textarea class="form-control" style="resize: vertical;" id="description" placeholder="Enter Thread Description..." name="description"></textarea>
                                                            </div>
                                                            
                                                            <input id="student_id" type="hidden" name="student_id" value="<?php echo $_SESSION["role"] == Constants::ROLE_STUDENT_ID ? $_SESSION["id"] : "null"; ?>"/>
                                                            
                                                            <input id="teacher_id" type="hidden" name="teacher_id" value="<?php echo $_SESSION["role"] == Constants::ROLE_TEACHER_ID ? $_SESSION["id"] : "null"; ?>"/>
                                                            
                                                            <div class="form-group">
                                                                <select class="form-control select2" name="course_id" id="course_id">
                                                                    <option selected disabled>Select Course</option>
                                                                    <option value="null">None</option>
                                                                    <?php
                                                                    $i = 0;
                                                                    foreach ($courses_id as &$id) {
                                                                        echo "<option value=".$id.">".$courses_name[$i]."</option>";
                                                                        $i++;
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <button class="btn btn-success" id="submit" type="submit"><span class="fa fa-check"></span>&nbsp;Add Thread</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <hr>
                                                <h2>Discussion Threads:</h2>
                                                <div class="row">
                                                        <div class="col-md-12" id="message">
                                                            <noscript>
                                                                <?php
                                                                if (isset($_REQUEST["status"], $_REQUEST["message"])) {
                                                                    if ($_REQUEST["status"] == "success") {
                                                                        echo "<p style='color:green'>" . $_REQUEST["message"] . "</p>";
                                                                    } 
                                                                    else 
                                                                    {
                                                                        echo "<p style='color:red'>" . $_REQUEST["message"] . "</p>";
                                                                    }
                                                                }
                                                                ?>
                                                            </noscript>
                                                            <?php
                                                            if (isset($_REQUEST["status"]) && isset($_REQUEST["message"])) {
                                                                if ($_REQUEST["status"] == "success") {
                                                                    echo "<script type='text/javascript'>
                                                                    $(document).ready(function() {
                                                                    new PNotify({
                                                                    title: 'Success',
                                                                    type: 'success',
                                                                    text: '" . $_REQUEST["message"] . "',
                                                                    nonblock: {
                                                                    nonblock: false
                                                                    },
                                                                    styling: 'bootstrap3',
                                                                    hide: true,
                                                                    before_close: function(PNotify) {
                                                                    PNotify.update({
                                                                    title: PNotify.options.title + ' - Enjoy your Stay',
                                                                    before_close: null
                                                                    });
                                                                    PNotify.queueRemove();
                                                                    return false;
                                                                    }
                                                                    });
                                                                    });
                                                                    </script>";
                                                                }
                                                                else
                                                                {
                                                                    echo "<script type='text/javascript'>
                                                                    $(document).ready(function() {
                                                                    new PNotify({
                                                                    title: 'Ohh No! Failure',
                                                                    type: 'error',
                                                                    text: '" . $_REQUEST["message"] . "',
                                                                    nonblock: {
                                                                    nonblock: false
                                                                    },
                                                                    styling: 'bootstrap3',
                                                                    hide: true,
                                                                    before_close: function(PNotify) {
                                                                    PNotify.update({
                                                                    title: PNotify.options.title + ' - Enjoy your Stay',
                                                                    before_close: null
                                                                    });

                                                                    PNotify.queueRemove();

                                                                    return false;
                                                                    }
                                                                    });
                                                                    });
                                                                    </script>";
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="col-md-12">
                                                        <?php
                                                        $sql = "select * from egn_forum_threads order by timestamp desc";
//                                                        echo $sql;
                                                        $result = $connection->query($sql);
                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                if ($row["student_id"] != null) {
                                                                    $sql_info = "select * from egn_student where id=" . $row["student_id"];
                                                                    $result_info = $connection->query($sql_info);
                                                                    if ($result_info->num_rows > 0) {
                                                                        $row_temp_2 = $result_info->fetch_assoc();
                                                                        $author_info = "By " . $row_temp_2["firstname"] . " " . $row_temp_2["lastname"] . "(Student)";
                                                                    }
                                                                    else
                                                                    {
                                                                        $author_info = "By A Student";
                                                                    }
                                                                }
                                                                else if ($row["teacher_id"] != null)
                                                                {
                                                                    $sql_info = "select * from egn_teacher where id=" . $row["teacher_id"];
                                                                    $result_info = $connection->query($sql_info);
                                                                    if ($result_info->num_rows > 0) {
                                                                        $row_temp_2 = $result_info->fetch_assoc();
                                                                        $author_info = "By " . $row_temp_2["firstname"] . " " . $row_temp_2["lastname"] . "(Teacher)";
                                                                    }
                                                                    else
                                                                    {
                                                                        $author_info = "By A Teacher";
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                    $author_info = "By Anonymous";
                                                                }

                                                                if ($row["course_id"] != null) {
                                                                    $sql_info = "select * from egn_course where id=" . $row["course_id"];
                                                                    $result_info = $connection->query($sql_info);
                                                                    if ($result_info->num_rows > 0) 
                                                                    {
                                                                        $row_temp_2 = $result_info->fetch_assoc();
                                                                        $course_info = "In " . $row_temp_2["name"] . "(Course)";
                                                                    }
                                                                    else
                                                                    {
                                                                        $course_info = "In General Discussions";
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                    $course_info = "In General Discussions";
                                                                }

                                                                if (strlen($row["description"]) <= 250)
                                                                {
                                                                    $description = $row["description"];
                                                                }
                                                                else
                                                                {
                                                                    $description = substr($row["description"], 0, 300) . "...";
                                                                }
                                                                echo '<div class="box box-default"
                                                                        style="background-color: #d2d6de;
                                                                        border: 1px solid #e3e3e3;">
                                                                                <div class="box-header with-border" style="background-color: #d2d6de;">
                                                                                    <a href="thread.php?id=' . $row["id"] . '">
                                                                                        <h3  class="box-title">' . $row["title"] . '</h3>
                                                                                    </a>
                                                                                </div>
                                                                                <div class="box-body text-justify clearfix" style="background-color: #e3e3e3">
                                                                                <p>' 
                                                                                    . $description . 
                                                                                '</p>
                                                                                </div>

                                                                                <div class="box-footer text-muted" style="background-color: #d2d6de;">
                                                                                    <small>' 
                                                                                        . $author_info .
                                                                                    '&nbsp;&nbsp;' 
                                                                                        . $course_info . 
                                                                                    '</small>
                                                                                </div>
                                                                            </div>';
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo "<h3>No Threads Created</h3>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                
<!--=============================================================================================================-->   
                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </section>
                            <!-- /.content -->
                        </div>
                        <!-- /.content-wrapper -->
                        
<!--END OF CONTENT DIV=============================================================================================================-->
        
<!--START OF FOOTER.PHP CODE=============================================================================================================-->
                        
                        <footer class="main-footer">
                            <div class="pull-right hidden-xs">
                                <b>Version</b> 2.3.8
                            </div>
                            <strong>Copyright &copy; 2014-2016 <a href="http://www.e-gyaan.in">EGYAAN</a>.</strong> All rights reserved.
                        </footer>
                        
                        <!-- Control Sidebar -->
                        <aside class="control-sidebar control-sidebar-dark">
                            <!-- Create the tabs -->
                            <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                                <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                                <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <!-- Home tab content -->
                                <div class="tab-pane" id="control-sidebar-home-tab">
                                    <h3 class="control-sidebar-heading">Recent Activity</h3>
                                    <ul class="control-sidebar-menu">
                                        <li>
                                            <a href="javascript:void(0)">
                                                <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                                                <div class="menu-info">
                                                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                                                    <p>Will be 23 on April 24th</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <i class="menu-icon fa fa-user bg-yellow"></i>
                                                <div class="menu-info">
                                                    <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                                                    <p>New phone +1(800)555-1234</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                                                <div class="menu-info">
                                                    <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                                                    <p>nora@example.com</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <i class="menu-icon fa fa-file-code-o bg-green"></i>
                                                <div class="menu-info">
                                                    <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                                                    <p>Execution time 5 seconds</p>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- /.control-sidebar-menu -->
                                    <h3 class="control-sidebar-heading">Tasks Progress</h3>
                                    <ul class="control-sidebar-menu">
                                        <li>
                                            <a href="javascript:void(0)">
                                                <h4 class="control-sidebar-subheading">
                                                    Custom Template Design
                                                    <span class="label label-danger pull-right">70%</span>
                                                </h4>
                                                <div class="progress progress-xxs">
                                                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <h4 class="control-sidebar-subheading">
                                                    Update Resume
                                                    <span class="label label-success pull-right">95%</span>
                                                </h4>
                                                <div class="progress progress-xxs">
                                                    <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <h4 class="control-sidebar-subheading">
                                                    Laravel Integration
                                                    <span class="label label-warning pull-right">50%</span>
                                                </h4>
                                                <div class="progress progress-xxs">
                                                    <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <h4 class="control-sidebar-subheading">
                                                    Back End Framework
                                                    <span class="label label-primary pull-right">68%</span>
                                                </h4>
                                                <div class="progress progress-xxs">
                                                    <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- /.control-sidebar-menu -->
                                </div>
                                <!-- /.tab-pane -->
                                <!-- Stats tab content -->
                                <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                                <!-- /.tab-pane -->
                                <!-- Settings tab content -->
                                <div class="tab-pane" id="control-sidebar-settings-tab">
                                    <form method="post">
                                        <h3 class="control-sidebar-heading">General Settings</h3>
                                        <div class="form-group">
                                            <label class="control-sidebar-subheading">
                                                Report panel usage
                                                <input type="checkbox" class="pull-right" checked>
                                            </label>
                                            <p>
                                                Some information about this general settings option
                                            </p>
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label class="control-sidebar-subheading">
                                                Allow mail redirect
                                                <input type="checkbox" class="pull-right" checked>
                                            </label>
                                            <p>
                                                Other sets of options are available
                                            </p>
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label class="control-sidebar-subheading">
                                                Expose author name in posts
                                                <input type="checkbox" class="pull-right" checked>
                                            </label>
                                            <p>
                                                Allow the user to show his name in blog posts
                                            </p>
                                        </div>
                                        <!-- /.form-group -->
                                        <h3 class="control-sidebar-heading">Chat Settings</h3>
                                        <div class="form-group">
                                            <label class="control-sidebar-subheading">
                                                Show me as online
                                                <input type="checkbox" class="pull-right" checked>
                                            </label>
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label class="control-sidebar-subheading">
                                                Turn off notifications
                                                <input type="checkbox" class="pull-right">
                                            </label>
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label class="control-sidebar-subheading">
                                                Delete chat history
                                                <a href="javascript:void(0)" class="text-red pull-right"><i class="fa 
                                                    a-trash-o"></i></a>
                                            </label>
                                        </div>
                                        <!-- /.form-group -->
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                        </aside>
                        <!-- /.control-sidebar -->
                        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
                        <div class="control-sidebar-bg"></div>
                    </div>
                    <!-- ./wrapper -->
                    
                    <!-- jQuery 2.2.3 -->
                    <script src="../../../Resources/AdminLTE-2.3.11/plugins/jQuery/jquery-2.2.3.min.js"></script>
                    <!-- Bootstrap 3.3.6 -->
                    <script src="../../../Resources/AdminLTE-2.3.11/bootstrap/js/bootstrap.min.js"></script>
                    <!-- Select2 -->
                    <script src="../../../Resources/AdminLTE-2.3.11/plugins/select2/select2.full.min.js"></script>
                  

                    <script>
                        $(function () {
                            //Initialize Select2 Elements
                            $(".select2, #select2").select2();
                        });
                    </script>
                    
<!--END OF FOOTER.PHP CODE=============================================================================================================-->
                    </body>
                </html>
