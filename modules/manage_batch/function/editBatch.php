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

    $dbConnect = new DBConnect(Constants::SERVER_NAME,
        Constants::DB_USERNAME,
        Constants::DB_PASSWORD,
        Constants::DB_NAME);

    if (isset($_REQUEST['branchId']) && isset($_REQUEST['branchName']) && isset($_REQUEST['batchId'])
        && isset($_REQUEST['batchName']) && !empty(trim($_REQUEST['branchId'])) && !empty(trim($_REQUEST['branchName']))
        && !empty(trim($_REQUEST['batchId'])) && !empty(trim($_REQUEST['batchName']))
    ) {
        $branchId = $_REQUEST['branchId'];
        $branchName = $_REQUEST['branchName'];
        $batchId = $_REQUEST['batchId'];
        $batchName = $_REQUEST['batchName'];

        echo "<select name='branchId' disabled>";
        echo "<option value='" . $branchId . "'>" . $branchName . "</option>";
        echo "</select>";
        echo "<br>";
        echo "<input type='hidden' name='branchId' value='" . $branchId . "'>";
        echo "<input type='hidden' name='batchId' value='" . $batchId . "'>";
        echo "<input type='text' name='batchName' value='" . $batchName . "'>";

    } else {
        echo Constants::EMPTY_PARAMETERS;
    }
    ?>
    <br>
    <input type="submit" value="Update">
</form>
</body>
</html>
