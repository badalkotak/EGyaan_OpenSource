<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/SuggestionComplaint.php");


$dbConnect = new DBConnect(Constants::SERVER_NAME,
        Constants::DB_USERNAME,
        Constants::DB_PASSWORD,
        Constants::DB_NAME);


$title=mysql_real_escape_string(trim($_REQUEST['title']));
$description=mysql_real_escape_string(trim($_REQUEST['description']));

if($title!=""  && !empty($description))
{
	
	$type="s";

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
		echo "Error in inserting!";
	}
		
	
}
else{
	header("location:add_suggestion.php?errormessage=Please input all fields");

	
}