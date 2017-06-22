<html>
<body>
<form action="save_answer.php" method="post">
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
if(isset($_REQUEST["test_id"])){
    if(!$test->checkValidTest($student_id,$_REQUEST["test_id"])) {
        $result = $test->getTestQuestions($_REQUEST["test_id"], $student_id);
        if ($result != null) {
            ?>
            <input type="hidden" id="test_id" name="test_id" value=<? echo $_REQUEST["test_id"]; ?>>
            <?
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                echo $i . '. ' . $row["question"] . ' Marks:' . $row["marks"] . '<br>';
                echo '<input type="radio" id="' . $row["id"] . '" name="' . $row["id"] . '" value="1" required>' . $row["option1"];
                echo '<input type="radio" id="' . $row["id"] . '" name="' . $row["id"] . '" value="2" required>' . $row["option2"];
                echo '<input type="radio" id="' . $row["id"] . '" name="' . $row["id"] . '" value="3" required>' . $row["option3"];
                echo '<input type="radio" id="' . $row["id"] . '" name="' . $row["id"] . '" value="4" required>' . $row["option4"] . '<br>';
                $i++;
            }
            echo '<button type="submit">Submit</button>';
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
</form>
</body>
</html>
