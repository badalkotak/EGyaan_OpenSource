<html>
<head>
    <style>
        span.correct{
            color: green;
        }
    </style>
</head>
<body>
<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Test.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

include("../../../Resources/sessions.php");

$teacher_id = $id;
$test = new Test($dbConnect->getInstance());
if(isset($_REQUEST["id"]) && isset($_REQUEST["type"])){
    if($_REQUEST["type"] == 'F'){
        if(file_exists("offline_test/" . $_REQUEST["id"] . ".pdf")){
            header("Location: offline_test/" . $_REQUEST["id"] . ".pdf");
        }else{
            $test->parentPageRedirect("Error processing request");
        }
    }elseif($_REQUEST["type"] == 'O'){
        $result = $test->getTestQuestions($_REQUEST["id"]);
        if($result != null){
            $total_marks = 0 ;
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                echo 'Q.' . $i . '. ' . $row["question"] . ' Marks:' . $row["marks"] . '<br>';
                echo '<span class=' . (($row["answer"] == 1)?('"correct">'):('"">')) . '1) ' . $row["option1"] . '</span>&nbsp;&nbsp;&nbsp;' .
                     '<span class=' . (($row["answer"] == 2)?('"correct">'):('"">')) . '2) ' . $row["option2"] . '</span>&nbsp;&nbsp;&nbsp;' .
                     '<span class=' . (($row["answer"] == 3)?('"correct">'):('"">')) . '3) ' . $row["option3"] . '</span>&nbsp;&nbsp;&nbsp;' .
                     '<span class=' . (($row["answer"] == 4)?('"correct">'):('"">')) . '4) ' . $row["option4"] . '</span><br><br>';
                $i++;
                $total_marks += $row["marks"];
            }
            echo 'Total marks:  ' . $total_marks;
        }else{
            $test->parentPageRedirect("Error processing request");
        }
    }else{
        $test->parentPageRedirect("Error processing request");
    }
}else{
    $test->parentPageRedirect("Error processing request");
}
?>
</body>
</html>
