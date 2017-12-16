<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 5/6/17
 * Time: 2:18 PM
 */
include("../../../Resources/sessions_for_backend.php");

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Batch.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

function jsonOutput($status, $message)
{
    $json = array();
    $json["statusMsg"] = $status;
    $json["Msg"] = $message;

    echo json_encode($json);
}

if (isset($_REQUEST['batchId']) && !empty(trim($_REQUEST['batchId']))) {
    $batchId = $_REQUEST['batchId'];

    $batch = new Batch($dbConnect->getInstance());

    $deleteData = $batch->deleteBatch($batchId);

    if ($deleteData == true) {
        jsonOutput(Constants::STATUS_SUCCESS, "Batch " . Constants::STATUS_SUCCESS . "fully deleted");
    } else {
        jsonOutput(Constants::STATUS_FAILED, Constants::STATUS_FAILED . " to delete batch");
    }
} else {
    jsonOutput(Constants::EMPTY_PARAMETERS, Constants::EMPTY_PARAMETERS . " found");
}