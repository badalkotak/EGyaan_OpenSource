<?php

require_once("../../../classes/Constants.php");

class Login
{
	private $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function checkLogin($email,$passwd)
    {
    	$sql="SELECT passwd,role_id FROM egn_users WHERE email='$email'";
    	$result = $this->connection->query($sql);

    	if($result->num_rows > 0)
    	{
    		while($row=$result->fetch_assoc())
    		{
    			$pass=$row['passwd'];
    			$role_id=$row['role_id'];
    		}

    		if($passwd===$pass)
    		{
    			return $role_id;
    		}
    		else
    		{
    			return null;
    		}
    	}

    	else
    	{
    		$sql="SELECT student_passwd FROM egn_student WHERE email='$email'";
    		$result=$this->connection->query($sql);

    		if($result->num_rows > 0)
    		{
    			while($row=$result->fetch_assoc())
    			{
    				$student_passwd=$row['student_passwd'];
    			}

    			if($student_passwd===$passwd)
    			{
    				return Constants::ROLE_STUDENT_ID;
    			}
    			else
    			{
    				return null;
    			}
    		}

    		else
    		{
    			$sql="SELECT parent_passwd FROM egn_student WHERE parent_email='$email'";
    			$result=$this->connection->query($sql);

    			if($result->num_rows > 0)
    			{
    				while($row=$result->fetch_assoc())
    				{
    					$parent_passwd=$row['parent_passwd'];
    				}

    				if($parent_passwd===$passwd)
    				{
    					return Constants::ROLE_PARENT_ID;
    				}

    				else
    				{
    					return null;
    				}
    			}

    			else
    			{
    				return null;
    			}
    		}
    	}
    }

    public function createSession($email,$id,$role_id)
    {
    	session_start();
    	$_SESSION['id']=$id;
    	$_SESSION['email']=$email;
    	$_SESSION['role']=$role_id;
    }
}
?>
