<?php
/**
 * Created by PhpStorm.
 * User: adityajthakker
 * Date: 28/12/16
 * Time: 6:00 PM
 */
require_once "../classes/Attendance.php";
require_once "../../../classes/DBConnect.php";
require_once "../../../classes/Constants.php";
$dbconnect = new DBConnect(Constants::SERVER_NAME,
                           Constants::DB_USERNAME,
                           Constants::DB_PASSWORD,
                           Constants::DB_NAME);
$connection = $dbconnect->getInstance();

function output($status, $message = null){
    // echo $json?"true":"false". "    ". $message . "   " .$status;
    if (isset($_REQUEST["output"])) {
        header("Content-Type: application/json");
        $json = array();
        $json["status"] = $status;
        $json["message"] = $message;
        echo json_encode($json);
    } else {
        $url = "Location: mark_attendance.php?status=" . $status;
        $url = $url . "&message=" . $message;
        header($url);
    }
    exit();
}

if(isset($_REQUEST["date"], $_REQUEST["timetable_id"], $_REQUEST["attendees"])){
    $attendance = new Attendance($connection);

    if($_REQUEST["date"] == null || $_REQUEST["timetable_id"] == null ){
        output(Constants::STATUS_FAILED, "You have not selected Course or Date or Timetable Slot");
    }

    if($attendance->markAttendance(
        $connection->real_escape_string(trim($_REQUEST["date"])),
        $connection->real_escape_string(trim($_REQUEST["timetable_id"])),
        $_REQUEST["attendees"]
    )){
        output(Constants::STATUS_SUCCESS, "You have successfully marked the attendance of the students");
    }else{
        output(Constants::STATUS_FAILED, "<h4 class='alert-message'><i class='fa fa-exclamation-triangle'></i>Something Went Wrong</h4>");
    }
}else{
    output(Constants::STATUS_FAILED, "<h4 class='alert-message'><i class='fa fa-exclamation-triangle'></i>Params Cannot Be Empty</h4>");
}