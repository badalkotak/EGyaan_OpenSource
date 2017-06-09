<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/User.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
        Constants::DB_USERNAME,
        Constants::DB_PASSWORD,
        Constants::DB_NAME);

$user = new User($dbConnect->getInstance());

$insertData=$user->insertUser("abc@gmail.com","abc123",1,"male",123456789,"abc");

if($insertData)
{
$result=$user->getUser();
if($result!=null)
{
	while($row=$result->fetch_assoc())
	{
		echo $email=$row['email'];echo "<br>";
		echo $passwd=$row['passwd'];echo "<br>";
		echo $role_id=$row['role_id'];echo "<br>";
		echo $gender=$row['gender'];echo "<br>";
		echo $mobile=$row['mobile'];echo "<br>";
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