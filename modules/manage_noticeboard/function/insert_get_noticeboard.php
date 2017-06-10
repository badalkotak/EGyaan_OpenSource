<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Noticeboard.php");


$dbConnect = new DBConnect(Constants::SERVER_NAME,
        Constants::DB_USERNAME,
        Constants::DB_PASSWORD,
        Constants::DB_NAME);


$title=mysql_real_escape_string(trim($_REQUEST['title']));
$notice=mysql_real_escape_string(trim($_REQUEST['notice']));
if(isset($_REQUEST['u']))
{
	$urgent=mysql_real_escape_string($_REQUEST['u']);
}
else{
	$urgent=null;
}
$type=mysql_real_escape_string($_REQUEST['type']);
$user_id=2;
if(isset($_FILES['file']))
{
	$target_dir="../uploads/";
	$file=$_FILES['file']['name'];
	$path="../uploads/".$file;
	$target_file=$target_dir.basename($file);
	//$filetype=pathinfo($target_file,PATHINFO_EXTENSION);
	move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
}
else{
	$path=null;
}



if($title!="" && !empty($notice) && $type!=0)
{


	$noticeboard = new Noticeboard($dbConnect->getInstance());
	$insertData=$noticeboard->insertNoticeboard($title,$notice,$path,$urgent,$type,$user_id);
	if($insertData)
	{
		/*$result=$branch->getBranch();
		if($result!=null)
		{
		while($row=$result->fetch_assoc())
		{
			echo $name=$row['name'];echo "<br>";
		}
		}
		else
		{
		echo "Null Result!";
		}*/
		header("location:index.php?errormessage=Successfully added!");
	}
	else
	{
		echo "Error in inserting!";
	}
		
	
}
else{
	header("location:add_noticeboard.php?errormessage=Please input all fields");

	
}