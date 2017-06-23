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

include("../../../Resources/sessions.php");

$teacher_id = $id;
$test = new Test($dbConnect->getInstance());
if(isset($_REQUEST["id"]) && isset($_REQUEST["type"]) && isset($_REQUEST["marks"])){
    if($test->checkMarksEntered($_REQUEST["id"],"edit")) {
        $result = $test->getStudentList($_REQUEST["id"], $teacher_id,$_REQUEST["type"]);
        if ($result != null) {
            ?>
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Marks</th>
                    <? echo ($_REQUEST["type"] == "O")?'<th>View</th>':''; ?>
                </tr>
                </thead>
                <tbody>
                <?
                while ($row = $result->fetch_assoc()) {
                    $answer_page = '<td><a href="view_answer_by_teacher.php?student_id=' . $row["id"] . '&test_id=' . $_REQUEST["id"] . '&marks='. $_REQUEST["marks"] . '">View</a></td>';
                    echo '<tr>
                    <td>' . $row["firstname"] . ' ' . $row["lastname"] . '</td>
                    <td>' . $row["marks"] . ' out of  ' . $row["total_marks"] . '</td>'
                    . (($_REQUEST["type"] == "O")?($answer_page):('')) .
                  '</tr>';
                }
                ?>
                </tbody>
            </table>
            <?
        } else {
            $test->parentPageRedirect("Error processing request");
        }
    }else{
        $test->parentPageRedirect("Marks not entered/Error processing request");
    }
}else{
    $test->parentPageRedirect("Error processing request");
}
?>
</body>
</html>
