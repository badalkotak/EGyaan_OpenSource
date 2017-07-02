<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 5/6/17
 * Time: 2:04 PM
 */
include("../../../Resources/sessions.php");

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Batch.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

if (isset($_REQUEST['batchId']) && isset($_REQUEST['batchName']) && isset($_REQUEST['branchId']) && !empty(trim($_REQUEST['batchId']))
    && !empty(trim($_REQUEST['batchName'])) && !empty(trim($_REQUEST['branchId']))
) {
    $batchId = $_REQUEST['batchId'];
    $batchName = $_REQUEST['batchName'];
    $branchId = $_REQUEST['branchId'];

    $batch = new Batch($dbConnect->getInstance());

    $updateData = $batch->updateBatch($batchId, $batchName, $branchId);

    if ($updateData == true) {
        echo "Batch " . Constants::STATUS_SUCCESS . "fully updated";
//        header('Location:batch.php');
    } else {
        echo Constants::STATUS_FAILED . " to update batch";
    }
} else {
    echo Constants::EMPTY_PARAMETERS;
}