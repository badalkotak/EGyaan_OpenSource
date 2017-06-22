<html>
<body>


<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Noticeboard.php");


$dbConnect = new DBConnect(Constants::SERVER_NAME,
        Constants::DB_USERNAME,
        Constants::DB_PASSWORD,
        Constants::DB_NAME);
?>
<?php
$var1=1;
$var2=1;
$type=1;
$urgent=1;
$var3="id";
$id=$_REQUEST['id'];

$noticeboard = new Noticeboard($dbConnect->getInstance());
$selectData=$noticeboard->getNoticeboard($var1,$type,$var2,$urgent,$var3,$id);
if($selectData)
{
	while($row=$selectData->fetch_assoc())
	{
		$title=$row['title'];
		$notice=$row['notice'];
		$id=$row['id'];
		$file=$row['file'];

		?>
		<?php
		echo$title;
		?>
		<article>
		<?php
		echo$notice;
		?>
		</article>

		
		<?php
		echo'<a href="delete_noticeboard.php?delete='.$id.'"><button type=button name=delete id=delete >Delete</button> </a>';
		echo "<label>Attached File :</label>";echo "<a href=$file>Attached Notice</a>";

	}
}
else{
	echo "No urgent notice!";
}
?>

