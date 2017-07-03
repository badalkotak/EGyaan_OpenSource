<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 9/6/17
 * Time: 7:14 PM
 */
include("../../../Resources/sessions_for_backend.php");

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../../manage_batch/classes/Batch.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

if (isset($_REQUEST['branchId']) && !empty(trim($_REQUEST['branchId']))) {

    function jsonOutput($status, $id, $name, $branchId)
    {
        $json = array();
        $json["status"] = $status;
        $json["batchId"] = $id;
        $json["batchName"] = $name;
        $json["batchBranchId"] = $branchId;

        echo json_encode($json);
    }

    $branchId = $_REQUEST['branchId'];

    $batch = new Batch($dbConnect->getInstance());

    $getData = $batch->getBatch('yes', $branchId, 0, 'no', 0);

    if ($getData != null) {
        while ($row = $getData->fetch_assoc()) {
            $batchId[] = $row['batchId'];
            $batchName[] = $row['batchName'];
            $batchBranchId[] = $row['batchBranchId'];
        }
        jsonOutput('success', $batchId, $batchName, $batchBranchId);
    } else {
        echo Constants::STATUS_FAILED;
    }
} else {
    echo Constants::EMPTY_PARAMETERS;
}