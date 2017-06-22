<html>
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
if(isset($_REQUEST["message"]) && !empty(trim($_REQUEST["message"]))){
    echo $_REQUEST["message"];
}
$test = new StudentTest($dbConnect->getInstance());
$result=$test->getTests($student_id);
if($result!=null)
{
    ?>
    <table>
        <thead>
        <tr>
            <th>Sr No.</th>
            <th>Title</th>
            <th>Date of Test</th>
            <th>Type</th>
            <th>Course name</th>
            <th>Marks Obtained</th>
            <th>Out of</th>
            <th>Give Test</th>
            <th>View Answers</th>
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
                    <td>' . $row["date_of_test"]  . '</td>
                    <td>' . (($row["type"] == 'O')?'Online':'Offline') . '</td>
                    <td>' . $row["name"]  . '</td>
                    <td>' . $row["marks"] . '</td>
                    <td>' .  $row["total_marks"]  . '</td>
                    <td>' . (($row["type"] == 'O')?(($row["marks"]=="-")?'<a href="give_test.php?test_id=' . $row["id"] . '">Start</a>':'Submitted'):'NA') . '</td> 
                    <td>' . (($row["type"] == 'O')?(($row["marks"]=="-")?'-':'<a href="view_answer.php?test_id=' . $row["id"] . '&marks=' .  $row["total_marks"]  . '">View</a>'):'NA') . '</td> 
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

</body>
</html>