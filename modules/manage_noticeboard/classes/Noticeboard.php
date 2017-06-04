<?php

include("../../../classes/Constants.php");

class Noticeboard
{
	private $connection;

    function __construct($connection){
        $this->connection = $connection;
    }

    public function getNoticeboard()
    {
    	$sql="SELECT * FROM egn_noticeboard";
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
    public function insertNoticeboard($title,$notice,$file,$urgent_notice,$type,$user_id)
    {
            $insert_sql="INSERT INTO `egn_noticeboard`( `title`, `notice`, `file`, `urgent_notice`, `type`, `user_id`) VALUES ('$title','$notice','$file','$urgent_notice','$type','$user_id')";
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

    public function updateNoticeboard($id,$title,$notice,$file,$urgent_notice,$type,$user_id)
    {
        $sql="UPDATE `egn_noticeboard` SET `title`='$title' ,`notice`='$notice',`file`='$file',`urgent_notice`='$urgent_notice',`type`='$type',`user_id`='$user_id' WHERE id='$id'";
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

    public function deleteNoticeboard($id)
    {
        $sql="DELETE FROM egn_noticeboard WHERE id='$id'";
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