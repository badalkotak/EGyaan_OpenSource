<?php
include("../../../Resources/sessions.php");

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Branch.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

if (isset($_REQUEST['branch_name']) && !empty(trim($_REQUEST['branch_name']))) {
    $branch_name = $_REQUEST['branch_name'];
    $branch = new Branch($dbConnect->getInstance());

    $insertData = $branch->insertBranch($branch_name);

//    var_dump($insertData);

    if ($insertData == "true") {
        echo "<script>alert('Branch " . Constants::STATUS_SUCCESS . "fully inserted');
        window.location.href='branch.php';</script>";
    } elseif ($insertData == Constants::STATUS_EXISTS) {
        echo "<script>alert('Branch Name " . Constants::STATUS_EXISTS . "');
        window.location.href='branch.php';</script>";
    } else {
        echo "<script>alert('" . Constants::STATUS_FAILED . " to add branch');
        window.location.href='branch.php';</script>";
    }

} else {
    echo "<script>alert('" . Constants::EMPTY_PARAMETERS . "');
    window.location.href='branch.php';</script>";
}