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
<h1>URGENT</h1>
<?php
$var1=1;
$var2="urgent_notice";
$var3=1;
$type=1;
$urgent="u";
$id=1;


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
		echo'
		<a href="delete_noticeboard.php?delete='.$id.'"><button type=button name=delete id=delete >Delete</button> </a>
		<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id >read more..</button> </a>'
		;
		echo "<label>Attached File :</label>";echo "<a href=$file>Attached Notice</a>";

	}
}
else{
	echo "No urgent notice!";
}
?>
<h1>COMMON</h1>
<?php
$var1="type";
$var2=1;
$var3=1;
$type=2;
$urgent=1;
$id=1;


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
		echo'
		<a href="delete_noticeboard.php?delete='.$id.'"><button type=button name=delete id=delete >Delete</button> </a>
		<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id >read more..</button> </a>';

	}
}
else{
	echo "No urgent notice!";
}

?>
<h1>BRANCH</h1>
<?php
$var1="type";
$var2=1;
$var3=1;
$type=1;
$urgent=1;
$id=1;


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
		echo'
		<a href="delete_noticeboard.php?delete='.$id.'"><button type=button name=delete id=delete >Delete</button> </a>
		<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id >read more..</button> </a>';

	}
}
else{
	echo "No urgent notice!";
}
?>

