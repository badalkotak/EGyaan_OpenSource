<?php
include("../../Resources/sessions.php");
include("../../classes/Constants.php");

//if($role_id==Constants::ROLE_TEACHER_ID){
//    header("Location: function/manage_attendance1.php");
//} else {
//    echo Constants::NO_PRIVILEGE_MSG;
//}
?>
<html>
<body>
<button><a href="function/manage_attendance1.php">Mark Attendance</a></button>
<button><a href="function/edit_attendance1.php">Edit</a></button>
<button><a href="function/view_attendance.php">View</a></button>
</body>
</html>
