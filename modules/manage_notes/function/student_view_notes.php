<?php
session_start();
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Notes.php");
require_once("../../manage_course/classes/Course.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$user_id=$_SESSION["id"];
$notes=new Notes($dbconnect->getInstance());
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
			$result=$notes->getNotes($rowCourses['course_id']);
			if($result!=null)
			{	$no=1;
				while($row=$result->fetch_assoc())
				{
					
					echo '<tr><td>'.$no.'</td><td>'.$rowCourses['name'].'</td>';
					echo '<td>'.$row['title'].'</td>';
					echo '<td><a href='.$row['file'].'>File</a></td>';
					echo '</tr>';
						$no=$no+1;
				}
			}
		}	
	}
echo '</table>';
	


?>