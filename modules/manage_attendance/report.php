<?php
/**
 * Created by PhpStorm.
 * User: adityajthakker
 * Date: 10/12/17
 * Time: 1:02 PM
 */
require_once "../../classes/DBConnect.php";
require_once "../../classes/Constants.php";
$dbconnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
$connection = $dbconnect->getInstance();
session_start();
if (!isset($_SESSION["teacher_id"])) {
    //redirect
}
$teacher_id = $_SESSION["teacher_id"];
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
            exit();
        }
        ?>
    </p>
</div>

<form id="select_course" action="report.php" method="get">
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
    </select><label>(Default for All Courses)</label>
    <br/>
    <label>From Date:</label>
    <input id="from_date" name="from_date" type="date" value="null"><label>(Default for all)</label>
    <br/>
    <label>To Date:</label>
    <input id="to_date" name="to_date" type="date" value="null"><label>(Default for all)</label>
    <br/>
    <input type="submit" value="Apply" id="courses_apply_button"/><br/>
</form>

<div id="content">
    <h2>Report</h2>
    <table id="students_list">
        <?php



        //select all courses on this teacher
        $courses = array();
        if(!isset($_REQUEST["course_id"]) or $_REQUEST["course_id"] == "null"){
            $sql_teacher_courses = "select DISTINCT etc.course_id as course_id, ec.name as course_name from egn_course as ec, egn_teacher_course as etc, egn_users as eu where eu.id = etc.user_id and etc.course_id = ec.id and eu.id = " . $teacher_id;
        }else{
            $sql_teacher_courses = "select DISTINCT ec.id as course_id, ec.name as course_name from egn_course as ec where ec.id = " . $_REQUEST["course_id"];
        }
        $result_teacher_courses = $connection->query($sql_teacher_courses);

        if ($result_teacher_courses->num_rows > 0) {
            echo "<tr>";
            echo "<td>Name</td>";
            while ($row_courses = $result_teacher_courses->fetch_assoc()) {
                echo "<td>".$row_courses["course_name"]."</td>";
                $courses[] = $row_courses["course_id"];
            }
            echo "</tr>";
        }

        // Select all students enrolled in this course
        $sql_students_for_course = "select DISTINCT es.id as student_id, es.firstname, es.lastname from egn_student as es, egn_users as eu, egn_teacher_course as etc, egn_course as ec, egn_course_reg as ecr where ec.id = etc.course_id and eu.id = etc.user_id and ecr.student_id = es.id and ecr.course_id = ec.id and eu.id = " . $teacher_id;
        $result_students_for_course = $connection->query($sql_students_for_course);
        if ($result_students_for_course->num_rows > 0) {
            while ($row_students = $result_students_for_course->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row_students["firstname"]. " " .$row_students["lastname"]."</td>";
                foreach($courses as $id) {
                    //get the counts of attended and happened
                    if (isset($_REQUEST["from_date"], $_REQUEST["to_date"]) and $_REQUEST["from_date"] != "" and $_REQUEST["to_date"] != ""){
                        $sql_how_many_attended = "select count(aa.id) as count from (select ea.id from egn_student as es, egn_teacher_course as etc, egn_attendance as ea, egn_timetable as et, egn_course as ec, egn_student_attendance as esa where es.id = ".$row_students["student_id"]." and ec.id = ".$id." and esa.attendance_id = ea.id and es.id = esa.student_id and ea.date_of_attendance BETWEEN '".$_REQUEST["from_date"]."' and '".$_REQUEST["to_date"]."' GROUP by ea.id) as aa";
                        $sql_how_many_happened = "select count(aa.id) as count from (select ea.id from egn_student as es, egn_teacher_course as etc, egn_attendance as ea, egn_timetable as et, egn_course as ec, egn_student_attendance as esa where ec.id = ".$id." and esa.attendance_id = ea.id and es.id = esa.student_id and ea.date_of_attendance BETWEEN '".$_REQUEST["from_date"]."' and '".$_REQUEST["to_date"]."' GROUP by ea.id) as aa";
                    }else{
                        $sql_how_many_attended = "select count(aa.id) as count from (select ea.id from egn_student as es, egn_teacher_course as etc, egn_attendance as ea, egn_timetable as et, egn_course as ec, egn_student_attendance as esa where es.id = ".$row_students["student_id"]." and ec.id = ".$id." and esa.attendance_id = ea.id and es.id = esa.student_id GROUP by ea.id) as aa";
                        $sql_how_many_happened = "select count(aa.id) as count from (select ea.id from egn_student as es, egn_teacher_course as etc, egn_attendance as ea, egn_timetable as et, egn_course as ec, egn_student_attendance as esa where ec.id = ".$id." and esa.attendance_id = ea.id and es.id = esa.student_id GROUP by ea.id) as aa";
                    }

                    $result_attended = $connection->query($sql_how_many_attended);
                    $attended = $result_attended->fetch_assoc()["count"];
                    $result_happened = $connection->query($sql_how_many_happened);
                    $happened = $result_happened->fetch_assoc()["count"];
                    if (((int)$happened) == 0){
                        echo "<td> - </td>";
                    }else{
                        echo "<td>".(((int)$attended/(int)$happened)*100)."</td>";
                    }
                }
                echo "</tr>";

            }
        }



        ?>
    </table>
</div>

</body>
</html>
