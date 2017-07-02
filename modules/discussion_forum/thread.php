<?php
/**
 * Created by PhpStorm.
 * User: adityajthakker
 * Date: 28/12/16
 * Time: 11:45 AM
 */
require_once "../../classes/DBConnect.php";
require_once "../../classes/Constants.php";

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

if ($_SESSION["role"] != Constants::ROLE_STUDENT_ID && $_SESSION["role"] != Constants::ROLE_TEACHER_ID) {
    session_unset();
    session_destroy();
    redirect("../../login.php?status=" . Constants::STATUS_FAILED . "&message=" . "Invalid Access. You Have Been Logged Out");
}

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
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $row["title"]; ?></title>


</head>

<body>

<div id="message">
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
        } else {
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


<h3><?php echo $row["title"]; ?></h3>
<br/>
<p><?php echo $row["description"]; ?></p>
<span><?php echo $author_info; ?></span>
<span><?php echo $course_info; ?></span>


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

        echo "<div id='each_reply' style='padding: 10px 25px;border: 1px solid #e3e3e3;background: #f5f5f5; margin:10px 0;'>" .
            "<h2>" . $author_info . "</h2>";
        if ($row["parent_reply"] != null) {
            echo "<div id='parent_reply' style='border: 1px solid #e3e3e3;padding: 5px 15px;background: #e3e3e3;    margin: 10px 0 10px 50px;'>";
            if ($row["parent_reply_student_id"] != null) {
                $sql_info = "select * from egn_student where id=" . $row["parent_reply_student_id"];
                $result_info = $connection->query($sql_info);
                if ($result_info->num_rows > 0) {
                    $row_temp_2 = $result_info->fetch_assoc();
                    $author_info = "By " . $row_temp_2["firstname"] . " " . $row_temp_2["lastname"] . "(Student)";
                } else {
                    $author_info = "By A Student";
                }
            } else if ($row["parent_reply_teacher_id"] != null) {
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
            echo "<a href='thread.php?id=" . $_REQUEST["id"] . "&parent_reply_id=" . $row["parent_reply_id"] . "#reply_box'>Reply</a>";
            echo "</div>";
        }
        echo "<p>" . $row["reply"] . "</p>" .
            "<a href='thread.php?id=" . $_REQUEST["id"] . "&parent_reply_id=" . $row["reply_id"] . "#reply_box'>Reply</a>";
        if ($_SESSION["id"] == $row["student_id"] || $_SESSION["id"] == $row["teacher_id"]) {
            echo "<a style='margin-left:20px' id='delete_link' href='functions/delete_reply.php?id=" . $row["reply_id"] . "&thread_id=" . $_REQUEST["id"] . "'>Delete</a>";
        }
        echo "</div>";
    }
} else {
    echo "<h3>No Replies</h3>";
}
?>


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
                                        </div>
                                    ";

    }
    ?>

    <form id="reply_form" action="functions/add_reply.php" method="post">
                                    <textarea class="form-control" id="reply" placeholder="Enter a reply"
                                              name="reply" style="height:100px"></textarea>
        <input type="hidden" id="parent_reply_id" name="parent_reply_id"
               value="<?php echo isset($_REQUEST['parent_reply_id']) ? $_REQUEST['parent_reply_id'] : 'null'; ?>">
        <input type="hidden" id="thread_id" name="thread_id"
               value="<?php echo $_REQUEST["id"]; ?>"/>
        <input id="student_id" type="hidden" name="student_id"
               value="<?php echo $_SESSION["role"] == Constants::ROLE_STUDENT_ID ? $_SESSION["id"] : "null"; ?>"/>
        <input id="teacher_id" type="hidden" name="teacher_id"
               value="<?php echo $_SESSION["role"] == Constants::ROLE_TEACHER_ID ? $_SESSION["id"] : "null"; ?>"/>
        <input class="btn btn-success" type="submit" id="reply_form_submit" value="Submit"/>
    </form>
</div>

</body>
</html>
