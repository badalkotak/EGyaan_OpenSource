<?php

require_once("../../../classes/Constants.php");

/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 10/6/17
 * Time: 5:11 PM
 */
class StudentCourseRegistration
{
    private $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getStudentCourse($id)
    {
        if ($id > 0) {
            $sql = "SELECT eCourseReg.id AS courseRegId,eCourseReg.student_id AS courseRegStudentId,eCourseReg.course_id AS courseRegCourseId,eCourse.id AS courseId,eCourse.name AS courseName,eCourse.batch_id AS courseBatchId FROM `egn_course_reg` AS eCourseReg,`egn_course` AS eCourse 
WHERE eCourseReg.course_id = eCourse.id AND eCourseReg.student_id = '" . $id . "'";
        } else {
            $sql = "SELECT * FROM `egn_course_reg`";
        }
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

// In case of multiple inserts, you need to check whether or not each insert query is being executed, if it is executed only then execute the next query, or else if a particular query is not executed, first delete all the previous RELATED INSERT queries and then return false.
    public function insertStudentCourse($studentId, $courseId)
    {
        $studentId = $this->connection->real_escape_string($studentId);
        $courseId = $this->connection->real_escape_string($courseId);

        $sql = "SELECT * FROM `egn_course_reg` WHERE student_id='$studentId' AND course_id='$courseId'";
        $result = $this->connection->query($sql);

        if ($result->num_rows == 0) {
            $insert_sql = "INSERT INTO `egn_course_reg`(`student_id`, `course_id`) 
VALUES ('$studentId','$courseId')";
            $insert = $this->connection->query($insert_sql);
            if ($insert === true) {
                return true;
            } else {
                return false;
            }
        } else {
            $message = Constants::STATUS_EXISTS;
            return $message;
        }
    }

    public function updateStudentCourse($id, $studentId, $courseId)
    {
        $studentId = $this->connection->real_escape_string($studentId);
        $courseId = $this->connection->real_escape_string($courseId);

//        $sql = "SELECT * FROM `egn_course_reg` WHERE student_id='$studentId' AND course_id='$courseId'";
//        $result = $this->connection->query($sql);
//
//        if ($result->num_rows == 0) {
            $sql = "UPDATE `egn_course_reg` SET `course_id`='$courseId' WHERE `id`='$id' AND `student_id`='$studentId'";
            $update = $this->connection->query($sql);

            if ($update === true) {
                return true;
            } else {
                return false;
            }
//        } else {
//            $message = Constants::STATUS_EXISTS;
//            return $message;
//        }
    }

    public function deleteStudentCourse($id)
    {
        $sql = "DELETE FROM `egn_course_reg` WHERE id='$id'";
        $delete = $this->connection->query($sql);

        if ($delete === true) {
            return true;
        } else {
            return false;
        }
    }
}