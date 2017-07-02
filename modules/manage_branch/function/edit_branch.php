<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 4/6/17
 * Time: 6:03 PM
 */
include("../../../Resources/sessions.php");

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Branch.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

if (isset($_REQUEST['branchName']) && isset($_REQUEST['branchId']) && !empty(trim($_REQUEST['branchName']))
    && !empty(trim($_REQUEST['branchId']))
) {
    $branchId = $_REQUEST['branchId'];
    $branchName = $_REQUEST['branchName'];

    $branch = new Branch($dbConnect->getInstance());

    $editData = $branch->updateBranch($branchId, $branchName);

    if ($editData == true) {
//        header('Location:branch.php');
        echo "Branch " . Constants::STATUS_SUCCESS . "fully updated";
    } else {
        echo Constants::STATUS_FAILED . " to update branch";
    }

} else {
    echo Constants::EMPTY_PARAMETERS;
}