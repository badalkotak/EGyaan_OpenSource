<?php
/**
 * Created by PhpStorm.
 * User: adityajthakker
 * Date: 28/12/16
 * Time: 6:54 PM
 */
require_once "../../../classes/DBConnect.php";
require_once "../../../classes/Constants.php";
$dbconnect = new DBConnect(Constants::SERVER_NAME,
                           Constants::DB_USERNAME,
                           Constants::DB_PASSWORD,
                           Constants::DB_NAME);
$connection = $dbconnect->getInstance();
header("Content-Type: application/json");
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