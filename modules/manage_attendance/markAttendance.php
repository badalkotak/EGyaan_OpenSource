<?php
/**
 * Created by PhpStorm.
 * User: adityajthakker
 * Date: 28/12/16
 * Time: 11:45 AM
 */
require_once "classes/DBConnect.php";
session_start();
$_SESSION["teacher_id"] = 2;
if (!isset($_SESSION["teacher_id"])) {
    //redirect
}
$db = new DBConnect();
$connection = $db->getInstance();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mark Attendance</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>

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
<form id="meta_info_form_courses" action="markAttendance.php" method="get">
    <select class="form-control" id="course_id" name="course_id">
        <option value="null">Select Course</option>
        <?php
        $sql = "select distinct c.id, c.name from egn_courses as c, egn_load as l where c.id = l.course_id and l.teacher_id = " . $_SESSION["teacher_id"];
        $result = $connection->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if(isset($_REQUEST["course_id"])){
                    $selected = $_REQUEST["course_id"] == $row["id"] ? "selected" : "";
                }else{
                    $selected = "";
                }
                echo "<option value='" . $row["id"] . "' " . $selected . ">" . $row["name"] . "</option>";
            }
        }
        ?>
    </select>
    <input type="submit" value="Apply" id="courses_apply_button"/><br/>
</form>

<form id="meta_info_form_topics" action="markAttendance.php" method="get">
    <input type="hidden" name="course_id"
           value="<?php echo isset($_REQUEST["course_id"]) ? $_REQUEST["course_id"] : "null" ?>"/>
    <select class="form-control" id="topic_id" name="topic_id">
        <option value="null">Select Topic</option>
        <?php
        if(isset($_REQUEST["course_id"])){
            $sql = "select distinct id, name from egn_topics where course_id = " . $_REQUEST["course_id"];
            $result = $connection->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if(isset($_REQUEST["topic_id"])){
                        $selected = $_REQUEST["topic_id"] == $row["id"] ? "selected" : "";
                    }else{
                        $selected = "";
                    }
                    echo "<option value='" . $row["id"] . "' " . $selected . ">" . $row["name"] . "</option>";
                }
            }
        }
        ?>
    </select>
    <input type="submit" value="Apply" id="topic_apply_button"/><br/>
</form>

<form id="meta_info_form_timetable" action="markAttendance.php" method="get">
    <input type="hidden" name="course_id"
           value="<?php echo isset($_REQUEST["course_id"]) ? $_REQUEST["course_id"] : "null" ?>"/>
    <input type="hidden" name="topic_id"
           value="<?php echo isset($_REQUEST["topic_id"]) ? $_REQUEST["topic_id"] : "null" ?>"/>
    <select class="form-control" id="timetable_id" name="timetable_id">
        <option value="null">Select Timetable Slot</option>
        <?php
        $sql = "select distinct id, load_id from egn_timetable where day_id = " . "1";
        $result = $connection->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if(isset($_REQUEST["timetable_id"])){
                    $selected = $_REQUEST["timetable_id"] == $row["id"] ? "selected" : "";
                }else{
                    $selected = "";
                }
                echo "<option value='" . $row["id"] . "' " . $selected . ">" . $row["load_id"] . "</option>";
            }
        }
        ?>
    </select><br/>
    <label for="isTopicCompleted">Is Topic Completed :</label>
    <input type="checkbox" name="isTopicCompleted" id="isTopicCompleted" <?php echo (isset($_REQUEST["isTopicCompleted"]) && $_REQUEST["isTopicCompleted"] == "on")?"checked":""; ?>/><br/>

    <input type="submit" value="Apply" id="meta_info_form_button"/>
</form>


<div id="content">
    <?php if (isset($_REQUEST["course_id"], $_REQUEST["topic_id"], $_REQUEST["timetable_id"])): ?>
        <form id="attendance_marking_form" action="functions/attendanceMarking.php" method="post">
            <input type="hidden" name="topic_id"
                   value="<?php echo isset($_REQUEST["topic_id"]) ? $_REQUEST["topic_id"] : "null" ?>"/>
            <input type="hidden" name="timetable_id"
                   value="<?php echo isset($_REQUEST["timetable_id"]) ? $_REQUEST["timetable_id"] : "null" ?>"/>
            <input type="hidden" name="isTopicCompleted"
                   value="<?php echo isset($_REQUEST["isTopicCompleted"]) ? $_REQUEST["isTopicCompleted"] : "null" ?>"/>

            <table id="attendance_list">
                <?php
                $sql = "select distinct id, student_fullname from egn_students";
                $result = $connection->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["student_fullname"] . "</td><td><input type='checkbox' name='attendees[]' id='attendees' value='" . $row['id'] . "'/></td></tr>";
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