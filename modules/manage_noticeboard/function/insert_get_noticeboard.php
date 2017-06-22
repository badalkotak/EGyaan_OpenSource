<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Noticeboard.php");
require_once("../../manage_branch/classes/Branch.php");



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

if(isset($_REQUEST['select_branch']))
{	
	$chk=implode(",",$_REQUEST['select_branch']);

}
else{
	$chk=="";
}
if(isset($_REQUEST['type']))
{
	$type=$_REQUEST['type'];
}
$user_id=2;
if($_FILES['file']!="")
{
	$pass=$_FILES['file'];
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

if($type=="b" && $chk=="")
{

		header("location:add_noticeboard.php?title=".$title."&type=".$type."&notice=".$notice."&u=".$urgent);

}
else{


	if($title=="" || empty($notice))
	{

		header("location:add_noticeboard.php?errormessage=Please input all fields");	
	}
	else{

		if($type=="c")
		{
			$noticeboard = new Noticeboard($dbConnect->getInstance());
			$insertData=$noticeboard->insertNoticeboard($title,$notice,$path,$urgent,$type,$user_id);
			if($insertData)
			{
				header("location:index.php?errormessage=Successfully added!");
			}
			else
			{
				echo "Error in inserting!";
			}
		}
		else{
		$chk = explode(',', $chk);

		foreach ((array)$chk as $chcks )
		{

			$noticeboard = new Noticeboard($dbConnect->getInstance());
			$insertData=$noticeboard->insertNoticeboard($title,$notice,$path,$urgent,$chcks,$user_id);
			if($insertData)
			{
				header("location:index.php?errormessage=Successfully added!");
			}
			else
			{
				echo "Error in inserting!";
			}
		}
		}	
	}
}