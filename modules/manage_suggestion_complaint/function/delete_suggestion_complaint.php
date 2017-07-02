<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/SuggestionComplaint.php");


$dbConnect = new DBConnect(Constants::SERVER_NAME,
        Constants::DB_USERNAME,
        Constants::DB_PASSWORD,
        Constants::DB_NAME);

$id=$_REQUEST['delete'];
if($id!=0)
{	
	$suggestion = new Suggestioncomplaint($dbConnect->getInstance());
	$deleteData=$suggestion->deleteSuggestioncomplaint($id);

	if($deleteData)
	{
		/*$result=$branch->getBranch();
		if($result!=null)
		{
		while($row=$result->fetch_assoc())
		{
			{echo $name=$row['name'];echo "

		}*/
	header("location:index.php?errormessage=deleted successfully!");
		
	}
	else
	{
	header("location:index.php?errormessage=Something went wrong");
		
	}
		
	
}
else{
	header("location:index.php?errormessage=error");

	
}