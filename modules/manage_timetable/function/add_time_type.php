<?php
include("../../../Resources/sessions.php");
$user_id=$_SESSION['id'];
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/TimeType.php");
$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);
$timetype=new TimeType($dbconnect->getInstance());
?>
<html>
<body>
<form action="add_time_type.php" method="post">
<input type="text" name="type">
<input type="submit" name="submit" value="Submit">
</form>


<table>
<tr>
<th>Sr No.</th>
<th>Type </th>
<th>Delete </th>
</tr>
<?php
$result=$timetype->getTimeType(0);
if($result!=null)
{
	$i=1;
	while($row=$result->fetch_assoc())
	{
		echo '<tr><td>'.$i.'</td><td>'.$row['name'].'</td>
		<td><a href=delete_time_type.php?id='.$row['id'].' onclick="ConfirmDelete()">Delete</a></td></tr>';
		$i=$i+1;
	}
}
?>

</table>
 <script type="text/javascript">
      function ConfirmDelete()
      {
            if (confirm("Are you sure you want to delete?"))
                 location.href='delete.php';
      }
  </script>
</body>
</html>