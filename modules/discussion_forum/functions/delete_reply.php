<?php
/**
 * Created by PhpStorm.
 * User: adityajthakker
 * Date: 8/1/17
 * Time: 4:56 PM
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

function output($status, $message = null){

    $url = "Location: ../thread.php?id=".$_REQUEST["thread_id"]."&status=" . $status;
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


if(isset($_REQUEST["id"])){
    $forum = new Forum($connection);
    if($forum->deleteReply($_REQUEST["id"])){
        output(Constants::STATUS_SUCCESS, "Reply Deleted Successfully");
    }else{
        output(Constants::STATUS_FAILED, "Something Went Wrong While Deletion");
    }
}else{
    output(Constants::STATUS_FAILED, "Params Cannot Be Empty");
}