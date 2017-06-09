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

if (isset($_REQUEST['branchName']) && isset($_REQUEST['branchId']) && !empty(trim($_REQUEST['branchName']))
    && !empty(trim($_REQUEST['branchId']))
) {
    $branchId = $_REQUEST['branchId'];
    $branchName = $_REQUEST['branchName'];
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