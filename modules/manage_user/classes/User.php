<?php

require_once("../../../classes/Constants.php");

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

    public function insertUser($email,$passwd,$role_id,$gender,$mobile,$name)
    {
        $sql="SELECT * FROM `egn_users` WHERE email='$email'";
        $result = $this->connection->query($sql);

        if($result->num_rows == 0)
        {
            $insert_sql="INSERT INTO `egn_users`(`email`,`passwd`,`role_id`,`gender`,`mobile`,`name`) VALUES ('$email','$passwd','$role_id','$gender','$mobile','$name')";
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

    public function getUserId($email)
    {
        $sql="SELECT id FROM egn_users WHERE email='$email'";
        $result=$this->connection->query($sql);

        if($result->num_rows > 0)
        {
            while($row=$result->fetch_assoc())
            {
                $id=$row['id'];
            }

            return $id;
        }
        else
        {
            $getStudentId="SELECT id FROM egn_student WHERE email='$email' OR parent_email='$email'";
            $getStudentIdResult=$this->connection->query($getStudentId);

            if($getStudentIdResult->num_rows === 0)
            {
                return Constants::NO_USER_ERR;
            }

            else
            {
                while($studentRow=$getStudentIdResult->fetch_assoc())
                {
                    $id=$studentRow['id'];
                }

                return $id;
            }
        }
    }

    public function checkPrivilege($user_id,$privilege_id,$email)
    {
        $sql="SELECT role_id FROM egn_users WHERE id='$user_id'";
        $result=$this->connection->query($sql);

        //get the role id for the given user
        if($result->num_rows == 0)
        {
            //It means the user_id is either a student or a parent
            $checkStudent="SELECT email,parent_email FROM egn_student WHERE id='$user_id'";
            $checkStudentResult=$this->connection->query($checkStudent);

            if($checkStudentResult->num_rows > 0)
            {
                while($row=$checkStudentResult->fetch_assoc())
                {
                    $student_email=$row['email'];
                    $parent_email=$row['parent_email'];
                }

                if($email===$student_email)
                {
                    $role_id=Constants::ROLE_STUDENT_ID;
                }

                else if($email===$parent_email)
                {
                    $role_id=Constants::ROLE_PARENT_ID;
                }
            }

            else
            {
                return Constants::NO_USER_ERR; 
            }
        }

        else
        {
            while($row=$result->fetch_assoc())
            {
                $role_id=$row['role_id'];
            }
        }

        //Now check if the privilege is permitted to the above role_id
        $checkPrivilege="SELECT id FROM egn_role_privilege WHERE role_id='$role_id' AND privilege_id='$privilege_id'";
        $checkPrivilegeResult=$this->connection->query($checkPrivilege);

        if($checkPrivilegeResult->num_rows === 0)
        {
            return false;
        }

        else
        {
            return true;
        }
    }
}
?>