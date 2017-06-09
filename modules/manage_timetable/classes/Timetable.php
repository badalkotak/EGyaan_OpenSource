<?php
require_once("../../../classes/Constants.php");
class Timetable
{
	private $connection;
	function __construct($connection)
	{
		$this->connection=$connection;
	}
	public function getTimetable($batch_id)
	{
		$sql="SELECT * FROM egn_timetable WHERE teacher_course_id IN (SELECT id FROM egn_teacher_course WHERE course_id IN (SELECT id FROM egn_course WHERE batch_id='$batch_id'))";

		// $sql="select * from egn_timetable";
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
	public function insertTimetable($day_id,$time_id,$teacher_course_id)
	{
		 $sql="SELECT * FROM `egn_timetable` WHERE time_id=".$time_id." && day_id=".$day;
        $result = $this->connection->query($sql);

        if($result->num_rows == 0)
        {
			$sql_insert="INSERT INTO `egn_timetable`(`day_id`, `time_id`, `teacher_course_id`) VALUES (".$day_id.",".$time_id.",".$teacher_course_id.")";
			$insert=$this->connection->query($sql_insert);
			if($insert === true)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			$message=Constants::STATUS_EXISTS;
            return $message;
		}
	}
	 public function deleteTimetable($id)
    {
        $sql="DELETE FROM egn_timetable WHERE id=".$id;
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
     public function updateTimetable($id,$day_id,$time_id,$teacher_course_id)
    {
    	 	$sql="UPDATE `egn_timetable` SET `day_id`=".$day_id.",`time_id`=".$time_id.",`teacher_course_id`=".$teacher_course_id." WHERE `id`=".$id;
	        $update=$this->connection->query($sql);

	        if($update===true)
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