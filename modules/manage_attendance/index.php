<?php
include("../../Resources/sessions.php");
include("../../classes/Constants.php");

if($role_id==Constants::ROLE_TEACHER_ID){
    header("Location: function/manage_attendance1.php");

} else {
    echo Constants::NO_PRIVILEGE_MSG;
}
?>