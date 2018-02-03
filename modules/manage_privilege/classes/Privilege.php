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

        public function checkPrivilege($user_id,$privilege_id,$email,$role_id)
    {
        // $sql="SELECT role_id FROM egn_users WHERE id='$user_id'";
        // $result=$this->connection->query($sql);

        // //get the role id for the given user
        // if($result->num_rows == 0)
        // {
            //It means the user_id is either a student or a parent
            // $checkStudent="SELECT email,parent_email FROM egn_student WHERE id='$user_id'";
            // $checkStudentResult=$this->connection->query($checkStudent);

            // if($checkStudentResult->num_rows > 0)
            // {
            //     while($row=$checkStudentResult->fetch_assoc())
            //     {
            //         $student_email=$row['email'];
            //         $parent_email=$row['parent_email'];
            //     }

            //     if($email===$student_email)
            //     {
            //         $role_id=Constants::ROLE_STUDENT_ID;
            //     }

            //     else if($email===$parent_email)
            //     {
            //         $role_id=Constants::ROLE_PARENT_ID;
            //     }
            // }

    		if($role_id != Constants::ROLE_PARENT_ID && $role_id != Constants::ROLE_STUDENT_ID && $role_id != Constants::ROLE_TEACHER_ID)
    		{
				$sql="SELECT role_id FROM egn_users WHERE id='$user_id'";
                $result=$this->connection->query($sql);

                if($result->num_rows != 0)
                {
                	while($row=$result->fetch_assoc())
            		{
                    	$role_id=$row['role_id'];
                    }
                }
                else
                {
                    return Constants::NO_USER_ERR; 
                }    			
    		}

            // else
            // {
            //     $sql="SELECT role_id FROM egn_users WHERE id='$user_id'";
            //     $result=$this->connection->query($sql);

            //     if($result->num_rows != 0)
            //     {
            //         $role_id=$row['role_id'];
            //     }
            //     else
            //     {
            //         return Constants::NO_USER_ERR; 
            //     }
            // }
        // }

        // else
        // {
        //     while($row=$result->fetch_assoc())
        //     {
        //         $role_id=$row['role_id'];
        //     }
        // }

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