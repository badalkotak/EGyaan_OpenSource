<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Test.php");
header("Content-Type: application/json");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

include("../../../Resources/sessions.php");

$teacher_id = $id;
$test = new Test($dbConnect->getInstance());
if(isset($_REQUEST["branch_id"])){
    $branch_id = $_REQUEST["branch_id"];
}else{
    $branch_id = 0;
}
if(isset($_REQUEST["batch_id"])){
    $batch_id = $_REQUEST["batch_id"];
}else{
    $batch_id = 0;
}
if(isset($_REQUEST["select"])){
    $select = $_REQUEST["select"];
}else{
    $select = "";
}
$json = array();
$data = array();
if($select == "batch"){
    $result=$test->getBatch($teacher_id,$branch_id);
    if($result!=false)
    {
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        $json["status"]=Constants::STATUS_SUCCESS;
        $json["data"]=$data;
        $json["type"]="specific";
    }else{
        $result=$test->getAllCourse("no",0,'no',0,0,null,$branch_id);
        if($result!=false)
        {
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            $json["status"]=Constants::STATUS_SUCCESS;
            $json["data"]=$data;
            $json["type"]="unspecific";
        }else{
            $json["message"] = "No batch/course to list";
        }
    }
}elseif($select == "course"){
    $result=$test->getCourse($teacher_id,$branch_id,$batch_id);
    if($result!=false)
    {
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        $json["status"]=Constants::STATUS_SUCCESS;
        $json["data"]=$data;
    }else{
        $json["message"] = "No course to list";
    }
}else{
    $json["message"] = "Something went wrong";
}
echo json_encode($json);
