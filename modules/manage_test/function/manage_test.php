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
            <th>Edit</th>
            <th>Cancel</th>
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
                    <td>' . (($row["type"] == 'O')?'Offline':'Online') . '</td>
                    <td>' . $row["name"]  . '</td>
                    <td><button id="edit_button" value=' . $row["id"] . ' type="button">Edit</button></td>
                    <td><button id="delete_button" value=' . $row["id"] . ' type="button">Delete</button></td>
                  </tr>';
        $i++;
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