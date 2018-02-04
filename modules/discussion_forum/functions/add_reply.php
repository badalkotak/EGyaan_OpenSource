<?php
/**
 * Created by PhpStorm.
 * User: adityajthakker
 * Date: 22/12/16
 * Time: 12:50 PM
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

    $url = "Location: thread.php?id=".$_REQUEST["thread_id"]."&status=" . $status;
    $url = $url . "&message=" . $message;
    header($url);

}

session_start();
if(!isset($_SESSION["role"], $_SESSION["id"])){
    output(Constants::STATUS_FAILED, "Invalid User Access");
}


if($_SESSION["role"] != Constants::ROLE_STUDENT_ID && $_SESSION["role"] != Constants::ROLE_TEACHER_ID){
    session_unset();
    session_destroy();
    redirect("../../login.php?status=" . Constants::STATUS_FAILED . "&message=" . "Invalid Access. You Have Been Logged Out");
}



if (isset($_REQUEST["reply"]) &&
    isset($_REQUEST["parent_reply_id"]) &&
    isset($_REQUEST["student_id"]) &&
    isset($_REQUEST["teacher_id"]) &&
    isset($_REQUEST["thread_id"])
) {

    if (strlen(trim($_REQUEST["reply"])) <= 0) {
        output($json = false, Constants::STATUS_FAILED, $message = "Reply Cannot Be Empty");
    }

    $forum = new Forum($connection);
    $id = $forum->addReply(
        $connection->real_escape_string(trim($_REQUEST["thread_id"])),
        $connection->real_escape_string(trim($_REQUEST["student_id"])),
        $connection->real_escape_string(trim($_REQUEST["teacher_id"])),
        $connection->real_escape_string(trim($_REQUEST["parent_reply_id"])),
        $connection->real_escape_string(trim($_REQUEST["reply"])));
    if ($id != -1) {
        output(Constants::STATUS_SUCCESS, "Your Reply was added successfully");
    } else {
        output(Constants::STATUS_FAILED, "Something Went Wrong");
    }
} else {
    output(Constants::STATUS_FAILED, "Params Cannot Be Empty");
}