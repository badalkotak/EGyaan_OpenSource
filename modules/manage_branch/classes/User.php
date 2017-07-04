<?php

include("../../../classes/Constants.php");

class User
{
	private $connection;

    function __construct($connection){
        $this->connection = $connection;
    }

    public function getUser()
    {
    	$sql="SELECT * FROM egn_users";
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
    public function insertUser($email,$passwd,$role_id,$gender,$mobile,$name)
    {
        $sql="SELECT * FROM `egn_users` WHERE email='$email'";
        $result = $this->connection->query($sql);
        $user_id=$result['id'];
        if($result->num_rows == 0)
        {
            $insert_sql="INSERT INTO `egn_users`(`email','passwd',role_id,'gender',mobile,'name`) VALUES ('$email','$passwd',$role_id,'$gender',$mobile,'$name')";
            $insert=$this->connection->query($insert_sql);
            if($insert === true)
            {
                $sql1="insert into 'egn_user_role'($user_id,$role_id)";
                $insert_result = $this->connection->query($sql1);
                if($insert_result === true)
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
                return false;
            }
        }
        else
        {
            $message=Constants::STATUS_EXISTS;
            return $message;
        }
    }

    public function updateUser($id,$email,$passwd,$role_id,$gender,$mobile,$name)
    {
        $sql="UPDATE `egn_users` SET `email`='$email',`passwd`='$passwd',`role_id`='$role_id',`gender`='$gender',`mobile`='$mobile',`name`='$name' WHERE id='$id'";
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

    public function deleteUser($id)
    {
        $sql="DELETE FROM egn_users WHERE id='$id'";
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