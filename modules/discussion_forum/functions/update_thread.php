<?php
/**
 * Created by PhpStorm.
 * User: adityajthakker
 * Date: 15/12/16
 * Time: 3:26 PM
 */

header("Content-Type: application/json");
require_once "../classes/Forum.php";
require_once "../../../classes/DBConnect.php";
require_once "../../../classes/Constants.php";

$connection = DBConnect::getInstance();
$security = new Security($connection);

function redirect($url){
    header("Location: " . $url);
}

function output($status, $message = null){
    // echo $json?"true":"false". "    ". $message . "   " .$status;
    if (isset($_REQUEST["output"])) {
        header("Content-Type: application/json");
        $json = array();
        $json["status"] = $status;
        $json["message"] = $message;
        echo json_encode($json);
    } else {
        $url = "Location: ../thread.php?id=" . $_REQUEST["thread_id"] . "&status=" . $status;
        $url = $url . "&message=" . $message;
        header($url);
    }
    exit();
}

session_start();
if(!isset($_SESSION["user_id"], $_SESSION["user_type"], $_SESSION["token"])) {
    output(Constants::STATUS_FAILED, "Invalid Session");
}

if($security->is_ip_blocked()){
    output(Constants::STATUS_FAILED, "Your IP Is Blocked");
}

if(!$security->validate_token($_SESSION["user_id"], $_SESSION["user_type"], $_SESSION["token"])){
    session_unset();
    session_destroy();
    output(Constants::STATUS_FAILED, "Invalid Session");
}

if($_SESSION["user_type"] != Constants::USER_TYPE_STUDENT && $_SESSION["user_type"] != Constants::USER_TYPE_TEACHER){
    session_unset();
    session_destroy();
    redirect("../../login.php?status=" . Constants::STATUS_FAILED . "&message=" . "Invalid Access. You Have Been Logged Out");
}

function jsonReply($status, $content=null){
    $json = array();
    $json["status"] = $status;
    if($content != null){
        $json["message"] = $content;
    }
    echo json_encode($json);
}

if(isset($_REQUEST["thread_id"]) &&
    isset($_REQUEST["title"]) &&
    isset($_REQUEST["description"])){
    $forum = new Forum(DBConnect::getInstance());
    if($forum->updateThread(
        trim($_REQUEST["thread_id"]),
        trim($_REQUEST["title"]),
        trim($_REQUEST["description"]),
        trim($_REQUEST["course_id"]))){
        jsonReply(Constants::STATUS_SUCCESS);
    }else{
        jsonReply(Constants::STATUS_FAILED, "Something Went Wrong While Updating");
    }
}else{
    jsonReply(Constants::STATUS_FAILED, "Params Cannot be Empty");
}