<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/SuggestionComplaint.php");


$dbConnect = new DBConnect(Constants::SERVER_NAME,
        Constants::DB_USERNAME,
        Constants::DB_PASSWORD,
        Constants::DB_NAME);

if(isset($_REQUEST['title'],$_REQUEST['description'],$_REQUEST['type']))
{
$title=mysql_real_escape_string(trim($_REQUEST['title']));
$description=mysql_real_escape_string(trim($_REQUEST['description']));
$type=mysql_real_escape_string(trim($_REQUEST['type']));

	$suggestion = new Suggestioncomplaint($dbConnect->getInstance());
	$insertData=$suggestion->insertSuggestioncomplaint($title,$description,$type);

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
		echo "location:index.php?errormessage=Error in inserting!";
	}
		
	
}
else{
	header("location:index.php?errormessage=Please input all fields");

	
}