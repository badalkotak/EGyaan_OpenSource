<?php
include("../../../Resources/sessions.php");

require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../../manage_privilege/classes/Privilege.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$privilege=new Privilege($dbConnect->getInstance());

$getDashboard=$privilege->getDashboardPrivilege($role_id);

if($getDashboard!=null)
{
	while($row=$getDashboard->fetch_assoc())
	{
		$privilege_folder=$row['folder'];
		$dashboard_name=$row['dashboard_name'];
		echo "<a href=../../$privilege_folder><img src=../../$privilege_folder/icon.png></img><br>$dashboard_name<br></a>";
	}
}
?>

<br>
<br>
<a href="logout.php">Logout</a>