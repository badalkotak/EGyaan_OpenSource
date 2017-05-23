<?php

class TimeTimetable
{
	private $connection;
	function __construct($connection)
	{
		$this->connection=$connection;
	}
	public function getTimeTimetable()
	{
		$sql="select * from egn_time_timetable";
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
	public function insertTimeTimetable($from_time,$to_time,$type)
	{
		 $sql="SELECT * FROM `egn_time_timetable` WHERE from_time='".$from_time."' && to_time='".$to_time."'";
        $result = $this->connection->query($sql);

        if($result->num_rows == 0)
        {
			$sql_insert="INSERT INTO `egn_time_timetable`(`from_time`, `to_time`, `type`) VALUES ('".$from_time."','".$to_time."',".$type.")";
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
			 $message="Already Exists";
            return $message;
		}
	}
	 public function deleteTimeTimetable($id)
    {
        $sql="DELETE FROM egn_time_timetable WHERE id=".$id;
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
     public function updateTimeTimetable($id,$from_time,$to_time,$type)
    {
    	 $sql="SELECT * FROM `egn_time_timetable` WHERE from_time='".$from_time."' && to_time='".$to_time."'";
        $result = $this->connection->query($sql);

        if($result->num_rows == 0)
        {
    	 	$sql="UPDATE `egn_time_timetable` SET `from_time`='".$from_time."',`to_time`='".$to_time."',`type`=".$type." WHERE id=".$id;
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
		else
		{
			 $message="Already Exists";
            return $message;
		}
    }
}
?>