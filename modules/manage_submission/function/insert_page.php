<?php
session_start();
$user_id=$_SESSION['id'];
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Submission.php");
require_once("../../manage_course/classes/Course.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$submission=new Submission($dbconnect->getInstance());
$course=new Course($dbconnect->getInstance());
?>
<html>
<body>
<form method="post" action="insert_submission.php" enctype="multipart/form-data"> 
	Title:<input type="text" name="title" required>
	file:<input type="file" name="fileToUpload" required>
	Date Of Submission:<input type="date" name="dateOfSubmission" required>
	Date Of Upload:<input type="date" name="dateOfUpload" required>
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
		<th>Date Of Submission</th>
		<th>Date Of Upload</th>
		<th>Update</th>
		<th>Delete</th>
		</tr>';
	if($courses_result!=null)
	{
		while($rowCourses=$courses_result->fetch_assoc())
		{
			$result=$submission->getSubmission($rowCourses['courseId']);
			if($result!=null)
			{	$no=1;
				while($row=$result->fetch_assoc())
				{
					
					echo '<tr><td>'.$no.'</td><td>'.$rowCourses['courseName'].'</td><td>'.$row['title'].'</td><td><a href='.$row['file'].'>File</a></td><td>'.$row['date_of_submission'].'</td><td>'.$row['date_of_upload'].'</td>';

						echo '<td><form action="update.php" method="post"><input type=hidden name=id value='.$row['id'].'><input type=hidden name=title value='.$row['title'].'><input type=hidden name=file value='.$row['file'].'><input type=hidden name=dateOfSubmission value='.$row['date_of_submission'].'><input type=hidden name=dateOfUpload value='.$row['date_of_upload'].'><input type=hidden name=course_id value='.$rowCourses['courseId'].'><input type=hidden name=course_name value='.$rowCourses['courseName'].'><input type=submit name=submit value=Update></form></td>
						<td><form action=delete.php method=post><input type=hidden name=file value='.$row['file'].'><input type=hidden name=id value='.$row['id'].'><input type=submit name=delete value=Delete></td></form>
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
