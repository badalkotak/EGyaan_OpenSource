<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 4/6/17
 * Time: 6:19 PM
 */

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Branch.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

if (isset($_REQUEST['delete']) && !empty(trim($_REQUEST['delete']))) {
    $branchId = $_REQUEST['delete'];

    $branch = new Branch($dbConnect->getInstance());

    $deleteData = $branch->deleteBranch($branchId);

    if ($deleteData == true) {
//        header('Location:branch.php');
        echo "Branch " . Constants::STATUS_SUCCESS . "fully deleted";
    } else {
        echo Constants::STATUS_FAILED . " to delete branch";
    }

} else {
    echo Constants::EMPTY_PARAMETERS;
}