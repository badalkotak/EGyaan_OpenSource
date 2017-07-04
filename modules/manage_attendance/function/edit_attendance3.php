<?php
/**
 * Created by PhpStorm.
 * User: akash
 * Date: 3/7/17
 * Time: 11:47 PM
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
if(isset($_REQUEST['attendance-id'],$_REQUEST['batch-id'])){
    $attendanceId=$_REQUEST['attendance-id'];
    $batchId=$_REQUEST['batch-id'];
}
$Presult=$attendance->getPAttendees($attendanceId);
$Aresult=$student->getStudent(0,$batchId);
?>
<html>
<body>
<form action="update_attendees.php" method="post">
    <table border="" id="table-stud">
        <tr>
            <th>Student</th>
            <th>P/A</th>
        </tr>
        <?php
        if($Presult!=null &&
            $Aresult->num_rows >0){
            $PAttendees=$Presult->fetch_assoc();
            while($studArray=$Aresult->fetch_assoc()){
                $studId=$studArray['id'];
                $studFName=$studArray['firstname'];
                $studLName=$studArray['lastname'];
                $studName=$studFName." ".$studLName;
                if(in_array($studId,$PAttendees,true)){
                    echo "<tr><td>$studName</td><td><input type='checkbox' name='attendees[]' id='attendees' value='" . $studId . "' checked/></td></tr>";
                } else {
                    echo "<tr><td>$studName</td><td><input type='checkbox' name='attendees[]' id='attendees' value='" . $studId . "'/></td></tr>";
                }
            }
        }
        ?>
    </table>
    <input type="hidden" name="attendanceId" value="<?php echo $attendanceId; ?>"/>
    <input type="submit" value="Update"/>
</form>
</body>
</html>
