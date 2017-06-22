<html>
<body>
<form action="save_offline_test_marks.php" method="post">
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
if(isset($_REQUEST["id"]) && isset($_REQUEST["action"])){
    if($test->checkMarksEntered($_REQUEST["id"],$_REQUEST["action"])) {
        $result = $test->getStudentList($_REQUEST["id"], $teacher_id);
        if ($result != null) {
            ?>
            <input type="hidden" name="test_id" value="<? echo $_REQUEST["id"]; ?>">
            <input type="hidden" name="action" value="<? echo $_REQUEST["action"]; ?>">
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Marks</th>
                </tr>
                </thead>
                <tbody>
                <?
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                        <td>' . $row["firstname"] . ' ' . $row["lastname"] . '</td>
                        <td><input type="number" name="' . $row["id"] . '" value="' . (($row["marks"] != NULL) ? $row["marks"] : '0') . '" min="1" max="' . $row["total_marks"] . '" required></td>
                      </tr>';
                }
                ?>
                </tbody>
            </table>
            <button type="submit">Save</button>
            <?
        } else {
            $test->parentPageRedirect("Error processing request");
        }
    }else{
        $test->parentPageRedirect("Error processing request");
    }
}else{
    $test->parentPageRedirect("Error processing request");
}
?>
</form>
</body>
</html>
