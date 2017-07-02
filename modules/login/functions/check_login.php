<?php
require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../classes/Login.php");
require_once("../../manage_user/classes/User.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$login= new Login($dbConnect->getInstance());

$email=$_REQUEST['email'];
$passwd=$_REQUEST['passwd'];

$checkLogin=$login->checkLogin($email,$passwd);
$json = array();

if($checkLogin!=null)
{
	$user=new User($dbConnect->getInstance());
	$getUserId=$user->getUserId($email);

	if($getUserId!=Constants::NO_USER_ERR)
	{
		$login->createSession($email,$getUserId,$checkLogin);
		$json['login']=Constants::STATUS_SUCCESS;
	}
	else
	{
		$json['login']=Constants::NO_USER_ERR;
	}
}

else
{
	$json['login']=Constants::STATUS_FAILED;
}

header("Content-Type: application/json");
echo json_encode($json);
?>