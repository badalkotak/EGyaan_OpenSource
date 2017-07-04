<?php
/**
 * Created by PhpStorm.
 * User: akash
 * Date: 4/7/17
 * Time: 12:25 AM
 */
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
if(isset($_REQUEST['attendanceId']) && count($_REQUEST['attendees'])>0){
    $attendanceId=$_REQUEST['attendanceId'];
    $attendees=$_REQUEST['attendees'];
    $result=$attendance->removeAttendees($attendanceId);
    if($result==true){
        $updateResult = $attendance->markAttendees($attendees,$attendanceId);
        echo "Attendance ".$updateResult;
    } else {
        echo "update failed";
    }
} else {
    echo "remove failed";
}
?>