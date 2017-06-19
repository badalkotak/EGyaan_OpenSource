<html>
<head>
    <title>Batches - Edit Batch|EGyaan</title>
</head>
<body>
<form action="edit_batch.php" method="post">
    <?php
    /**
     * Created by PhpStorm.
     * User: fireion
     * Date: 5/6/17
     * Time: 12:52 PM
     */
    require_once("../../../classes/Constants.php");
    require_once("../../../classes/DBConnect.php");
    require_once("../classes/Batch.php");
    require_once("../../manage_branch/classes/Branch.php");

    $dbConnect = new DBConnect(Constants::SERVER_NAME,
        Constants::DB_USERNAME,
        Constants::DB_PASSWORD,
        Constants::DB_NAME);

    if (isset($_REQUEST['branchId']) && isset($_REQUEST['batchId']) && !empty(trim($_REQUEST['branchId']))
        && !empty(trim($_REQUEST['batchId']))
    ) {
        $branchId = $_REQUEST['branchId'];
//        $branchName = $_REQUEST['branchName'];
        $batchId = $_REQUEST['batchId'];
//        $batchName = $_REQUEST['batchName'];

        $branch = new Branch($dbConnect->getInstance());
        $batch = new Batch($dbConnect->getInstance());

        $getBranchData = $branch->getBranch($branchId);
        if ($getBranchData != null) {
            while ($row = $getBranchData->fetch_assoc()) {
                $branchName = $row['name'];
            }

            $getBatchData = $batch->getBatch('no', 0, $batchId, 'no');
//            var_dump($getBatchData);
            if ($getBatchData != null) {
                while ($array = $getBatchData->fetch_assoc()) {
                    $batchName = $array['batchName'];
                }
                echo "<label>" . $branchName . "</label>";
                echo "<br>";
                echo "<input type='hidden' name='branchId' value='" . $branchId . "'>";
                echo "<input type='hidden' name='batchId' value='" . $batchId . "'>";
                echo "<input type='text' name='batchName' value='" . $batchName . "'>";
                echo "<br>";
                echo "<input type='submit' value='Update'>";
            } else {
                echo Constants::STATUS_FAILED;
            }
        } else {
            echo Constants::STATUS_FAILED;
        }
    } else {
        echo Constants::EMPTY_PARAMETERS;
    }
    ?>
</form>
</body>
</html>
