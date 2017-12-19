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
session_start();
$_SESSION["teacher_id"] = 3;
if (!isset($_SESSION["teacher_id"])) {
    //redirect
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mark Attendance</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <!-- <script type="text/javascript" src="js/main.js"></script> -->

</head>
<body>
<div id="message">
    <p>
        <?php
        if (isset($_REQUEST["status"], $_REQUEST["message"])) {
            echo $_REQUEST["message"];
        }
        ?>
    </p>
</div>
<form id="meta_info_form_courses" action="mark_attendance.php" method="get">
    <select class="form-control" id="course_id" name="course_id">
        <option value="null">Select Course</option>
        <?php
        // $sql = "select distinct c.id, c.name from egn_courses as c, egn_load as l where c.id = l.course_id and l.teacher_id = " . $_SESSION["teacher_id"];
        $sql = "select distinct c.id, c.name, eb.name as branch from egn_batch as ebatch, egn_branch as eb, egn_course as c, egn_teacher_course as etc  where etc.user_id = " . $_SESSION["teacher_id"] . " and etc.course_id = c.id and c.batch_id = ebatch.id and ebatch.branch_id = eb.id";
        $result = $connection->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if(isset($_REQUEST["course_id"])){
                    $selected = $_REQUEST["course_id"] == $row["id"] ? "selected" : "";
                }else{
                    $selected = "";
                }
                echo "<option value='" . $row["id"] . "' " . $selected . ">" . $row["branch"] . " - " . $row["name"] . "</option>";
            }
        }
        ?>
    </select>
    <input type="submit" value="Apply" id="courses_apply_button"/><br/>
</form>

<form id="meta_info_form_timetable" action="mark_attendance.php" method="get">
    <input type="hidden" name="course_id"
           value="<?php echo isset($_REQUEST["course_id"]) ? $_REQUEST["course_id"] : "null" ?>"/>
    <select class="form-control" id="timetable_id" name="timetable_id">
        <option value="null">Select Timetable Slot</option>
        <?php
        $sql = "select t.id, t.day_id, ett.from_time, ett.to_time, t.comment from egn_time_timetable as ett, egn_timetable as t, egn_teacher_course as etc where etc.course_id = ".$_REQUEST["course_id"]." and etc.user_id = ".$_SESSION["teacher_id"]." and etc.id = t.teacher_course_id and ett.id = t.time_id";
        $result = $connection->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if(isset($_REQUEST["timetable_id"])){
                    $selected = $_REQUEST["timetable_id"] == $row["id"] ? "selected" : "";
                }else{
                    $selected = "";
                }
                echo "<option value='" . $row["id"] . "' " . $selected . "> Day " . $row["day_id"] . " : " . $row["from_time"] . " - " . $row["to_time"] . " : (" . $row["comment"]. ")</option>";
            }
        }
        ?>
    </select><br/>
    <label>Date: </label>
    <?php
        $date = isset($_REQUEST['date'])?$_REQUEST['date']:'';
    ?>

    <input type="date" name="date" value="<?php echo $date ?>">
    <input type="submit" value="Apply" id="meta_info_form_button"/>
</form>


<div id="content">
    <?php if (isset($_REQUEST["course_id"], $_REQUEST["date"], $_REQUEST["timetable_id"])): ?>
        <form id="attendance_marking_form" action="functions/attendanceMarking.php" method="post">
            <input type="hidden" name="timetable_id"
                   value="<?php echo isset($_REQUEST["timetable_id"]) ? $_REQUEST["timetable_id"] : "null" ?>"/>
            <input type="hidden" name="date"
                   value="<?php echo isset($_REQUEST["date"]) ? $_REQUEST["date"] : "null" ?>"/>
            <table id="attendance_list">
                <?php
                $sql = "select distinct s.id, s.firstname, s.lastname from egn_student as s , egn_course_reg as ecr where s.id = ecr.student_id and ecr.course_id = " . $_REQUEST["course_id"];
                $result = $connection->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["firstname"] . " " . $row["lastname"] . "</td><td><input type='checkbox' name='attendees[]' id='attendees' value='" . $row['id'] . "'/></td></tr>";
                    }
                }
                ?>
            </table>
            <input type="submit" value="Mark Attendance" id="attendance_marking_form_submit"/>
        </form>
    <?php endif; ?>
</div>
</body>
</html>