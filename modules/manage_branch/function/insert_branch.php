<?php
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
        echo "Branch ".Constants::STATUS_SUCCESS."fully inserted<br>";
        header('Location: branch.php');
//        echo "List of Department - Branches<br>";
//        $result = $branch->getBranch();
//        if ($result != null) {
//            while ($row = $result->fetch_assoc()) {
//                echo $name = $row['name'];
//                echo "<br>";
//            }
//        } else {
//            echo "No Records Found";
//        }
    } elseif ($insertData == Constants::STATUS_EXISTS) {
        echo "Branch Name " . Constants::STATUS_EXISTS;
    } else {
        echo Constants::STATUS_FAILED;
    }

} else {
    echo Constants::EMPTY_PARAMETERS;
}