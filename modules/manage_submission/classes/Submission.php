<?php

class Submission
{

	private $connection;
	function __construct($connection)
	{
		$this->connection=$connection;
	}
	public function getSubmission()
	{
		$sql="select * from egn_submissions";
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
	public function insertSubmission($title,$file,$date_of_submission,$date_of_upload,$user_id,$course_id)
	{
		$sql_insert="INSERT INTO `egn_submissions`(`title`, `file`, `date_of_submission`, `date_of_upload`, `user_id`, `course_id`) VALUES ('".$title."','".$file."','".$date_of_submission."','".$date_of_upload."',".$user_id.",".$course_id.")";
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
	 public function deleteSubmission($id)
    {
        $sql="DELETE FROM egn_submissions WHERE id=".$id;
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
     public function updateSubmission($id,$title,$file,$date_of_submission,$date_of_upload,$course_id)
    {
        $sql="UPDATE `egn_submissions` SET `title`='".$title."',`file`='".$file."',`date_of_submission`='".$date_of_submission."',`date_of_upload`='".$date_of_upload."',`course_id`=".$course_id." WHERE `id`=".$id;
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