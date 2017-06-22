<?php
include("../../../Resources/sessions.php");
$user_id=$_SESSION['id'];
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/TimeTimetable.php");
require_once("../classes/TimeType.php");
$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);
$timetimetable=new TimeTimetable($dbconnect->getInstance());
?>
<html>
<body>
<form action="insert_time_timetable.php" method="post">
<input type="time" name="from_time">
<input type="time" name="to_time">
<?php
$timetype=new TimeType($dbconnect->getInstance());
echo '<select name=type>';
echo '<option value=0>Select</option>';
$result=$timetype->getTimeType(0);
if($result!=null)
{
	$i=1;
	while($row=$result->fetch_assoc())
	{
		echo '<option value='.$row['id'].'>'.$row['name'].'</option>';
	}
}
?>
<input type="submit" name="submit" value="Submit">
</form>

<table>
<tr>
<th>Sr No.</th>
<th>From Time  </th>
<th>To Time  </th>
<th>Type Time  </th>
<th>Delete  </th>
</tr>
<?php
$result=$timetimetable->getTimeTimetable(0);
if($result!=null)
{
	$i=1;
	while($row=$result->fetch_assoc())
	{ 
		echo '<tr><td>'.$i.'</td><td>'.$row['from_time'].'</td><td>'.$row['to_time'].'</td>';
			$result_type=$timetype->getTimeType($row['type']);
			{
				if($result != null)
				{
					while($row_type=$result_type->fetch_assoc())
					{
						$time_type=$row_type['name'];
					
					}
				}
			}
		echo '<td>'.$time_type.'</td><td><a href=delete_time_timetable.php?id='.$row['id'].' onclick="ConfirmDelete()">Delete</a></td></tr>';
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