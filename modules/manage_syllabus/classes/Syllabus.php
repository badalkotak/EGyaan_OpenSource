<?php

class Syllabus
{

	private $connection;
	function __construct($connection)
	{
		$this->connection=$connection;
	}
	public function getSyllabus()
	{
		$sql="select * from egn_syllabus";
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
	public function insertSyllabus($course_id,$file,$user_id)
	{
		 $sql="SELECT * FROM `egn_syllabus` WHERE course_id=".$course_id;
        $result = $this->connection->query($sql);

        if($result->num_rows == 0)
        {
			$sql_insert="INSERT INTO `egn_syllabus`(`course_id`, `file`, `user_id`) VALUES (".$course_id.",'".$file."',".$user_id.")";
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
	 public function deleteSyllabus($id)
    {
        $sql="DELETE FROM egn_syllabus WHERE id=".$id;
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
     public function updateSyllabus($id,$course_id,$file)
    {
    	 $sql="SELECT * FROM `egn_syllabus` WHERE course_id=".$course_id;
        $result = $this->connection->query($sql);

        if($result->num_rows == 0)
        {
	        $sql="UPDATE `egn_syllabus` SET `course_id`=".$course_id.",`file`='".$file."' WHERE `id`=".$id;
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