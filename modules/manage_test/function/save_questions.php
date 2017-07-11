<html>
<body>
<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Test.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

include("privilege.php");

if($add!=true)
{
    $message=Constants::NO_PRIVILEGE;
    echo "<script>alert('$message');window.location.href='../../login/functions/logout.php'</script>";
}

$teacher_id = $id;
$test = new Test($dbConnect->getInstance());
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $test_id = $test->insertTest($_POST['title'], $_POST['total_marks'], $_POST['date'], $_POST['course_id'], $teacher_id, $_POST['type']);
    $total_marks = $_POST['total_marks'];
    $error_flag = 0;
    if (is_numeric($test_id) && $test_id > 0) {
        $question_query = "";
        for ($x = 1; $x <= $_POST["index"]; $x++) {
            $question = $_POST["question" . $x];
            $marks = $_POST["question" . $x . "_marks"];
            $answer = $_POST["answer" . $x];
            $option1 = $_POST["option" . $x . "_1"];
            $option2 = $_POST["option" . $x . "_2"];
            $option3 = $_POST["option" . $x . "_3"];
            $option4 = $_POST["option" . $x . "_4"];
            $total_marks = $total_marks - $marks;
            $question_input_check = $test->checkQuestionDetails($question, $option1, $option2, $option3, $option4, $answer, $marks);
            if ($question_input_check == true && $total_marks >= 0) {
                $question_query = $question_query . $test->createQuestionQuery($question, $option1, $option2, $option3, $option4, $answer, $marks, $test_id);
            } else {
                $error_flag = 1;
                break;
            }
        }
        if ($error_flag != 1) {
            if ($test->insertQuestion($question_query)) {
                echo $test->parentPageRedirect("Test added successfully");
            } else {
                $test->deleteTest($test_id, $teacher_id); //Deleted all records related to test_id
                echo $test->parentPageRedirect("Error while processing"); //Error while inserting questions into database
            }
        } else {
            $test->deleteTest($test_id, $teacher_id);
            echo $test->parentPageRedirect("Error while processing");
        }
    } else {
        if ($test_id == null) {
            echo $test->parentPageRedirect("Error while processing"); //Error generated while inserting test details
        } else {
            echo $test->parentPageRedirect($test_id); //Duplicate test entry
        }
    }
}else{
    echo $test->parentPageRedirect("Error while processing");
}
?>