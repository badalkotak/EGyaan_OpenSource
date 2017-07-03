<?php
/**
 * Created by PhpStorm.
 * User: akash
 * Date: 3/7/17
 * Time: 10:55 AM
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
?>
<html>
<body>
<form action="add_attendance.php" method="post">
    <input type="date" name="date">
    <select name="timetableId">
        <option value="-1">Select Course</option>
        <?php
        if(isset($_REQUEST['batchId']) && isset($_REQUEST['branchId'])) {
            $batchId = $_REQUEST['batchId'];
            $timetable = $attendance->getTimetable($batchId,$id);
            if($timetable!=null){
                while($array = $timetable->fetch_assoc()){
                    $timetableId = $array['timetableId'];
                    $courseName=$array['courseName'];
                    $userName=$array['userName'];
                    $userCourse=$userName."-".$courseName;
                    echo "<option value = $timetableId>".$userCourse."</option>";
                }
            }
        }
        ?>
    </select>
    <table border="1">
        <tr>
            <th>Student</th>
            <th>P/A</th>
        </tr>
        <?php
        $studentData = $student->getStudent(0,$batchId);
        if($studentData!=false){
            while($studArray=$studentData->fetch_assoc()){
                $studId=$studArray['id'];
                $studFName=$studArray['firstname'];
                $studLName=$studArray['lastname'];
                $studName=$studFName." ".$studLName;
                echo "<tr><td>$studName</td><td><input type='checkbox' name='attendees[]' id='attendees' value='" . $studId . "'/></td></tr>";
            }
        }
        ?>
    </table>
    <input type="submit" value="Submit"/>
</form>
</body>
</html>