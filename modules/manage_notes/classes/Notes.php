<?php

class Notes
{

	private $connection;
	 function __construct($connection){
        $this->connection = $connection;
    }

	public function getNotes($course_id)
	{
		$sql="select * from egn_notes WHERE $course_id='".$course_id."'";
		$result = $this->connection->query($sql);
		if($result->num_rows > 0)
		{
			return $result;
		}
		else
		{
			return null;
		}
	}
	public function insertNotes($title,$file,$course_id,$downloadable,$user_id)
	{
		
		 $sql_insert="INSERT INTO `egn_notes`(`title`, `file`, `course_id`, `downloadable`, `user_id`) VALUES ('".$title."','".$file."',".$course_id.",'".$downloadable."',".$user_id.")";

		$insert = $this->connection->query($sql_insert);
		if($insert === true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	 public function deleteNotes($id)
    {
        $sql="DELETE FROM egn_notes WHERE id=".$id;
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
     public function updateNotes($id,$title,$file,$course_id,$downloadable)
    {
         $sql="UPDATE `egn_notes` SET `title`='".$title."',`file`='".$file."',`course_id`=".$course_id.",`downloadable`='".$downloadable."' WHERE `id`=".$id;
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