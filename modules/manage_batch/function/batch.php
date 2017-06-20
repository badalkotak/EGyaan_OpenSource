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

        $getData = $branch->getBranch(0);

        if ($getData != null) {
            while ($arrayGetData = $getData->fetch_assoc()) {
                $branchId = $arrayGetData['id'];
                $branchName = htmlentities($arrayGetData['name'], ENT_QUOTES);

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

echo "<br><br><br>List of Batches - ";
$getBatchData = $branch->getBranch(0);
//var_dump($getBatchData);
if ($getBatchData != null) {
    while ($array = $getBatchData->fetch_assoc()) {
        $branch_id[] = $array['id'];
        $branch_name[] = htmlentities($array['name'], ENT_QUOTES);
    }
    for ($i = 0; $i < count($branch_id); $i++) {
        echo "<br><br>" . $branch_name[$i];
        $getBatchData = $batch->getBatch('yes', $branch_id[$i], 0, 'no', 0);
        if ($getBatchData != null) {
            $id = 1;
            echo "<table border='3'>";
            echo "<tr><th>Sr. no.</th><th>Batch Name</th><th>Edit</th><th>Delete</th></tr>";

            while ($row = $getBatchData->fetch_assoc()) {
                $batchTableId = $row['batchId'];
                $batchTableName = htmlentities($row['batchName'], ENT_QUOTES);

                echo "<tr><td>" . $id . "</td><td>" . $batchTableName . "</td><td><form action='editBatch.php' method='post'>
        <input type='hidden' name='branchId' value='" . $branch_id[$i] . "'><input type='hidden' name='batchId' value='" . $batchTableId . "'>
        <input type='submit' value='Edit'></form></td>
        <td><form action='delete_batch.php' method='post'><input type='hidden' name='branchId' value='" . $branch_id[$i] . "'>
        <input type='hidden' name='batchId' value='" . $batchTableId . "'><input type='submit' value='Delete'></form>
        </td></tr>";
                $id++;
            }
            echo "</table>";
        } else {
            echo "<br><br>No Records found";
        }
    }
} else {
    echo Constants::STATUS_FAILED;
}
?>