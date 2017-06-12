<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 9/6/17
 * Time: 4:34 PM
 */

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Student.php");


$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

if (isset($_REQUEST['studentId']) && !empty(trim($_REQUEST['studentId']))) {
    $studentId = $_REQUEST['studentId'];

    $student = new Student($dbConnect->getInstance());

    $deleteData = $student->deleteStudent($studentId);

    if ($deleteData == true) {
        echo "Student " . Constants::STATUS_SUCCESS . "fully deleted";
//        header('Location:student.php');
    } else {
        echo Constants::STATUS_FAILED . " to delete student";
    }
} else {
    echo Constants::EMPTY_PARAMETERS;
}
