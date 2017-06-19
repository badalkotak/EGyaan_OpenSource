<?php
include("../../../Resources/sessions.php");

$user_id=$_SESSION['id'];
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Notes.php");
require_once("../../manage_course/classes/Course.php");
// require_once("../../manage_teacher_course/classes/TeacherCourse.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$notes=new Notes($dbconnect->getInstance());
$course=new Course($dbconnect->getInstance());
?>
<html>
<body>
<form method="post" action="insert_notes.php" enctype="multipart/form-data"> 
	Title:<input type="text" name="title">
	file:<input type="file" name="fileToUpload" >
	Downloadable:<input type="checkbox" name="downloadable" value="Yes">
	
	<?php
	$getTeacherCourse=$course->getCourse("yes",$user_id,"no",0,0);
	if($getTeacherCourse===false)
	{
		$result=$course->getCourse("no",0,'no',0,0);	
	}
	else
	{
		$result=$course->getCourse("yes",$user_id,"no",0,0);
	}
		// $result=$course->getCourse("yes",$id,'no',0,0);
		echo "Course:<select name='course'>";
		echo "<option value=0>Select</option>";
		if($result!=null)
		{
			while($row=$result->fetch_assoc())
			{
				echo "<option value=".$row['courseId'].">".$row['branchName']." - ".$row['batchName']." - ".$row['courseName']."</option>";
			}
		}
	?>
	<input type="submit" name="submit" value="Add">
	</select>
</form>

<?php

	$getTeacherCourse=$course->getCourse("yes",$id,"no",0,0);
	if($getTeacherCourse===false)
	{
		$courses_result=$course->getCourse("no",0,'no',0,0);	
	}
	else
	{
		$courses_result=$course->getCourse("yes",$id,"no",0,0);
	}

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
			$result=$notes->getNotes($rowCourses['courseId']);
			if($result!=null)
			{	$no=1;
				while($row=$result->fetch_assoc())
				{
					
					echo '<tr><td>'.$no.'</td><td>'.$rowCourses['courseName'].'</td>';
					echo '<td>'.$row['title'].'</td>';
					echo '<td><a href='.$row['file'].'>File</a></td>';
					echo '<td><form action=delete.php method=post><input type=hidden name=file value='.$row['file'].'><input type=hidden name=id value='.$row['id'].'><input type=submit name=delete value=Delete></td></form>
						</tr>';
						$no=$no+1;
				}
			}
		}	
	}
	else
	{
		echo "Null";
	}
echo '</table>';
	
?>

</body>
</html>
