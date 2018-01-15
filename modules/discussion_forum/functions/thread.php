<?php
/**
 * Created by PhpStorm.
 * User: adityajthakker
 * Date: 28/12/16
 * Time: 11:45 AM
 */
require_once "../../../classes/DBConnect.php";
require_once "../../../classes/Constants.php";
include("../../../Resources/Dashboard/header.php");

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

<!--START OF CONTENT DIV=============================================================================================================-->

                        <div class="content-wrapper">
                            <!-- Content Header (Page header) -->
                            <section class="content-header">
                                <br>
                                <ol class="breadcrumb">
                                    <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                                    <li><a href="forum.php">Forum</a></li>
                                    <li class="active"><b>Thread</b></li>
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
                                                        <h3 class="" style="margin:0px;padding:10px; border-radius:4px;color:white"><?php echo $row["title"]; ?></h3>
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
                                                        echo "<div class='row'><div class='col-md-12'><p>" . $row["reply"] . "</p>" .
                                                            "<a href='thread.php?id=" . $_REQUEST["id"] . "&parent_reply_id=" . $row["reply_id"] .   "#reply_box' class='btn btn-primary btn-sm'><i class='fa fa-mail-reply'></i>&nbsp;Reply</a>";
                                                        if ($_SESSION["id"] == $row["student_id"] || $_SESSION["id"] == $row["teacher_id"]) {
                                                            echo "<a class='btn btn-danger btn-sm' style='margin-left:10px' id='delete_link' href='delete_reply.php?id=" . $row["reply_id"] . "&thread_id=" . $_REQUEST["id"] . "'><i class='fa fa-trash'></i>&nbsp;Delete</a>";
                                                        }
                                                        echo "</div></div></div>";
                                                    }
                                                }
                                                else
                                                {
                                                    echo "<h3>No Replies</h3>";
                                                }
                                                ?>

<!--/////////////////////////////////////////////////////////////////////////////////////////REPLY FORM DIV START-->
                                            <div class="row">
                                                <div class="col-md-12" id="reply_form_div">
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
        
<?php
include("../../../Resources/Dashboard/footer.php");
?>
</body>
</html>
