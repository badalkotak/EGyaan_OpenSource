<?php
include("../../Resources/sessions.php");
require_once("../../classes/Constants.php");

if($role_id==Constants::ROLE_STUDENT_ID)
{
	header('Location: function/manage_student_test.php');	
}
else
{
	header('Location: function/manage_test.php');	
}

?>