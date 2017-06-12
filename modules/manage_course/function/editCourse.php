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
    require_once("../../manage_branch/classes/Branch.php");
    require_once("../../manage_batch/classes/Batch.php");

    $dbConnect = new DBConnect(Constants::SERVER_NAME,
        Constants::DB_USERNAME,
        Constants::DB_PASSWORD,
        Constants::DB_NAME);

    if (isset($_REQUEST['branchId']) && isset($_REQUEST['batchId']) && isset($_REQUEST['courseId'])
        && !empty(trim($_REQUEST['branchId'])) && !empty(trim($_REQUEST['batchId'])) && !empty(trim($_REQUEST['courseId']))
    ) {
        $branchId = $_REQUEST['branchId'];
        $batchId = $_REQUEST['batchId'];
        $courseId = $_REQUEST['courseId'];
//        $branchName = $_REQUEST['branchName'];
//        $batchName = $_REQUEST['batchName'];
//        $courseName = $_REQUEST['courseName'];

        $branch = new Branch($dbConnect->getInstance());
        $batch = new Batch($dbConnect->getInstance());
        $course = new Course($dbConnect->getInstance());

        $getBranchData = $branch->getBranch($branchId);
        if ($getBranchData != null) {
            while ($row = $getBranchData->fetch_assoc()) {
                $branchName = $row['name'];
            }

            $getBatchData = $batch->getBatch('no', 0, $batchId);
            if ($getBatchData != null) {
                while ($row1 = $getBatchData->fetch_assoc()) {
                    $batchName = $row1['name'];
                }

                $getCourseData = $course->getCourse('no', 0, 'no', 0, $courseId);
                if ($getCourseData != null) {
                    while ($row2 = $getCourseData->fetch_assoc()) {
                        $courseName = $row2['name'];
                    }

                    //        echo "<select name='branchId' disabled>";
//        echo "<option value='" . $branchId . "'>" . $branchName . "</option>";
//        echo "</select>";
                    echo "<label>" . $branchName . "</label>";
                    echo "<br>";
//        echo "<select name='batchId' disabled>";
//        echo "<option value='" . $batchId . "'>" . $batchName . "</option>";
//        echo "</select>";
                    echo "<label>" . $batchName . "</label>";
                    echo "<br>";
                    echo "<input type='hidden' name='branchId' value='" . $branchId . "'>";
                    echo "<input type='hidden' name='batchId' value='" . $batchId . "'>";
                    echo "<input type='hidden' name='courseId' value='" . $courseId . "'>";
                    echo "<input type='text' name='courseName' value='" . $courseName . "'>";
                    echo "<br>";
                    echo "<input type='submit' value='Update'>";
                } else {
                    echo Constants::STATUS_FAILED;
                }
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