<?php

class StudentTest
{
    private $connection;
    function __construct($connection){
        $this->connection=$connection;
    }

    public function getTests($student_id)
    {
        $sql="  SELECT DISTINCT t.id,title,total_marks,date_of_test,type,c.name,'-' as marks
                FROM egn_test as t ,egn_course as c ,egn_student as s ,egn_course_reg as cr 
                WHERE cr.student_id = s.id AND t.course_id = c.id AND cr.course_id = c.id AND s.id='$student_id' AND 
                t.id NOT IN (   SELECT m.test_id
                                FROM egn_test_marks as m
                                WHERE m.student_id = '$student_id')
                UNION
                SELECT DISTINCT t.id,title,total_marks,date_of_test,type,c.name,marks
                FROM egn_test as t ,egn_course as c ,egn_student as s ,egn_course_reg as cr,egn_test_marks as m
                WHERE cr.student_id = s.id AND t.course_id = c.id AND cr.course_id = c.id AND m.student_id = s.id AND m.test_id = t.id AND s.id = '$student_id' AND 
                t.id IN (   SELECT m.test_id
                                FROM egn_test_marks as m
                                WHERE m.student_id = '$student_id')
                ORDER BY name,date_of_test,title";
        $result = $this->connection->query($sql);
        if($result->num_rows > 0)
        {
            return $result;
        }
        else
        {
            return null;
        }
    }
    public function getTestQuestions($test_id,$student_id){
        $sql="  SELECT DISTINCT q.id,question,option1,option2,option3,option4,marks
                FROM egn_test as t ,egn_course as c ,egn_student as s ,egn_course_reg as cr,egn_test_questions as q
                WHERE cr.student_id = s.id AND t.course_id = c.id AND cr.course_id = c.id AND s.id='$student_id' AND q.test_id='$test_id' AND t.type='O' AND
                                t.id NOT IN (   SELECT m.test_id
                                FROM egn_test_marks as m
                                WHERE m.student_id = '$student_id' AND m.test_id='$test_id')
                ORDER BY id";
        $result = $this->connection->query($sql);
        if($result->num_rows > 0)
        {
            return $result;
        }
        else
        {
            return null;
        }
    }
    public function getTestQuestionIds($test_id,$student_id){
        $sql="  SELECT DISTINCT q.id,q.answer,marks
                FROM egn_test as t ,egn_course as c ,egn_student as s ,egn_course_reg as cr,egn_test_questions as q
                WHERE cr.student_id = s.id AND t.course_id = c.id AND cr.course_id = c.id AND s.id='$student_id' AND q.test_id='$test_id' AND t.type='O' AND
                                t.id NOT IN (   SELECT m.test_id
                                FROM egn_test_marks as m
                                WHERE m.student_id = '$student_id' AND m.test_id='$test_id')
                ORDER BY id";
        $result = $this->connection->query($sql);
        if($result->num_rows > 0)
        {
            return $result;
        }
        else
        {
            return null;
        }
    }

    public function createAnswerQuery($student_id,$question_id,$option_id){
        $sql = "INSERT INTO `egn_test_answers` (`id`, `student_id`, `question_id`, `option_id`) 
                VALUES (NULL, '$student_id', '$question_id', '$option_id');";
        return $sql;
    }

    public function insertMarks($student_id,$test_id,$marks_obtained){
        $sql = "INSERT INTO `egn_test_marks` (`id`, `student_id`, `test_id`, `marks`) 
                VALUES (NULL, '$student_id', '$test_id', '$marks_obtained');";
        $insert = $this->connection->query($sql);
        if($insert === true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function insertAnswers($sql){
        $insert = $this->connection->multi_query($sql);
        if($insert === true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function deleteEntries($student_id,$test_id){
        $sql = "DELETE FROM egn_test_answers WHERE student_id = '$student_id' AND question_id IN (SELECT q.id FROM egn_test_questions as q WHERE q.test_id = '$test_id')";
        $this->connection->query($sql);
        $sql = "DELETE FROM egn_test_marks WHERE student_id = $student_id AND test_id = $test_id";
        return $this->connection->query($sql);
    }

    public function checkValidTest($student_id,$test_id){
        $sql = "  SELECT m.test_id
                  FROM egn_test_marks as m
                  WHERE m.student_id = '$student_id' AND m.test_id = '$test_id'";
        $result = $this->connection->query($sql);
        if($result->num_rows > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getTestAnswers($test_id,$student_id){
        $sql = "SELECT q.id,question,option1,option2,option3,option4,option_id,answer,marks
                FROM egn_test_answers as a ,egn_test_questions as q
                WHERE a.question_id=q.id AND a.student_id='$student_id' AND q.test_id = '$test_id'
                ORDER BY q.id";
        $result = $this->connection->query($sql);
        if($result->num_rows > 0)
        {
            return $result;
        }
        else
        {
            return null;
        }
    }

    public function parentRedirect($message){
        //header("location: manage_student_test.php?message=" . $message);
        return "<script>alert('" .  $message . "');window.location.href='manage_student_test.php'</script>";
    }

}