<?php
session_start();
$user_id=$_SESSION['id'];
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Syllabus.php");
require_once("../../manage_course/classes/Course.php");
$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$syllabus=new Syllabus($dbconnect->getInstance());
$course=new COurse($dbconnect->getInstance());
?>
<html>
<body>
<form method="post" action="insert_syllabus.php" enctype="multipart/form-data"> 
	file:<input type="file" name="fileToUpload" >
	<?php
		$result=$course->getCourse("yes",$user_id,'no');
		echo "Course:<select name='course'>";
		echo "<option value=0>Select</option>";
		if($result!=null)
		{
			while($row=$result->fetch_assoc())
			{
				echo "<option value=".$row['courseId'].">".$row['courseName']."</option>";
			}
		}
	?>

	<input type="submit" name="submit" value="Add">
	</select>
</form>

<?php
	$courses_result=$course->getCourse("yes",$user_id,'no');
	echo '<table>
							<tr>
							<th>No.</th>
							<th>course</th>
							<th>Title</th>
							<th>File</th>
							<th>Delete</th>
							</tr>';
	if($courses_result!=null)
	{
		while($rowCourses=$courses_result->fetch_assoc())
		{
			$result=$syllabus->getSyllabus($rowCourses['courseId']);
			if($result!=null)
			{	$no=1;
				while($row=$result->fetch_assoc())
				{
					
					echo '<tr><td>'.$no.'</td><td>'.$rowCourses['courseName'].'</td>';
						echo '<td><a href='.$row['file'].'>File</a></td>';
						echo '<td><form action=delete.php method=post><input type=hidden name=file value='.$row['file'].'><input type=hidden name=id value='.$row['id'].'><input type=submit name=delete value=Delete></td></form>
							</tr>';
						$no=$no+1;
				}
			}
		}	
	}
echo '</table>';
	
?>



</body>
</html>
