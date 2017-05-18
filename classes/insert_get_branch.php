<?php
require_once("Constants.php");
require_once("DBConnect.php");
require_once("Branch.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
        Constants::DB_USERNAME,
        Constants::DB_PASSWORD,
        Constants::DB_NAME);

$branch = new Branch($dbConnect->getInstance());

$insertData=$branch->insertBranch("EXTC");

if($insertData)
{
$result=$branch->getBranch();
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
}
}
else
{
	echo "Error in inserting!";
}