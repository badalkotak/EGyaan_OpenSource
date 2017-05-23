<?php

include("../../../classes/Constants.php");

class Course
{
	private $connection;

    function __construct($connection){
        $this->connection = $connection;
    }

    public function getCourse()
    {
    	$sql="SELECT * FROM egn_course";
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

// In case of multiple inserts, you need to check whether or not each insert query is being executed, if it is executed only then execute the next query, or else if a particular query is not executed, first delete all the previous RELATED INSERT queries and then return false.
    public function insertCourse($name,$batch_id)
    {
        $sql="SELECT * FROM `egn_course` WHERE name='$name' AND batch_id='$batch_id'";
        $result = $this->connection->query($sql);

        if($result->num_rows == 0)
        {
            $insert_sql="INSERT INTO `egn_course`(`name`,`batch_id`) VALUES ('$name','$batch_id')";
            $insert=$this->connection->query($insert_sql);
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

    public function updateCourse($id,$name,$batch_id)
    {
        $sql="UPDATE `egn_course` SET `name`='$name' AND `batch_id`='$batch_id' WHERE id='$id'";
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

    public function deleteCourse($id)
    {
        $sql="DELETE FROM egn_course WHERE id='$id'";
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