<?php

/**
 * Created by PhpStorm.
 * User: adityajthakker
 * Date: 28/12/16
 * Time: 6:04 PM
 */
class Attendance{
    private $connection;

    function __construct($connection){
        $this->connection = $connection;
    }

    public function markAttendance($date, $timetable_id, $attendees){
        $sql = "insert into egn_attendance (date_of_attendance, timetable_id) values( '".$date."', ".$timetable_id.")";
        $result = $this->connection->query($sql);
        if($result == true){
            $id = mysqli_insert_id($this->connection);
            $values = "";
            for ($i = 0; $i < count($attendees); $i++){
                if($i == (count($attendees) - 1)){
                    $values = $values . "( ".$id.", ".$attendees[$i]." )";
                }else{
                    $values = $values . "( ".$id.", ".$attendees[$i]." ),";
                }
            }
            $sql = "insert into egn_student_attendance(attendance_id, student_id) values " . $values;
            $result = $this->connection->query($sql);
            if($result == true){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}