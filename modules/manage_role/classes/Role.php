<?php

require_once("../../../classes/Constants.php");

class Role
{
    private $connection;
    function __construct($connection){
        $this->connection=$connection;
    }

    public function getRole()
    {
        $sql="SELECT * FROM egn_role";
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

	public function insertRole($name,$is_teacher)
    {
    
        $sql = "SELECT * FROM `egn_role` WHERE name='$name'";
        $result = $this->connection->query($sql);

        if ($result->num_rows == 0) {
            $insert_sql = "INSERT INTO `egn_role`(`name`,`is_teacher`) VALUES ('$name','$is_teacher')";
            $insert = $this->connection->query($insert_sql);
            if ($insert === true) {
                return true;
            } else {
                return false;
            }
        } else {
            $message = Constants::STATUS_EXISTS;
            return $message;
        }
    }
public function updateRole($id,$name)
    {
        $sql = "UPDATE `egn_role` SET `name`='$name' WHERE id='$id'";
        $update = $this->connection->query($sql);

        if ($update === true) {
            return true;
        } else {
            return false;
        }
    }
     public function deleteRole($id)
    {
        $sql = "DELETE FROM egn_role WHERE id='$id'";
        $delete = $this->connection->query($sql);

        if ($delete === true) {
            return true;
        } else {
            return false;
        }
    }

    public function assignPrivilegeRole($role_id,$privilege_id)
    {
        $sql="INSERT INTO `egn_role_privilege`(`role_id`, `privilege_id`) VALUES ('$role_id','$privilege_id')";
        $insert=$this->connection->query($sql);

        if($insert)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}