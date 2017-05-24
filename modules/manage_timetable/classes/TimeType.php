<?php
require_once("../../../classes/Constants.php");
class TimeType
{
	private $connection;
	function __construct($connection)
	{
		$this->connection=$connection;
	}
	public function getTimeType()
	{
		$sql="select * from egn_time_type";
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
	public function insertTimeType($name)
	{
		$sql="SELECT * FROM `egn_time_type` WHERE name='".$name."'";
        $result = $this->connection->query($sql);

        if($result->num_rows == 0)
        {
			$sql_insert="INSERT INTO `egn_time_type`(`name`) VALUES ('".$name."')";
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
	 public function deleteTimeType($id)
    {
        $sql="DELETE FROM egn_time_type WHERE id=".$id;
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
     public function updateTimeType($id,$name)
    {
    	 $sql="SELECT * FROM `egn_time_type` WHERE name='".$name."'";
        $result = $this->connection->query($sql);

        if($result->num_rows == 0)
        {
    	 	$sql="UPDATE `egn_time_type` SET `name`='".$name."' WHERE `id`=".$id;
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
			 $message=Constants::STATUS_EXISTS;
            return $message;
		}
    }
}
?>