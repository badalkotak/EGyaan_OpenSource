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
$db = new DBConnect();
$connection = $db->getInstance();
$sql = "select distinct id, student_fullname from egn_students";
$result = $connection->query($sql);
$array = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $array[] = $row;
    }
}
$json = array();
$json["status"] = Constants::STATUS_SUCCESS;
$json["students"] = $array;
echo json_encode($json);