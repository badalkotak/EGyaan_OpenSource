<?php

include("../../../classes/Constants.php");

class Course
{
    private $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getCourse($teacherStatus, $userId)
    {
        if ($teacherStatus == "yes" && $userId > 0) { //This will give course details for Teacher
            $sql = "SELECT tc.id,tc.user_id,tc.course_id,tc.addedby_user_id,c.id,c.name,c.batch_id FROM `egn_teacher_course` AS tc,`egn_course` AS c WHERE tc.course_id = c.id AND user_id = '$userId'";
        } elseif ($userId == 0) { //This will give course details in general
            $sql = "SELECT * FROM egn_course";
        } elseif ($teacherStatus == "no" && $userId > 0) { //This will give course details for Student
            $sql = "SELECT * FROM `egn_course_reg` AS cr, `egn_course` AS c WHERE cr.course_id = c.id AND student_id='$userId'";
        } else {
            return false;
        }
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            return null;
        }
    }

// In case of multiple inserts, you need to check whether or not each insert query is being executed, if it is executed only then execute the next query, or else if a particular query is not executed, first delete all the previous RELATED INSERT queries and then return false.
    public function insertCourse($name, $batch_id)
    {
        $sql = "SELECT * FROM `egn_course` WHERE name='$name' AND batch_id='$batch_id'";
        $result = $this->connection->query($sql);

        if ($result->num_rows == 0) {
            $insert_sql = "INSERT INTO `egn_course`(`name`,`batch_id`) VALUES ('$name','$batch_id')";
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

    public function updateCourse($id, $name, $batch_id)
    {
        $sql = "UPDATE `egn_course` SET `name`='$name' AND `batch_id`='$batch_id' WHERE id='$id'";
        $update = $this->connection->query($sql);

        if ($update === true) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteCourse($id)
    {
        $sql = "DELETE FROM egn_course WHERE id='$id'";
        $delete = $this->connection->query($sql);

        if ($delete === true) {
            return true;
        } else {
            return false;
        }
    }
}

?>