<?php
session_start();
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Submission.php");
require_once("../../manage_course/classes/Course.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$user_id=$_SESSION["id"];
$submission=new Submission($dbconnect->getInstance());
$course=new Course($dbconnect->getInstance());
$courses_result=$course->getCourse('no',$user_id,'no');
	echo '<table>
							<tr>
							<th>No.</th>
							<th>Course</th>
							<th>Title</th>
							<th>File</th>
							</tr>';
	if($courses_result!=null)
	{
		while($rowCourses=$courses_result->fetch_assoc())
		{
			$result=$submission->getSubmission($rowCourses['course_id']);
			if($result!=null)
			{	$no=1;
				while($row=$result->fetch_assoc())
				{
					
				echo '<tr><td>'.$no.'</td><td>'.$rowCourses['name'].'</td><td>'.$row['title'].'</td><td><a href='.$row['file'].'>File</a></td><td>'.$row['date_of_submission'].'</td><td>'.$row['date_of_upload'].'</td>';
					echo '</tr>';
					$no=$no+1;
				}
			}
		}	
	}
echo '</table>';
	


?>