<?php
require_once("../../../classes/Constants.php");

class Privilege 
{
private $connection;
function __construct($connection)
	{
        $this->connection = $connection;
    }
    public function getPrivilege($role_id,$privilege_id)
    	{
            if($role_id==0 && $privilege_id==0)
            {
    		    $sql = "select * from egn_privilege WHERE admin_level='N'";
            }
            else if($role_id!=0 && $privilege_id==0)
            {
                $sql = "select * from egn_role_privilege WHERE role_id='$role_id'";
            }
            else if($privilege_id!=0 && $role_id==0)
            {
                $sql = "select * from egn_role_privilege WHERE privilege_id='$privilege_id'";
            }
            else
            {
                $sql = "select * from egn_role_privilege WHERE role_id='$role_id' and privilege_id='$privilege_id'";
            }

    		$result= $this->connection->query($sql);
    		if($result->num_rows > 0)
    		{
    			return $result;

    		}
    		else
    		{
    			return null;
    		}
        }

        public function getDashboardPrivilege($role_id)
        {
            $sql = "SELECT DISTINCT(dashboard_name),folder FROM `egn_privilege` WHERE id IN (Select privilege_id FROM egn_role_privilege WHERE role_id=$role_id)";

            $result= $this->connection->query($sql);
            if($result->num_rows > 0)
            {
                return $result;

            }
            else
            {
                return null;
            }
        }

        // else
        // {
        //     $sql = "select * from egn_role_privilege WHERE role_id='$role_id' and privilege_id='$privilege_id'";
        //     $result= $this->connection->query($sql);
        //     if($result->num_rows > 0)
        //     {
        //         return $result;
        //     }
        //     else
        //     {
        //         return null;
        //     }
        // }
    	// }

        public function deleteRolePrivilege($role_id)
        {
            $delete_role_privilege="DELETE FROM `egn_role_privilege` WHERE `role_id`='$role_id'";
            $delete=$this->connection->query($delete_role_privilege);

            if($delete)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function getPrivilegeRole($role_id)
        {
            
            $sql = "select * from egn_role_privilege WHERE role_id='$role_id'";
            $result= $this->connection->query($sql);
            if($result->num_rows > 0)
            {
                return $result;

            }
            else
            {
                return null;
            }
        }
}

?>