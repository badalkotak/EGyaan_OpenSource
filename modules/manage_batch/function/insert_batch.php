<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 4/6/17
 * Time: 7:31 PM
 */
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
    $batchName = $_REQUEST['batchName'];
    $branchId = $_REQUEST['branchId'];
    $batch = new Batch($dbConnect->getInstance());

    $insertData = $batch->insertBatch($batchName, $branchId);

//    var_dump($insertData);

    if ($insertData == "true") {
        echo "Batch " . Constants::STATUS_SUCCESS . "fully inserted<br>";
        header('Location: batch.php');
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
        echo "Batch Name " . Constants::STATUS_EXISTS;
    } else {
        echo Constants::STATUS_FAILED;
    }

} else {
    echo Constants::EMPTY_PARAMETERS;
}