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

$role_id=2;
$var1="id";
$var2="type";
$id=$_REQUEST['id'];
$type="s";
$suggestion = new Suggestioncomplaint($dbConnect->getInstance());
$selectData=$suggestion->getSuggestioncomplaint($var1,$id,$var2,$type);
if($selectData && $role_id==1)
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
		<a href="delete_suggestion.php?delete='.$id.'"><button type=button name=delete id=delete onclick=del_confirm() >Delete</button> </a>';
	}
?>
	<script>
		function del_confirm() {
			var x;
			if (confirm("Do you want to continue") == true) {

			} else {
				event.preventDefault() ;
			}
    //document.getElementById("demo").innerHTML = x;
}

</script>
<?php
}
else 
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

}
}
?>
</article>
