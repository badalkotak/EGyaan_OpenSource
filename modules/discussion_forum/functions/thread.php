<?php
/**
 * Created by PhpStorm.
 * User: adityajthakker
 * Date: 28/12/16
 * Time: 11:45 AM
 */
require_once "../../../classes/DBConnect.php";
require_once "../../../classes/Constants.php";

$dbconnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
$connection = $dbconnect->getInstance();

function redirect($url)
{
    header("Location: " . $url);
}

session_start();
if (!isset($_SESSION["id"], $_SESSION["role"])) {
    redirect("../../login.php");
}

// if ($_SESSION["role"] != Constants::ROLE_STUDENT_ID && $_SESSION["role"] != Constants::ROLE_TEACHER_ID) {
//     session_unset();
//     session_destroy();
//     redirect("../../login.php?status=" . Constants::STATUS_FAILED . "&message=" . "Invalid Access. You Have Been Logged Out");
// }

if (!isset($_REQUEST["id"])) {
    redirect("forum.php");
}

$sql_select_thread = "select * from egn_forum_threads where id=" . $_REQUEST["id"];
//echo $sql_select_thread;
$result_replies = $connection->query($sql_select_thread);
$row = $result_replies->fetch_assoc();
if ($row["student_id"] != null) {
    $sql_info = "select * from egn_student where id=" . $row["student_id"];
    $result_info = $connection->query($sql_info);
    if ($result_info->num_rows > 0) {
        $row_temp_2 = $result_info->fetch_assoc();
        $author_info = "By " . $row_temp_2["firstname"] . " " . $row_temp_2["lastname"] . "(Student)";
    } else {
        $author_info = "By A Student";
    }
} else if ($row["teacher_id"] != null) {
    $sql_info = "select * from egn_teacher where id=" . $row["teacher_id"];
    $result_info = $connection->query($sql_info);
    if ($result_info->num_rows > 0) {
        $row_temp_2 = $result_info->fetch_assoc();
        $author_info = "By " . $row_temp_2["firstname"] . " " . $row_temp_2["lastname"] . "(Teacher)";
    } else {
        $author_info = "By A Teacher";
    }
} else {
    $author_info = "By Anonymous";
}
if ($row["course_id"] != null) {
    $sql_info = "select * from egn_course where id=" . $row["course_id"];
    $result_info = $connection->query($sql_info);
    if ($result_info->num_rows > 0) {
        $row_temp_2 = $result_info->fetch_assoc();
        $course_info = "In " . $row_temp_2["name"] . "(Course)";
    } else {
        $course_info = "In General Discussions";
    }
} else {
    $course_info = "In General Discussions";
}
?>


<!--START OF HEADER.PHP CODE==============================================================================================================-->

<!DOCTYPE html>
<html lang="en">
    <?php
    error_reporting();
    session_start();
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
                                            
                                            <div class="box-body">

<!--=============================================================================================================-->

                                                <div class="row" id="message">
                                                    <noscript>
                                                        <?php
                                                        if (isset($_REQUEST["status"], $_REQUEST["message"])) {
                                                            if ($_REQUEST["status"] == "success") {
                                                                echo "<p style='color:green'>" . $_REQUEST["message"] . "</p>";
                                                            } else {
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

                                                <div class="box">
                                                    <div class="box-header bg-yellow">
                                                        <h3 class="" style="margin:0px;padding:10px; border-radius:4px;"><?php echo $row["title"]; ?></h3>
                                                    </div>

                                                    <div class="box-body">
                                                        <p class="text-justify"><?php echo $row["description"]; ?></p>
                                                    </div>

                                                    <div class="box-footer">
                                                        <span><?php echo $author_info; ?></span>
                                                        <span><?php echo $course_info; ?></span>
                                                    </div>
                                                </div>
<!--//////////////////////////////////////////////////////////////////////////////////////////REPLIES START-->

                                                <?php
                                                $sql_replies = "select * from (select f1.id as reply_id, f2.student_id as parent_reply_student_id, f2.teacher_id as parent_reply_teacher_id, f2.id as parent_reply_id, f2.description as parent_reply, f1.student_id, f1.teacher_id, f1.description as reply, f1.timestamp from egn_forum_thread_replies as f1, egn_forum_thread_replies as f2 where f2.id = f1.parent_reply_id and f1.thread_id = f2.thread_id and f1.thread_id = " . $_REQUEST["id"] . " union select id as reply_id, parent_reply_id as parent_reply_student_id, parent_reply_id as parent_reply_teacher_id, parent_reply_id, parent_reply_id as parent_reply, student_id, teacher_id, description as reply, timestamp from egn_forum_thread_replies where thread_id = " . $_REQUEST["id"] . " and parent_reply_id is null) as t1 order by t1.timestamp desc";
                                                //echo $sql_replies;
                                                $result_replies = $connection->query($sql_replies);
                                                if ($result_replies->num_rows > 0) {
                                                    while ($row = $result_replies->fetch_assoc()) {
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

                                                        echo "<div id='each_reply' class='well col-md-12' style='padding: 5px 10px 10px 10px;'>" .
                                                        "<h4>" . $author_info . "</h4>";
                                                        if ($row["parent_reply"] != null) {
                                                            echo "<div class='col-md-offset-1 col-md-11' id='parent_reply' style='border-radius:4px; border: 1px solid #e3e3e3;padding: 5px 15px;background: #e3e3e3;'>";
                                                            if ($row["parent_reply_student_id"] != null) {
                                                                $sql_info = "select * from egn_student where id=" . $row["parent_reply_student_id"];
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
                                                            else if ($row["parent_reply_teacher_id"] != null) 
                                                            {
                                                                $sql_info = "select * from egn_teacher where id=" . $row["parent_reply_teacher_id"];
                                                                $result_info = $connection->query($sql_info);
                                                                if ($result_info->num_rows > 0) {
                                                                    $row_temp_2 = $result_info->fetch_assoc();
                                                                    $author_info = "By " . $row_temp_2["full_name"] . "(Teacher)";
                                                                } else {
                                                                    $author_info = "By A Teacher";
                                                                }
                                                            } else {
                                                                $author_info = "By Anonymous";
                                                            }
                                                            echo "<h4>" . $author_info . "</h4>";
                                                            echo "<p>" . $row["parent_reply"] . "</p>";
                                                            echo "<a href='thread.php?id=" . $_REQUEST["id"] . "&parent_reply_id=" . $row["parent_reply_id"] . "#reply_box' class='btn btn-primary btn-sm'><i class='fa fa-mail-reply'></i>&nbsp;Reply</a>";
                                                            echo "</div>";
                                                        }
                                                        echo "<p>" . $row["reply"] . "</p>" .
                                                            "<a href='thread.php?id=" . $_REQUEST["id"] . "&parent_reply_id=" . $row["reply_id"] .   "#reply_box' class='btn btn-primary btn-sm'><i class='fa fa-mail-reply'></i>&nbsp;Reply</a>";
                                                        if ($_SESSION["id"] == $row["student_id"] || $_SESSION["id"] == $row["teacher_id"]) {
                                                            echo "<a class='btn btn-danger btn-sm' style='margin-left:10px' id='delete_link' href='delete_reply.php?id=" . $row["reply_id"] . "&thread_id=" . $_REQUEST["id"] . "'><i class='fa fa-trash'></i>&nbsp;Delete</a>";
                                                        }
                                                        echo "</div>";
                                                    }
                                                }
                                                else
                                                {
                                                    echo "<h3>No Replies</h3>";
                                                }
                                                ?>

<!--/////////////////////////////////////////////////////////////////////////////////////////REPLY FORM DIV START-->
                                                <div id="reply_form_div">
                                                    <a name="reply_box"></a>

                                                    <?php
                                                    if (isset($_REQUEST["parent_reply_id"], $_REQUEST["id"])) {
                                                        $sql_select_thread = "select * from egn_forum_thread_replies where id=" . $_REQUEST["parent_reply_id"];
                                                        $result_replies = $connection->query($sql_select_thread);
                                                        $row = $result_replies->fetch_assoc();
                                                        if ($row["student_id"] != null) {
                                                            $sql_info = "select * from egn_student where id=" . $row["student_id"];
                                                            $result_info = $connection->query($sql_info);
                                                            if ($result_info->num_rows > 0) {
                                                                $row_temp_2 = $result_info->fetch_assoc();
                                                                $author_info = "By " . $row_temp_2["firstname"] . " " . $row_temp_2["lastname"] . "(Student)";
                                                            } else {
                                                                $author_info = "By A Student";
                                                            }
                                                        } else if ($row["teacher_id"] != null) {
                                                            $sql_info = "select * from egn_teacher where id=" . $row["teacher_id"];
                                                            $result_info = $connection->query($sql_info);
                                                            if ($result_info->num_rows > 0) {
                                                                $row_temp_2 = $result_info->fetch_assoc();
                                                                $author_info = "By " . $row_temp_2["firstname"] . " " . $row_temp_2["lastname"] . "(Teacher)";
                                                            } else {
                                                                $author_info = "By A Teacher";
                                                            }
                                                        } else {
                                                            $author_info = "By Anonymous";
                                                        }

                                                        echo "
                                                        <div style='border: 1px solid #e3e3e3;padding: 5px 15px;background: #e3e3e3;    margin: 10px 0 10px 0px;'>
                                                        <h4>" . $author_info . "</h4>
                                                        <p>" . $row["description"] . "</p>
                                                        </div>";

                                                    }
                                                    ?>

                                                    <form id="reply_form" action="add_reply.php" method="post">
                                                        <div class="form-group">
                                                            <textarea class="form-control" style="resize: vertical;"  id="reply" placeholder="Enter a reply" name="reply" style="height:100px"></textarea>
                                                        </div>
                                                        
                                                        <input type="hidden" id="parent_reply_id" name="parent_reply_id"
                                                               value="<?php echo isset($_REQUEST['parent_reply_id']) ? $_REQUEST['parent_reply_id'] : 'null'; ?>">
                                                        
                                                        <input type="hidden" id="thread_id" name="thread_id"
                                                               value="<?php echo $_REQUEST["id"]; ?>"/>
                                                        
                                                        <input id="student_id" type="hidden" name="student_id"
                                                               value="<?php echo $_SESSION["role"] == Constants::ROLE_STUDENT_ID ? $_SESSION["id"] : "null"; ?>"/>
                                                        
                                                        <input id="teacher_id" type="hidden" name="teacher_id"
                                                               value="<?php echo $_SESSION["role"] == Constants::ROLE_TEACHER_ID ? $_SESSION["id"] : "null"; ?>"/>
                                                        
                                                        <div class="form-group">
                                                            <button class="btn btn-success" type="submit" id="reply_form_submit"><i class="fa fa-check"></i>&nbsp;Submit</button>
                                                        </div>
                                                        
                                                    </form>
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
                    
<!--END OF FOOTER.PHP CODE=============================================================================================================-->
</body>
</html>
