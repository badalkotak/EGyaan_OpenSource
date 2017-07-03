<?php
/**
 * Created by PhpStorm.
 * User: adityajthakker
 * Date: 15/12/16
 * Time: 3:24 PM
 */
header("Content-Type: application/json");
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

    $url = "Location: ../forum.php?status=" . $status;
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



if(isset($_REQUEST["thread_id"])){
    $id = $_REQUEST["thread_id"];
    $forum = new Forum($connection);
    if($forum->deleteThread($id)){
        output(Constants::STATUS_SUCCESS, "Thread Deleted Successfully");
    }else{
        output(Constants::STATUS_FAILED, "Something Went Wrong While Deletion");
    }
}else{
    jsonReply(Constants::STATUS_FAILED, "Thread Id Cannot Be Empty");
}