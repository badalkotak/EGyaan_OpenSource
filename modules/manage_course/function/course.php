<html>
<head>
    <title>Course - Add Courses|EGyaan</title>
</head>
<body>
<form action="" method="post">
    <select name="branchId">
        <option value="-1">Select Branch</option>
        <?php
        /**
         * Created by PhpStorm.
         * User: fireion
         * Date: 5/6/17
         * Time: 2:46 PM
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

        $branch = new Branch($dbConnect->getInstance());
        $batch = new Batch($dbConnect->getInstance());
        $course = new Course($dbConnect->getInstance());

        $getBranchData = $branch->getBranch();
        if ($getBranchData != null) {
            while ($row = $getBranchData->fetch_assoc()) {
                $branchId = $row['id'];
                $branchName = $row['name'];

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
<?php
if (isset($_REQUEST['branchId'])) {
    $branch_Id = $_REQUEST['branchId'];
    $getBatchData = $batch->getBatch('yes', $branch_Id, 0);
    if ($branch_Id > 0) {
        echo "<form action='' method='post'>";
        echo "<select name='batchId'>";
        echo "<option value='-2'>Select Batch</option>";
        if ($getBatchData == true) {
            while ($array = $getBatchData->fetch_assoc()) {
                $batchId = $array['batchId'];
                $batchName = $array['batchName'];

                if ($batchId == $_REQUEST['batchId']) {
                    echo "<option value='" . $batchId . "' selected>" . $batchName . "</option>";
                } else {
                    echo "<option value='" . $batchId . "'>" . $batchName . "</option>";
                }
            }
        } else {
            echo Constants::STATUS_FAILED;
        }
        echo "</select>";
        echo "<input type='hidden' name='branchId' value='" . $branch_Id . "'>";
        echo "<input type='submit' value='Submit'>";
        echo "</form>";
    } else {
        echo "Select valid Branch/Department";
    }
} else {
    echo "Select Appropriate Branch/Department<br>";
}

if (isset($_REQUEST['branchId']) && isset($_REQUEST['batchId'])) {
    $branch_id = $_REQUEST['branchId'];
    $batch_id = $_REQUEST['batchId'];

    if ($branch_id > 0 && $batch_id > 0) {
        echo "<form action='insert_course.php' method='post'>";
        echo "<input type='hidden' name='branch_id' value='" . $branch_id . "'>";
        echo "<input type='hidden' name='batch_id' value='" . $batch_id . "'>";
        echo "<input type='text' name='courseName' placeholder='Enter Course Name'>";
        echo "<br>";
        echo "<input type='submit' value='Submit'>";
        echo "</form>";
    } else {
        echo "Select valid Batch";
    }
} else {
    echo "<br>Select Appropriate Batch<br><br>";
}

echo "List of Courses";

$getCourseData = $course->getCourse('no', 0, 'yes', 0, 0);
if ($getCourseData != false) {
    $id = 1;
    echo "<table border='3'>";
    echo "<tr><th>Sr. no.</th><th>Branch Name</th><th>Batch Name</th><th>Course Name</th><th>Edit</th><th>Delete</th></tr>";
    while ($rowData = $getCourseData->fetch_assoc()) {
        $_branchId = $rowData['branchId'];
        $_branchName = $rowData['branchName'];
        $_batchId = $rowData['batchId'];
        $_batchName = $rowData['batchName'];
        $_courseId = $rowData['courseId'];
        $_courseName = $rowData['courseName'];
        echo "<tr><td>" . $id . "</td><td>" . $_branchName . "</td><td>" . $_batchName . "</td><td>" . $_courseName . "</td>
        <td><form action='editCourse.php' method='post'><input type='hidden' name='branchId' value='" . $_branchId . "'>
        <input type='hidden' name='batchId' value='" . $_batchId . "'>
        <input type='hidden' name='courseId' value='" . $_courseId . "'>
        <input type='submit' value='Edit'></form></td><td>
        <form action='delete_course.php' method='post'><input type='hidden' name='courseId' value='" . $_courseId . "'><input type='submit' value='Delete'></form></td></tr>";
        $id++;
    }
    echo "</table>";
} else {
    echo "<br>No Records Found";
}
?>
</body>
</html>