<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 5/6/17
 * Time: 2:18 PM
 */
include("../../../Resources/sessions.php");

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Batch.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

if (isset($_REQUEST['batchId']) && !empty(trim($_REQUEST['batchId']))) {
    $batchId = $_REQUEST['batchId'];

    $batch = new Batch($dbConnect->getInstance());

    $deleteData = $batch->deleteBatch($batchId);

    if ($deleteData == true) {
        echo "Batch " . Constants::STATUS_SUCCESS . "fully deleted";
//        header('Location:batch.php');
    } else {
        echo Constants::STATUS_FAILED . " to delete batch";
    }
} else {
    echo Constants::EMPTY_PARAMETERS;
}