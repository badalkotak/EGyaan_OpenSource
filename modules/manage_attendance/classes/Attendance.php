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

    public function generateReport(){
        $sql = "select DISTINCT es.firstname, es.lastname, ea.date_of_attendance, ec.name, ec.batch_id, eb.name as batch_name, et.comment, ett.from_time, ett.to_time, ett.type, etty.name from egn_student_attendance as esa, egn_attendance as ea, egn_teacher_course as etc, egn_student as es, egn_course as ec, egn_batch as eb , egn_timetable as et, egn_time_timetable as ett , egn_time_type as etty where ec.id = 1 and ec.batch_id = es.batch_id and etc.course_id = 1 and etc.user_id = 3 and etc.id = et.teacher_course_id and et.id = ea.timetable_id and ea.date_of_attendance BETWEEN '2017-11-11' and '2017-11-13' and esa.student_id = es.id and esa.attendance_id = ea.id and ett.id = et.time_id and etty.id = ett.type";



    }
}