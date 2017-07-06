<?php
require_once("../../../classes/Constants.php");
require_once("../../notifications/classes/Notifications.php");

class Timetable
{
	private $connection;
	function __construct($connection)
	{
		$this->connection=$connection;
	}
	public function getTimetable($teacher_id,$batch_id,$day_id,$time_id)
	{
		if($teacher_id ==0 && $batch_id == 0 && $day_id > 0 && $time_id > 0)
		{
			$sql="SELECT * FROM `egn_timetable` WHERE `day_id`=$day_id && `time_id`=$time_id";
		}
		if($teacher_id > 0 && $batch_id > 0 && $day_id > 0 && $time_id > 0)
		{
			//$sql="SELECT * FROM `egn_timetable` WHERE `day_id`=$day_id && `time_id`=$time_id && teacher_course_id=".$teacher_id;
			  $sql="select br.name as branch,ba.name as batch from egn_branch br,egn_batch ba,egn_course c where br.id=ba.branch_id && ba.id=c.batch_id && ba.id<>$batch_id && c.id IN (select course_id from egn_teacher_course where id=(select teacher_course_id from egn_timetable where day_id=$day_id && time_id=$time_id)) ";
		}
		else
		{
		 $sql="SELECT * FROM egn_timetable WHERE day_id='$day_id' AND time_id='$time_id' AND teacher_course_id IN (SELECT id FROM egn_teacher_course WHERE course_id IN (SELECT id FROM egn_course WHERE batch_id='$batch_id'))";
		}	
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
	public function insertTimetable($day_id,$time_id,$teacher_course_id,$comment)
	{
		$sql="SELECT * FROM `egn_timetable` WHERE time_id=".$time_id." && day_id=".$day_id." && teacher_course_id=".$teacher_course_id;
        $result = $this->connection->query($sql);

        if($result->num_rows == 0)
        {
			 $sql_insert="INSERT INTO `egn_timetable`(`day_id`, `time_id`, `teacher_course_id`,`comment`) VALUES (".$day_id.",".$time_id.",".$teacher_course_id.",'".$comment."')";
			$insert=$this->connection->query($sql_insert);
			if($insert === true)
			{
				$notifications = new Notifications();
				$notifications->sendNotif("eJ1wQ5hDZwU:APA91bHEQv7Ultk3qSXHyDpcB6oFgraGzC37oYWXr36GO8EgjzXo7D4tDDwrwy-sW6OGJOkFH60nvEphoIhYQ4O5KijQ3Znlc_edYTbaV19_7xTf_wYsTdRoFwJybnejB-J9hZ8AMUIm","Timetable","There is a change in your Timetable!");
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