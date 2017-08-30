<?php
/**
 * Created by PhpStorm.
 * User: adityajthakker
 * Date: 28/12/16
 * Time: 6:54 PM
 */
require_once "../classes/Constants.php";
require_once "../classes/DBConnect.php";
header("Content-Type: application/json");
if(isset($_REQUEST["course_id"])){
    $db = new DBConnect();
    $connection = $db->getInstance();
    $sql = "select distinct id, name from egn_topics where course_id = " . $_REQUEST["course_id"];
    $result = $connection->query($sql);
    $json = array();
    $values = array();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $values[] = $row;
        }
        $json["status"] = Constants::STATUS_SUCCESS;
        $json["topics"] = $values;
        echo json_encode($json);
    }else{
        $json["status"] = Constants::STATUS_FAILED;
        $json["message"] = "Something Went Wrong";
        echo json_encode($json);
    }
}else{
    $json["status"] = Constants::STATUS_FAILED;
    $json["message"] = "Something Went Wrong";
    echo json_encode($json);
}