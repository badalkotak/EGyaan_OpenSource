<html>
<head>
    <title>Batches - Add Batch|EGyaan</title>
</head>
<body>
<form action="" method="post">
    <select name="branchId" id="branchId" required>
        <option value="-1">Select Branch</option>

        <?php
        /**
         * Created by PhpStorm.
         * User: fireion
         * Date: 5/6/17
         * Time: 11:02 AM
         */
        require_once("../../../classes/Constants.php");
        require_once("../../../classes/DBConnect.php");
        require_once("../classes/Batch.php");
        require_once("../../manage_branch/classes/Branch.php");

        $dbConnect = new DBConnect(Constants::SERVER_NAME,
            Constants::DB_USERNAME,
            Constants::DB_PASSWORD,
            Constants::DB_NAME);

        $branch = new Branch($dbConnect->getInstance());
        $batch = new Batch($dbConnect->getInstance());
        $getData = $branch->getBranch();

        if ($getData != null) {
            while ($arrayGetData = $getData->fetch_assoc()) {
                $branchId = $arrayGetData['id'];
                $branchName = $arrayGetData['name'];
                if ($branchId == $_REQUEST['branchId']) {
                    echo "<option value='" . $branchId . "' selected>" . $branchName . "</option>";
                } else {
                    echo "<option value='" . $branchId . "'>" . $branchName . "</option>";
                }
            }
        } else {
            echo Constants::STATUS_FAILED;
        }
        ?>
    </select>
    <input type="submit" value="Submit">
</form>
</body>
</html>
<?php
//var_dump($_REQUEST['branchId']);
if (isset($_REQUEST['branchId'])) {
    $branch_Id = $_REQUEST['branchId'];
    if ($branch_Id > 0) {
        echo "<form action='insert_batch.php' method='post'>";
        echo "<input type='hidden' name='branchId' value='" . $branch_Id . "'>";
        echo "<input type='text' name='batchName' placeholder='Enter Batch Name'>";
        echo "<br>";
        echo "<input type='submit' value='Submit'>";
        echo "</form>";
    } else {
        echo "Select valid Branch/Department";
    }
} else {
    echo "Select Appropriate Branch/Department";
}

$getBatchData = $batch->getBatch('yes', 0);

if ($getBatchData != false) {
    echo "<br><br>List of Batches";
    echo "<table border='3'>";
    echo "<tr><th>Branch Name</th><th>Batch Name</th><th>Edit</th><th>Delete</th></tr>";
    while ($row = $getBatchData->fetch_assoc()) {
//        var_dump($row);
        $branchTableId = $row['branchId'];
        $branchTableName = $row['branchName'];
        $batchTableId = $row['batchId'];
        $batchTableName = $row['batchName'];
        echo "<tr><td>" . $branchTableName . "</td><td>" . $batchTableName . "</td><td><form action='editBatch.php' method='post'>
        <input type='hidden' name='branchId' value='" . $branchTableId . "'><input type='hidden' name='branchName' value='" . $branchTableName . "'>
        <input type='hidden' name='batchId' value='" . $batchTableId . "'><input type='hidden' name='batchName' value='" . $batchTableName . "'><input type='submit' value='Edit'></form>
        </td><td><form action='delete_batch.php' method='post'><input type='hidden' name='branchId' value='" . $branchTableId . "'>
        <input type='hidden' name='batchId' value='" . $batchTableId . "'><input type='submit' value='Delete'></form>
        </td></tr>";
    }
    echo "</table>";
} else {
    echo "<br><br>No Records found";
}
?>