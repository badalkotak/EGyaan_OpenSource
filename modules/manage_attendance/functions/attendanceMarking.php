<?php
/**
 * Created by PhpStorm.
 * User: adityajthakker
 * Date: 28/12/16
 * Time: 6:00 PM
 */
require_once "../classes/DBConnect.php";
require_once "../classes/Attendance.php";
require_once "../classes/Constants.php";

function output($status, $message = null){
    // echo $json?"true":"false". "    ". $message . "   " .$status;
    if (isset($_REQUEST["output"])) {
        header("Content-Type: application/json");
        $json = array();
        $json["status"] = $status;
        $json["message"] = $message;
        if (isset($_REQUEST["isTopicCompleted"])) {
            $json["redirect"] = $_REQUEST["isTopicCompleted"]?true:false;
        }
        echo json_encode($json);
    } else {
        if(isset($_REQUEST["isTopicCompleted"])){
            $url = "Location: ../addMCQ.php?status=" . $status;
            $url = $url . "&message=" . $message;
            header($url);
        }else{
            $url = "Location: ../markAttendance.php?status=" . $status;
            $url = $url . "&message=" . $message;
            header($url);
        }

    }
    exit();
}

if(isset($_REQUEST["topic_id"], $_REQUEST["timetable_id"], $_REQUEST["attendees"])){
    $db = new DBConnect();
    $connection = $db->getInstance();
    $attendance = new Attendance($connection);

    if($_REQUEST["topic_id"] == null || $_REQUEST["timetable_id"] == null ){
        output(Constants::STATUS_FAILED, "You have not selected Course or Topic or Timetable Slot");
    }

    if($attendance->markAttendance(
        $connection->real_escape_string(trim($_REQUEST["topic_id"])),
        $connection->real_escape_string(trim($_REQUEST["timetable_id"])),
        $_REQUEST["attendees"]
    )){
        output(Constants::STATUS_SUCCESS, "You have successfully marked the attendance of the students");
    }else{
        output(Constants::STATUS_FAILED, "Something Went Wrong");
    }
}else{
    output(Constants::STATUS_FAILED, "Params Cannot Be Empty");
}