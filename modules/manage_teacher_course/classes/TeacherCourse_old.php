<?php
require_once("../../../classes/Constants.php");

class TeacherCourse
{
	private $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getTeacherCourse($user_id)
    {
    	$sql="SELECT * FROM egn_teacher_course WHERE user_id='$user_id'";
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

    public function deleteTeacherCourse($id,$user_id)
    {
        if($user_id==0)
        {
            $sql="DELETE FROM `egn_teacher_course` WHERE `id`='$id'";            
        }
        else
        {
            $sql="DELETE FROM `egn_teacher_course` WHERE `user_id`='$user_id'";            
        }
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