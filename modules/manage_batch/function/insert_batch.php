<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 4/6/17
 * Time: 7:31 PM
 */
include("../../../Resources/sessions.php");

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Batch.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

if (isset($_REQUEST['batchName']) && isset($_REQUEST['branchId']) && !empty(trim($_REQUEST['batchName']))
    && !empty(trim($_REQUEST['branchId']))
) {
    $batchName = trim($_REQUEST['batchName']);
    $branchId = $_REQUEST['branchId'];

    $batch = new Batch($dbConnect->getInstance());

    $insertData = $batch->insertBatch($batchName, $branchId);

//    var_dump($insertData);

    if ($insertData == "true") {
        echo "<script>alert('Batch " . Constants::STATUS_SUCCESS . "fully inserted');
        window.location.href = 'batch.php';</script>";
    } elseif ($insertData == Constants::STATUS_EXISTS) {
        echo "<script>alert('Batch Name " . Constants::STATUS_EXISTS . "');
        window.location.href = 'batch.php';</script>";
    } else {
        echo "<script>alert('" . Constants::STATUS_FAILED . " to insert batch');
        window.location.href = 'batch.php';<script>";
    }

} else {
    echo "<script>alert('" . Constants::EMPTY_PARAMETERS . "');
    window.location.href = 'batch.php';</script>";
}