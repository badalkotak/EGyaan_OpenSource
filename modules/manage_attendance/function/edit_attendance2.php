<?php
/**
 * Created by PhpStorm.
 * User: akash
 * Date: 3/7/17
 * Time: 7:26 PM
 */
include("../../../Resources/sessions.php");
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Attendance.php");
require_once("../../manage_student/classes/Student.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
$student = new Student($dbConnect->getInstance());
$attendance = new Attendance($dbConnect->getInstance());
$batchId=$_REQUEST['batchId'];
$result = $attendance->getAttendanceData($batchId, $id);
?>
<html>
<head>
    <script type="text/javascript" src="../../../Resources/jQuery/jquery-3.2.1.js"></script>
</head>
<body>
<form action="edit_attendance3.php" method="post">
    <input type="hidden" name="batch-id" value="<?php echo $batchId; ?>"/>
    <select name="attendance-id" id="attendance-id">
        <option value="-1">Select Attendance</option>
        <?php
        while ($array = $result->fetch_assoc()) {
            echo "<option value=" . $array['aId'] . ">" . $array['aDate'] . " : " . $array['cName'] . "-" . $array['uName'] . "</option>";
        }
        ?>
    </select>
    <input type="submit" value="Apply" id="attendanceApply"/>
</form>
</body>
</html>
