<html>
<head>
    <title>Department - Add Branches|EGyaan</title>
</head>
<body>
<form action="insert_branch.php" method="post">
    <input type="text" name="branch_name" placeholder="Enter Branch Name">
    <br>
    <input type="submit" value="Submit">
</form>
</body>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 4/6/17
 * Time: 5:16 PM
 */
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Branch.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

echo "<br>List of Department - Branches<br>";
$branch = new Branch($dbConnect->getInstance());
$result = $branch->getBranch();

if ($result != null) {
    $i=0;
    echo "<table border='3'>";
    echo "<tr><th>Sr No.</th><th>Name</th><th>Edit</th><th>Delete</th></tr>";
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $name = $row['name'];
        // echo "<tr><td>" . $name . "</td><td><form action='editBranch.php' method='post'>
        // <input type='hidden' value='" . $id . "' name='branchId'><input type='hidden' value='" . $name . "' name='branchName'>
        // <input type='submit' value='Edit'></form></td><td><form action='delete_branch.php' method='post'>
        // <input type='hidden' value='" . $id . "' name='branchId'><input type='hidden' value='" . $name . "' name='branchName'>
        // <input type='submit' value='Delete'></form></td></tr>";

        echo "<tr>";
        $i++;
        echo "<td>";
        echo $i;
        echo "</td>";

        echo "<td>";
        echo $name;
        echo "</td>";

        echo "<td>";
        echo "<form action='editBranch.php' method='get'><input type='submit' value='$id' name='edit'></form>";        
        echo "</td>";

        echo "<td>";
        echo "<form action='delete_branch.php' method='post'><input type='submit' value='$id' name='delete'></form>"; 
        echo "</td>";
    }
    echo "</table>";
} else {
    echo "No Records Found";
}
?>