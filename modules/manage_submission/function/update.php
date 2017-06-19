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

if(empty($_REQUEST['course_name']) || empty($_REQUEST['title']) || empty($_REQUEST['dateOfSubmission']))
{
	echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Inputs Cannot be Empty')
        window.location.href='insert_page.php';
        </SCRIPT>");
	
}
else
{
	$course_name=$_REQUEST["course_name"];
	$course_id=$_REQUEST["course_id"];
	$file=$_REQUEST["file"];
	$title=$_REQUEST["title"];
	$date_of_submission=$_REQUEST['dateOfSubmission'];
	// $date_of_upload=$_REQUEST['dateOfUpload'];
}
 
 ?>
 <html>
<body>
<form method="post" action="updateSubmission.php" enctype="multipart/form-data"> 
	Title:<input type="text" name="title" value=<?php echo "$title"; ?>>
	file:<input type="file" name="fileToUpload" > <?php echo "<a href=$file>Current File</a>" ?>
	Date Of Submission:<input type="date" name="dateOfSubmission" value="<?php echo $date_of_submission; ?>" required>
	<!-- Date Of Upload:<input type="date" name="dateOfUpload" value="<?php echo $date_of_upload; ?>" required> -->
	
	<input type=hidden name=file value="<?php echo $file; ?>">
	<input type=hidden name=id value="<?php echo $_REQUEST['id'] ?>">
	
	<?php
	// $result=$course->getCourse("yes",$user_id,'no');
	$getTeacherCourse=$course->getCourse("yes",$user_id,"no",0,0,null);
	if($getTeacherCourse===false)
	{
		$result=$course->getCourse("no",0,'no',0,0,null);	
	}
	else
	{
		$result=$course->getCourse("yes",$user_id,"no",0,0,null);
	}
		echo "Course:<select name='course'>
		<option value=0>Select</option>";
		if($result!=null)
		{
			while($row=$result->fetch_assoc())
			{
				if($row['courseId']==$course_id)
				{
				echo "<option value=".$row['courseId']." selected>".$row['branchName']." - ".$row['batchName']." - ".$row['courseName']."</option>";
				}
				else
				{
					echo "<option value=".$row['courseId'].">".$row['branchName']." - ".$row['batchName']." - ".$row['courseName']."</option>";
				}
			}
		}
	?>
	<input type="submit" name="submit" value="Add">
	</select>
</form>