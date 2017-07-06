<?php
include("privilege.php");

if($add!=true)
{
	$message=Constants::NO_PRIVILEGE;
	echo "<script>alert('$message');window.location.href='../../login/functions/logout.php'</script>";
}

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Syllabus.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$user_id=$id;
if(empty($_REQUEST['course']) || empty($_FILES['fileToUpload']))
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
}

$syllabus=new Syllabus($dbconnect->getInstance());

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
    		$insertSyllabus=$syllabus->insertSyllabus($course_id,$target_file,$user_id);
			if($insertSyllabus == 1 )
			{
				$msg=Constants::INSERT_SUCCESS_MSG;	
				echo "<script>
				alert('$msg');
				window.location.href='insert_page.php';
				</script>";
			}
			else if($insertSyllabus==Constants::STATUS_EXISTS)
			{
				unlink($target_file);
				echo "<script>
				alert('$insertSyllabus');
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