<html>
<head>
    <style>
        span.correct{
            color: green;
        }
        span.wrong{
            color: red;
        }
    </style>
</head>
<body>
<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/StudentTest.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

include("../../../Resources/sessions.php");

$student_id = $id;
$test = new StudentTest($dbConnect->getInstance());
if(isset($_REQUEST["test_id"]) && is_numeric($_REQUEST["marks"])){
    if($test->checkValidTest($student_id,$_REQUEST["test_id"])) {
        $total_marks = 0 ;
        $result = $test->getTestAnswers($_REQUEST["test_id"], $student_id);
        if ($result != null) {
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                echo 'Q.' . $i . '. ' . $row["question"] . ' Marks:' . $row["marks"] . '<br>';
                echo '<span class=' . (($row["answer"] == 1)?('"correct">'):((($row["option_id"] == 1)?('"wrong">'):('"">')))) . '1) ' . $row["option1"] . '</span>&nbsp;&nbsp;&nbsp;' .
                     '<span class=' . (($row["answer"] == 2)?('"correct">'):((($row["option_id"] == 2)?('"wrong">'):('"">')))) . '2) ' . $row["option2"] . '</span>&nbsp;&nbsp;&nbsp;' .
                     '<span class=' . (($row["answer"] == 3)?('"correct">'):((($row["option_id"] == 3)?('"wrong">'):('"">')))) . '3) ' . $row["option3"] . '</span>&nbsp;&nbsp;&nbsp;' .
                     '<span class=' . (($row["answer"] == 4)?('"correct">'):((($row["option_id"] == 4)?('"wrong">'):('"">')))) . '4) ' . $row["option4"] . '</span><br><br>';
                $i++;
                if($row["answer"] == $row["option_id"]){
                    $total_marks += $row["marks"];
                }
            }
            echo 'Marks Obtained: ' . $total_marks . ' out of ' . $_REQUEST["marks"];
        } else {
            $test->parentRedirect("Error processing the request");
        }
    }else{
        $test->parentRedirect("Error processing the request");
    }
}else{
    $test->parentRedirect("Error processing the request");
}
?>
</body>
</html>
