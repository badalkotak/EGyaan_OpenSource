<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Noticeboard.php");



$dbConnect = new DBConnect(Constants::SERVER_NAME,
        Constants::DB_USERNAME,
        Constants::DB_PASSWORD,
        Constants::DB_NAME);

$id=$_REQUEST['delete'];
if($id!=0)
{	
	$noticeboard = new Noticeboard($dbConnect->getInstance());
	$selectData=$noticeboard->getNoticeboard(1,1,1,1,"id",$id);
	if($selectData!=null)
	{
	while($row=$selectData->fetch_assoc())
	{
		$file=$row['file'];
	}
	if(isset($file)){
	 if(unlink($file))
	 {
	 $deleteData=$noticeboard->deleteNoticeboard($id);
	}
else{
	 $deleteData=$noticeboard->deleteNoticeboard($id);
}
}

	if($deleteData )
	{
	header("location:index.php?errormessage=deleted successfully!");
		
	}
	else
	{
	header("location:index.php?errormessage=Something went wrong");
		
	}
	
	}	
	
}

else{
	header("location:index.php?errormessage=error");

	
}
