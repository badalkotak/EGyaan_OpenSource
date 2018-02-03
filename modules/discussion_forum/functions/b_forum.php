<?php
/**
 * Created by PhpStorm.
 * User: adityajthakker
 * Date: 28/12/16
 * Time: 11:45 AM
 */
include("../../Resources/sessions.php");

require_once "../../classes/DBConnect.php";
require_once "../../classes/Constants.php";

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
AS teacherCourseUserId,eTeacherCourse.course_id AS teacherCourseCourseId FROM `egn_teacher_course` AS eTeacherCourse,`egn_course` AS eCourse,`egn_batch` 
AS eBatch,`egn_branch` AS eBranch WHERE eTeacherCourse.course_id = eCourse.id AND eCourse.batch_id = eBatch.id 
AND eBatch.branch_id = eBranch.id AND eTeacherCourse.user_id = '$teacherId'";

    } elseif ($teacherStatus == 'no' && $teacherId == 0 && $multiQuery == 'no' && $batchId == 0 && $courseId > 0
        && $batchName == null && $branchId == 0
    ) { //This will give course details in General
        $sql = "SELECT * FROM `egn_course` WHERE id = '$courseId'";
    } elseif ($teacherStatus == "no" && $teacherId > 0 && $multiQuery == 'no' && $batchId == 0 && $courseId == 0 && $batchName == null && $branchId == 0) { //This will give course details for Student
        $sql = "SELECT * FROM `egn_course_reg` AS cr, `egn_course` AS c WHERE cr.course_id = c.id 
AND student_id='$teacherId'";
    } elseif ($teacherStatus == "no" && $teacherId == 0 && $multiQuery == 'yes' && $batchId == 0 && $courseId == 0 && $batchName == null && $branchId == 0) {
        $sql = "SELECT eBranch.id AS branchId,eBranch.name AS branchName,eBatch.id AS batchId,eBatch.name 
AS batchName,eBatch.branch_id AS batchBranchId,eCourse.id AS courseId,eCourse.name AS courseName,eCourse.batch_id 
AS courseBatchId FROM `egn_course` AS eCourse,`egn_batch` AS eBatch,`egn_branch` AS eBranch 
WHERE eCourse.batch_id = eBatch.id AND eBatch.branch_id = eBranch.id";
    } elseif ($teacherStatus == "no" && $teacherId == 0 && $multiQuery == 'yes' && $batchId > 0 && $courseId == 0 && $batchName == null && $branchId == 0) {
        $sql = "SELECT eBranch.id AS branchId,eBranch.name AS branchName,eBatch.id AS batchId,eBatch.name 
AS batchName,eBatch.branch_id AS batchBranchId,eCourse.id AS courseId,eCourse.name AS courseName,eCourse.batch_id 
AS courseBatchId FROM `egn_course` AS eCourse,`egn_batch` AS eBatch,`egn_branch` AS eBranch 
WHERE eCourse.batch_id = eBatch.id AND eBatch.branch_id = eBranch.id AND eCourse.batch_id = '$batchId'";
    } elseif ($teacherStatus == "no" && $teacherId == 0 && $multiQuery == 'yes' && $batchId == 0 && $courseId == 0 && $batchName != null && $branchId == 0) {
        $sql = "SELECT eBranch.id AS branchId,eBranch.name AS branchName,eBatch.id AS batchId,eBatch.name 
AS batchName,eBatch.branch_id AS batchBranchId,eCourse.id AS courseId,eCourse.name AS courseName,eCourse.batch_id 
AS courseBatchId FROM `egn_course` AS eCourse,`egn_batch` AS eBatch,`egn_branch` AS eBranch 
WHERE eCourse.batch_id = eBatch.id AND eBatch.branch_id = eBranch.id AND eBatch.name = '$batchName'";
    } elseif ($teacherStatus == "no" && $teacherId > 0 && $multiQuery == 'yes' && $batchId > 0 && $courseId == 0 && $batchName == null && $branchId > 0) {
        $sql = "SELECT DISTINCT c.id,c.name 
                    FROM egn_batch as batch ,egn_course as c ,egn_users as u ,egn_role as r, egn_teacher_course as tc 
                    WHERE batch.branch_id = " . $branchId . " AND c.batch_id = batch.id AND tc.course_id=c.id AND tc.user_id=u.id AND u.id=" . $teacherId . " AND batch.id = " . $batchId . " AND u.role_id = r.id AND r.is_teacher=1
                    ORDER BY c.name";
    } else {
        // $sql = "SELECT * FROM `egn_course`";
        $sql = "SELECT eBranch.id AS branchId,eBranch.name AS branchName,eBatch.id AS batchId,eBatch.name 
AS batchName,eBatch.branch_id AS batchBranchId,eCourse.id AS courseId,eCourse.name AS courseName,eCourse.batch_id 
AS courseBatchId FROM `egn_course` AS eCourse,`egn_batch` AS eBatch,`egn_branch` AS eBranch 
WHERE eCourse.batch_id = eBatch.id AND eBatch.branch_id = eBranch.id";
    }
    $result = $connection->query($sql);
//        var_dump($result);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return false;
    }
}
function getStudentCourse($connection, $id)
{
    if ($id > 0) {
        $sql = "SELECT eCourseReg.id AS courseRegId,eCourseReg.student_id AS courseRegStudentId,eCourseReg.course_id AS courseRegCourseId,eCourse.id AS courseId,eCourse.name AS courseName,eCourse.batch_id AS courseBatchId FROM `egn_course_reg` AS eCourseReg,`egn_course` AS eCourse 
WHERE eCourseReg.course_id = eCourse.id AND eCourseReg.student_id = '" . $id . "'";
    } else {
        $sql = "SELECT * FROM `egn_course_reg`";
    }
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        return $result;
    } else {
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
}else{
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
<!DOCTYPE html>
<html lang="en">

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
        <?php
        $i = 0;
        foreach ($courses_id as &$id) {
            echo "<option value=".$id.">".$courses_name[$i]."</option>";
            $i++;
        }
        ?>
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
