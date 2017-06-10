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
$teacher_id = 1; //To Do: Change This
if(isset($_REQUEST["message"]) && !empty(trim($_REQUEST["message"]))){
    echo $_REQUEST["message"];
}
$test = new Test($dbConnect->getInstance());
$result=$test->getTestsByTeacher($teacher_id);
if($result!=null)
{
    ?>
    <table>
        <thead>
        <tr>
            <th>Sr No.</th>
            <th>Title</th>
            <th>Marks</th>
            <th>Date of Test</th>
            <th>Date of Result</th>
            <th>Type</th>
            <th>Course name</th>
            <th>Edit Marks</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
    <?
    $i=1;
    while($row=$result->fetch_assoc())
    {
        echo '  <tr id =' . $row["id"] . '>
                    <td>' . $i . '</td>
                    <td>' . $row["title"] . '</td>
                    <td>' . $row["total_marks"]  . '</td>
                    <td>' . $row["date_of_test"]  . '</td>
                    <td>' . $row["date_of_result"]  . '</td>
                    <td>' . (($row["type"] == 'O')?'Online':'Offline') . '</td>
                    <td>' . $row["name"]  . '</td>
                    <td>' . (($row["type"] == 'O')?'NA':(($row["status"] == 0)?'<a href="add_marks_offline_test.php?id=' . $row["id"] . '&action=add">Add</a>':'<a href="add_marks_offline_test.php?id=' . $row["id"] . '&action=edit">Edit</a>')) . '</td>
                    <td><a href="delete_test.php?id=' . $row["id"] . '">Delete</a></td>
                  </tr>';
    }
    ?>
        </tbody>
    </table>
    <?
}
else
{
    echo "No test added yet!!";
}
?>
<a href="add_test.php">Add Test</a>

</body>
</html>