<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Test.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
$teacher_id = 1; //To Do: Change This
$test = new Test($dbConnect->getInstance());
if($test->deleteTest($_REQUEST["id"],$teacher_id)){
    $test->parentPageRedirect("Test deleted successfully");
}else{
    $test->parentPageRedirect("Error while deleting test");
}
?>