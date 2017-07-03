<?php
require_once "../../../classes/Constants.php";

/**
 * Created by PhpStorm.
 * User: akash
 * Date: 3/7/17
 * Time: 11:18 AM
 */
class Attendance
{
    private $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    function getTimetable($batchId, $userId)
    {
        $sql = "select DISTINCT timetable.id as timetableId, timetable.day_id, course.name as courseName, users.name as userName
from egn_teacher_course as teacherCourse, egn_timetable as timetable, egn_course as course, egn_users as users
where course.batch_id=$batchId AND teacherCourse.course_id = course.id AND timetable.teacher_course_id = teacherCourse.id AND users.id = teacherCourse.user_id AND users.id = $userId";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            $allSql = "select DISTINCT timetable.id as timetableId, timetable.day_id, course.name as courseName, users.name as userName
from egn_teacher_course as teacherCourse, egn_timetable as timetable, egn_course as course, egn_users as users
where course.batch_id=$batchId AND teacherCourse.course_id = course.id AND timetable.teacher_course_id = teacherCourse.id AND users.id = teacherCourse.user_id";
            $allResult = $this->connection->query($allSql);
            if ($allResult->num_rows > 0) {
                return $allResult;
            } else {
                return null;
            }
        }
    }

    function markAttendance($date, $timetableId)
    {
        $checkSql = "SELECT * FROM egn_attendance WHERE date_of_attendance='" . $date . "' AND timetable_id = '" . $timetableId . "'";
        $checkResult = $this->connection->query($checkSql);
        if ($checkResult->num_rows > 0) {
            return Constants::INSERT_ALREADY_EXIST_MSG;
        } else {
            $addAttendanceSql = "INSERT INTO `egn_attendance`(`date_of_attendance`, `timetable_id`) VALUES ('" . $date . "','" . $timetableId . "')";
            $addAttendanceResult = $this->connection->query($addAttendanceSql);
            if ($addAttendanceResult == true) {
                $attendanceId = $this->connection->insert_id;
                return $attendanceId;
            } else {
                return false;
            }
        }
    }

    function markAttendees($attendees, $attendanceId)
    {
        if (count($attendees) > 0) {
            $id = $attendanceId;
            $values = "";
            for ($i = 0; $i < count($attendees); $i++) {
                if ($i == (count($attendees) - 1)) {
                    $values = $values . "( " . $id . ", " . $attendees[$i] . " )";
                } else {
                    $values = $values . "( " . $id . ", " . $attendees[$i] . " ),";
                }
            }
            $sql = "insert into egn_student_attendance(attendance_id,student_id) values " . $values;
            $result = $this->connection->query($sql);
            if ($result == true) {
                return Constants::INSERT_SUCCESS_MSG;
            } else {
                return Constants::INSERT_SUCCESS_MSG;
            }
        } else {
            return "not Selected.";
        }
    }
}
