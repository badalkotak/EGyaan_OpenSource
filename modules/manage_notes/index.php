<?php
include("../../Resources/sessions.php");
require_once("../../classes/Constants.php");

if($role_id==Constants::ROLE_STUDENT_ID)
{
	header('Location: function/student_view_notes.php');	
}
else
{
	header('Location: function/insert_page.php');	
}

?>