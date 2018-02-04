<?php
/**
 * Created by PhpStorm.
 * User: adityajthakker
 * Date: 15/12/16
 * Time: 3:14 PM
 */
require_once "../classes/Forum.php";
require_once "../../../classes/DBConnect.php";
require_once "../../../classes/Constants.php";

$dbconnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
$connection = $dbconnect->getInstance();

function redirect($url){
    header("Location: " . $url);
}

function output($status, $message = null, $id=null){

        $url = "Location: forum.php?id=".$id."&status=" . $status;
        $url = $url . "&message=" . $message;
        header($url);
}

session_start();
if(!isset($_SESSION["id"], $_SESSION["role"])){
    output(Constants::STATUS_FAILED, "Invalid User Access");
}


if($_SESSION["role"] != Constants::ROLE_STUDENT_ID && $_SESSION["role"] != Constants::ROLE_TEACHER_ID){
    session_unset();
    session_destroy();
    redirect("../../login.php?status=" . Constants::STATUS_FAILED . "&message=" . "Invalid Access. You Have Been Logged Out");
}

if (isset($_REQUEST["title"]) &&
    isset($_REQUEST["description"]) &&
    isset($_REQUEST["student_id"]) &&
    isset($_REQUEST["teacher_id"]) &&
    isset($_REQUEST["course_id"])
) {


    if (strlen(trim($_REQUEST["title"])) <= 0) {
        output(Constants::STATUS_FAILED, $message = "Title Cannot Be Empty");
    }

    if (strlen(trim($_REQUEST["description"])) < 20) {
        output(Constants::STATUS_FAILED, $message = "Description Cannot Be Less Than 20 Characters");
    }

    $forum = new Forum($connection);
    $id = $forum->createThread(
        $connection->real_escape_string(trim($_REQUEST["title"])),
        $connection->real_escape_string(trim($_REQUEST["description"])),
        $connection->real_escape_string(trim($_REQUEST["student_id"])),
        $connection->real_escape_string(trim($_REQUEST["teacher_id"])),
        $connection->real_escape_string(trim($_REQUEST["course_id"])));
//    echo $id;
//    exit();
    if ($id != -1) {
        output(Constants::STATUS_SUCCESS, "You have successfully created a new thread", $id);
    } else {
        output(Constants::STATUS_FAILED, "Something Went Wrong");
    }
} else {
    output(Constants::STATUS_FAILED, "Params Cannot Be Empty");
}
