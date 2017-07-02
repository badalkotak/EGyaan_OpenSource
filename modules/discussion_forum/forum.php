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
if(!isset($_SESSION["role"]) || !isset($_SESSION["id"])){
    redirect("../../login.php");
}

if($_SESSION["role"] != Constants::ROLE_STUDENT_ID && $_SESSION["role"] != Constants::ROLE_TEACHER_ID){
    session_unset();
    session_destroy();
    redirect("../../login.php?status=" . Constants::STATUS_FAILED . "&message=" . "Invalid Access. You Have Been Logged Out");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forum</title>
</head>

<body>

<form id="add_thread" method="post" action="functions/add_thread.php">
    <label class="control-label">Title: *</label>
    <input class="form-control" id="title" type="text" placeholder="Thread Title" name="title"/>
    <br/>
    <label class="control-label">Description: *</label>
    <textarea class="form-control" id="description" placeholder="Thread Description" name="description"></textarea>
    <br/>
    <input id="student_id" type="hidden" name="student_id"
           value="<?php echo $_SESSION["role"] == Constants::ROLE_STUDENT_ID ? $_SESSION["id"] : "null"; ?>"/>
    <input id="teacher_id" type="hidden" name="teacher_id"
           value="<?php echo $_SESSION["role"] == Constants::ROLE_TEACHER_ID ? $_SESSION["id"] : "null"; ?>"/>
    <label class="control-label">Select Course: *</label>
    <select class="form-control" name="course_id" id="course_id">
        <option value="null">None</option>
        <option value='1'>SOAD</option>
        <option value='2'>OS</option>
        <option value='3'>PCOM</option>
        <option value='5'>OOPM</option>
        <option value='6'>C++</option>
        <option value='7'>ADBMS</option>
        <option value='8'>Maths 3</option>
        <option value='9'>ADC</option>
    </select>
    <br>
    <center><input class="btn btn-success" id="submit" type="submit" value="Add Thread"/></center>
</form>


<h2 style="font-size: 26px">Discussion Threads </h2>
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

<?php
$sql = "select * from egn_forum_threads order by timestamp desc";
//echo $sql;
$result = $connection->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
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

        if (strlen($row["description"]) <= 250) {
            $description = $row["description"];
        } else {
            $description = substr($row["description"], 0, 300) . "...";
        }
        echo '<a href="thread.php?id=' . $row["id"] . '"><h2>' . $row["title"] . '</h2></a>
                                    <p style="margin:0">
                                     ' . $description . '</p>
                                     <br/><span>' . $author_info . '</span>
                                     <span>' . $course_info . '</span>
                                  ';


    }
} else {
    echo "<h3>No Threads Created</h3>";
}
?>


</body>
</html>
