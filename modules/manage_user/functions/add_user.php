<?php
require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../classes/User.php");
// require_once("../../manage_role/classes/Role.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

// $role=new Role($dbConnect->getInstance());
$user=new User($dbConnect->getInstance());

$connection=$dbConnect->getInstance();

$name=$connection->real_escape_string(trim($_REQUEST['name']));
$email=$connection->real_escape_string(trim($_REQUEST['email']));
$mobile=$connection->real_escape_string(trim($_REQUEST['mobile']));
$role_id=$connection->real_escape_string(trim($_REQUEST['role_id']));
$gender=$connection->real_escape_string(trim($_REQUEST['gender']));

function generatePassword($length = 4) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }
	
    return $result;
}
$pass=generatePassword();

$insert=$user->insertUser($email,$pass,$role_id,$gender,$mobile,$name);
if($insert)
{
	echo "Done";
}

else
{
	echo "Not done";
}
?>