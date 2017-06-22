<?php
require_once("../../../classes/Constants.php");

class TeacherCourse
{
	private $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getTeacherCourse($user_id,$course_id,$id)
    {
        if($user_id > 0 && $course_id > 0 && $id==0)
        {
    	   $sql="SELECT * FROM egn_teacher_course WHERE user_id=$user_id && course_id=$course_id";
    	}
        else if($user_id == 0 && $course_id > 0 && $id==0)
        {
             $sql="SELECT user_id FROM `egn_teacher_course` WHERE `course_id`=".$course_id;
        }
        else if($user_id == 0 && $course_id > 0 && $id==0)
        {
            $sql="SELECT course_id FROM `egn_teacher_course` WHERE `user_id`=".$user_id;
        }
        else if($user_id == 0 && $course_id == 0 && $id > 0)
        {
            $sql="SELECT course_id FROM `egn_teacher_course` WHERE id=".$id;
        }
        else if($user_id > 0 && $course_id ==0 && $id==0)
        {
            $sql="SELECT * FROM egn_teacher_course WHERE user_id='$user_id'";
        }
        else
        {
            $sql="SELECT * FROM egn_teacher_course";
        }
        $result=$this->connection->query($sql);

    	if($result->num_rows > 0)
    	{
    		return $result;
    	}
    	else
    	{
    		return null;
    	}
    }

    public function insertTeacherCourse($user_id,$course_id)
    {
        $check="SELECT * FROM egn_teacher_course WHERE user_id='$user_id' && course_id='$course_id'";
        $check_result=$this->connection->query($check);

        if($check_result->num_rows > 0)
        {
            return Constants::STATUS_EXISTS;
        }
        else
        {

    	$sql="INSERT INTO `egn_teacher_course`(`user_id`, `course_id`) VALUES ('$user_id',$course_id)";
    	$insert=$this->connection->query($sql);

    	if($insert===true)
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }
    }

    public function deleteTeacherCourse($id)
    {
    	$sql="DELETE FROM `egn_teacher_course` WHERE `id`='$id'";
    	$delete=$this->connection->query($sql);

    	if($delete===true)
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }
}
?>