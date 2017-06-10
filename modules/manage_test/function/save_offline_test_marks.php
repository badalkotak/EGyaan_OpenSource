<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Test.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
$teacher_id = 1; //To Do: Change This
$test = new Test($dbConnect->getInstance());
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $result = $test->getStudentList($_POST["test_id"],$teacher_id);
    $marks_query = "";
    if($result != null){
        while($row = $result->fetch_assoc()){
            if(is_numeric($_POST[$row["id"]]) && $_POST[$row["id"]]>0){
                if($_POST["action"] == "add"){
                    $marks_query = $marks_query . $test->createInsertMarksQuery($row["id"],$_POST["test_id"],$_POST[$row["id"]]);
                }else{
                    $marks_query = $marks_query . $test->createUpdateMarksQuery($row["id"],$_POST["test_id"],$_POST[$row["id"]]);
                }
            }else{
                $test->parentPageRedirect("Marks should be greater than or equal to zero");
            }
        }
        if($_POST["action"] == "add"){
            $status = $test->insertMarks($marks_query);
        }else{
            $status = $test->updateMarks($marks_query);
        }
        if ($status) {
            $test->parentPageRedirect("Marks updated successfully");
        } else {
            $test->parentPageRedirect("Error processing the request");
        }
    }else{
        $test->parentPageRedirect("Error processing request");
    }
}else{
    $test->parentPageRedirect("Error processing request");
}
?>