<html>
<head>
    <title>Course - Edit Courses|EGyaan</title>
</head>
<body>
<form action="edit_course.php" method="post">
    <?php
    /**
     * Created by PhpStorm.
     * User: fireion
     * Date: 5/6/17
     * Time: 5:05 PM
     */

    require_once("../../../classes/Constants.php");
    require_once("../../../classes/DBConnect.php");
    require_once("../classes/Course.php");

    $dbConnect = new DBConnect(Constants::SERVER_NAME,
        Constants::DB_USERNAME,
        Constants::DB_PASSWORD,
        Constants::DB_NAME);

    if (isset($_REQUEST['branchId']) && isset($_REQUEST['branchName']) && isset($_REQUEST['batchId'])
        && isset($_REQUEST['batchName']) && isset($_REQUEST['courseId']) && isset($_REQUEST['courseName'])
        && !empty(trim($_REQUEST['branchId'])) && !empty(trim($_REQUEST['branchName']))
        && !empty(trim($_REQUEST['batchId'])) && !empty(trim($_REQUEST['batchName']))
        && !empty(trim($_REQUEST['courseId'])) && !empty(trim($_REQUEST['courseName']))
    ) {
        $branchId = $_REQUEST['branchId'];
        $branchName = $_REQUEST['branchName'];
        $batchId = $_REQUEST['batchId'];
        $batchName = $_REQUEST['batchName'];
        $courseId = $_REQUEST['courseId'];
        $courseName = $_REQUEST['courseName'];

        echo "<select name='branchId' disabled>";
        echo "<option value='" . $branchId . "'>" . $branchName . "</option>";
        echo "</select>";
        echo "<br>";
        echo "<select name='batchId' disabled>";
        echo "<option value='" . $batchId . "'>" . $batchName . "</option>";
        echo "</select>";
        echo "<br>";
        echo "<input type='hidden' name='branchId' value='" . $branchId . "'>";
        echo "<input type='hidden' name='batchId' value='" . $batchId . "'>";
        echo "<input type='hidden' name='courseId' value='" . $courseId . "'>";
        echo "<input type='text' name='courseName' value='" . $courseName . "'>";

    } else {
        echo Constants::EMPTY_PARAMETERS;
    }
    ?>
    <br>
    <input type="submit" value="Update">
</form>
</body>
</html>