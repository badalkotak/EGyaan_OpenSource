<html>
<body>


<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/SuggestionComplaint.php");


$dbConnect = new DBConnect(Constants::SERVER_NAME,
        Constants::DB_USERNAME,
        Constants::DB_PASSWORD,
        Constants::DB_NAME);

$var2="type";
$type="s";
$var1=1;
$id=1;
$suggestion = new Suggestioncomplaint($dbConnect->getInstance());
$selectData=$suggestion->getSuggestioncomplaint($var1,$id,$var2,$type);
if($selectData)
{
	while($row=$selectData->fetch_assoc())
	{
		$title=$row['title'];
		$description=$row['description'];
		$id=$row['id'];
		?>
		<?php
		echo$title;
		?>
		<article>
		<?php
		echo$description;
		?>
		</article>

		
		<?php
		echo'
		<a href="delete_suggestion.php?delete='.$id.'"><button type=button name=delete id=delete >Delete</button> </a>
		<a href="view_suggestion.php?id='.$id.'"><button type=button name=id id=id >read more..</button> </a>';
	}
}
else{
	echo "No suggestion";
}
?>

