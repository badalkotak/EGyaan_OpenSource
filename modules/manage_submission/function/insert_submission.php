<?php
session_start();
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Submission.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$user_id=$_SESSION["id"];
if(empty($_REQUEST['course']) || empty($_FILES['fileToUpload']) || empty($_REQUEST['title']) || empty($_REQUEST['dateOfSubmission']) || empty($_REQUEST['dateOfUpload']) )
{
	$msg=Constants::EMPTY_PARAMETERS;
	echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('$msg')
        window.location.href='insert_page.php';
        </SCRIPT>");
}
else
{
	$course_id=$_REQUEST["course"];
	$title=$_REQUEST['title'];
	$date_of_submission=$_REQUEST['dateOfSubmission'];
	$date_of_upload=$_REQUEST['dateOfUpload'];
}

$submission=new Submission($dbconnect->getInstance());

$target_dir = "uploads/";
$target_file = $target_dir .uniqid(). basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if file already exists
if (file_exists($target_file)) {
	echo "<script>
	alert('Sorry, file already exists.');
	window.location.href='insert_page.php';
	</script>";
    $uploadOk = 0;
}
// Allow certain file formats
if($FileType != "doc" && $FileType != "pdf" && $FileType != "odt"
&& $FileType != "docx" && $FileType != "ppt" ) {
	echo "<script>
	alert('Sorry, only PDF,DOC,DOCX,ODT,PPT files are allowed.');
	window.location.href='insert_page.php';
	</script>";

    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
				echo "<script>
				alert('Sorry, your file was not uploaded.');
				window.location.href='insert_page.php';
				</script>";
// if everything is ok, try to upload file
} else {
	$target_file=$target_file;
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
     {
    		$insertSubmission=$submission->insertSubmission($title,$target_file,$date_of_submission,$date_of_upload,$user_id,$course_id);
			if($insertSubmission == 1 )
			{
				$msg=Constants::INSERT_SUCCESS_MSG;	
				echo "<script>
				alert('$msg');
				window.location.href='insert_page.php';
				</script>";
			}
			else if($insertSubmission==Constants::STATUS_EXISTS)
			{
				unlink($target_file);
				echo "<script>
				alert('$insertSubmission');
				window.location.href='insert_page.php';
				</script>";
				
			}
			else
			{
				$msg=Constants::INSERT_FAIL_MSG;
				unlink($target_file);
				echo "<script>
				alert('$msg');
				window.location.href='insert_page.php';
				</script>";	
			}
    }
    else
    {
    	echo "error";
    }
       
}






?>