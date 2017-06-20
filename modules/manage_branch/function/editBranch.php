<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 4/6/17
 * Time: 5:49 PM
 */
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Branch.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

if (isset($_REQUEST['edit']) && !empty(trim($_REQUEST['edit']))) {
    $branchId = $_REQUEST['edit'];
    // $branchName = $_REQUEST['branchName'];

    $branch = new Branch($dbConnect->getInstance());

    $getBranchName = $branch->getBranch(0);
    if ($getBranchName != null) {
        while ($row = $getBranchName->fetch_assoc()) {
            $id = $row['id'];
            if ($id === $branchId) {
                $branchName = htmlentities($row['name'], ENT_QUOTES);
                break;
            }
        }
    } else {
        echo Constants::STATUS_FAILURE;
    }

} else {
    echo Constants::EMPTY_PARAMETERS;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Department - Edit Branches|EGyaan</title>
</head>
<body>
<form action="edit_branch.php" method="post">
    <input type="hidden" name="branchId" value="<?php echo $branchId; ?>">
    <input type="text" name="branchName" value="<?php echo $branchName; ?>">
    <br>
    <input type="submit" value="Update">
</form>
</body>
</html>