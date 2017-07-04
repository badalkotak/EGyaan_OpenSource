<html>
    <link rel="stylesheet" href="../../../Resources/AdminLTE-2.3.11/bootstrap/css/bootstrap.min.css">
<?php
//include("../../../Resources/sessions.php");
include("privilege.php");

if($add!=true)
{
	$message=Constants::NO_PRIVILEGE;
	echo "<script>alert('$message');window.location.href='../../login/functions/logout.php'</script>";
}

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Notes.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$user_id=$id;
if(empty($_REQUEST['title']) || empty($_REQUEST['course']))
{
	$msg=Constants::EMPTY_PARAMETERS;
	echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('$msg')
        window.location.href='insert_page.php';
        </SCRIPT>");
}
else
{
	$title=$_REQUEST["title"];
	$course_id=$_REQUEST["course"];
	if(isset($_REQUEST["downloadable"]))
	{
	$downloadable=$_REQUEST["downloadable"];
	}else{
		$downloadable="No";
	}
}

$notes=new Notes($dbconnect->getInstance());

$target_dir = "uploads/";
$target_file = $target_dir .uniqid(). basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if file already exists
if (file_exists($target_file)) {
				echo "<script>
				alert('<h4 class='alert-message'><i class='fa fa-exclamation-triangle'></i>Sorry, file already exists.</h4>');
				window.location.href='insert_page.php';
				</script>";
    $uploadOk = 0;
}
// Allow certain file formats
if($FileType != "doc" && $FileType != "pdf" && $FileType != "odt"
&& $FileType != "docx" && $FileType != "ppt" ) {
				echo "<script>
				alert('<h4 class='alert-message'><i class='fa fa-exclamation-triangle'></i>Sorry, only PDF,DOC,DOCX,ODT,PPT files are allowed.</h4>');
				window.location.href='insert_page.php';
				</script>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
				echo "<script>
				alert('<h4 class=\'alert-message\'><i class=\'fa fa-exclamation-triangle\'></i>Sorry, your file was not uploaded.</h4>');
				window.location.href='insert_page.php';
				</script>";
// if everything is ok, try to upload file
} else {
	$target_file=$target_file;
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
     {
    		$insertNote=$notes->insertNotes($title,$target_file,$course_id,$downloadable,$user_id);
			if($insertNote == 1)
			{
				$msg=Constants::INSERT_SUCCESS_MSG;
				echo "<script>
				alert('$msg');
				window.location.href='insert_page.php';
				</script>";
			}
			else if($insertNote==Constants::STATUS_EXISTS)
			{
				unlink($target_file);
				echo "<script>
				alert('$insertNote');
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
    
</html>