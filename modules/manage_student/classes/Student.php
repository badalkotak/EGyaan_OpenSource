<?php

include("../../../classes/Constants.php");

class Student
{
	private $connection;

    function __construct($connection){
        $this->connection = $connection;
    }

    public function getStudent()
    {
    	$sql="SELECT * FROM egn_student";
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

// In case of multiple inserts, you need to check whether or not each insert query is being executed, if it is executed only then execute the next query, or else if a particular query is not executed, first delete all the previous RELATED INSERT queries and then return false.
    public function insertStudent($firstname, $lastname, $email, $student_passwd, $mobile, $gender, $parent_name,
                                  $parent_email, $parent_passwd, $total_fees, $fees_paid, $fees_comment,
                                  $date_of_admission, $parent_mobile, $student_profile_photo, $parent_profile_photo,
                                  $batch_id)
    {
        $sql="SELECT * FROM `egn_student` WHERE name='$email'";
        $result = $this->connection->query($sql);

        if($result->num_rows == 0)
        {
            $insert_sql="INSERT INTO `egn_student`(`firstname`, `lastname`, `email`, `student_passwd`,
 `mobile`, `gender`, `parent_name`, `parent_email`, `parent_passwd`, `total_fees`, `fees_paid`, 
 `fees_comment`, `date_of_admission`, `parent_mobile`, `student_profile_photo`, `parent_profile_photo`, 
 `batch_id`) VALUES ('$firstname', '$lastname', '$email', '$student_passwd', '$mobile', '$gender', '$parent_name',
                                  '$parent_email', '$parent_passwd', '$total_fees', '$fees_paid', '$fees_comment',
                                  '$date_of_admission', '$parent_mobile', '$student_profile_photo', '$parent_profile_photo',
                                  '$batch_id')";
            $insert=$this->connection->query($insert_sql);
            if($insert === true)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            $message=Constants::STATUS_EXISTS;
            return $message;
        }
    }

    public function updateStudent($id,$firstname, $lastname, $email, $student_passwd, $mobile, $gender, $parent_name,
                                  $parent_email, $parent_passwd, $total_fees, $fees_paid, $fees_comment,
                                  $date_of_admission, $parent_mobile, $student_profile_photo, $parent_profile_photo,
                                  $batch_id)
    {
        $sql="UPDATE `egn_student` SET `firstname`='$firstname',`lastname`='$lastname',
`email`='$email',`student_passwd`='$student_passwd',`mobile`='$mobile',`gender`='$gender',`parent_name`='$parent_name',
`parent_email`='$parent_email',`parent_passwd`='$parent_passwd',`total_fees`='$total_fees',`fees_paid`='$fees_paid',
`fees_comment`='$fees_comment',`date_of_admission`='$date_of_admission',`parent_mobile`='$parent_mobile',
`student_profile_photo`='$student_profile_photo',`parent_profile_photo`='$parent_profile_photo',`batch_id`='$batch_id'
 WHERE id='$id'";
        $update=$this->connection->query($sql);

        if($update===true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function deleteStudent($id)
    {
        $sql="DELETE FROM `egn_student` WHERE id='$id'";
        $delete=$this->connection->query($sql);

        if($delete===true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>