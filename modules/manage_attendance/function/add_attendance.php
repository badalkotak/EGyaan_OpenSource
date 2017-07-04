<?php
include("../../../Resources/sessions.php");
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Attendance.php");
require_once("../../manage_student/classes/Student.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
$student = new Student($dbConnect->getInstance());
$attendance = new Attendance($dbConnect->getInstance());
//$date = date("Y-m-d", strtotime($_REQUEST['date']));
//$rawdate = htmlentities($_REQUEST['date']);
//$date = date('Y-m-d', strtotime($rawdate));
$result=$attendance->markAttendance($_REQUEST['date'], $_REQUEST['timetableId']);
$attendees=$_REQUEST['attendees'];
if($result > 0){
    $mapResult=$attendance->markAttendees($attendees,$result);
    if($mapResult==true){
        echo "Attendance ".Constants::INSERT_SUCCESS_MSG;
    } else {
        echo "Attendance ".Constants::INSERT_FAIL_MSG;
    }
} else {
    echo "Attendance ".Constants::INSERT_ALREADY_EXIST_MSG;
}
?>