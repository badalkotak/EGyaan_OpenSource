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



$role_id=1;
if($role_id==1)
{
$var1="id";
$var2=1;
$id=$_REQUEST['id'];
$type=1;
$suggestion = new Suggestioncomplaint($dbConnect->getInstance());
$selectData=$suggestion->getSuggestioncomplaint($var1,$id,$var2,$type);
if($selectData !=null)
{
	echo'<table>'
	while($row=$selectData->fetch_assoc())
	{
		$title=$row['title'];
		$description=$row['description'];
		$id=$row['id'];
		$type=$row['type'];
		if($type=="s")
		{
			?><h1>Suggestion</h1><?php
		}
		else{
			?><h1>Complaint</h1><?php

		}
		?>

				<tr>
				<td>Title:
				<?php
				echo$title;
				?>
				</td>
				</tr>
				<tr>
				<td>Description:
					<?php
					echo$description;
					?>
				</td>
				</tr>
				<tr>
				<td>

				<?php
				echo'
				<a href="delete_suggestion_complaint.php?delete='.$id.'"><button type=button name=delete id=delete onclick=del_confirm()>Delete</button> </a></td>';
				?>
				</tr>
	}
?>
	</table>
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

}
?>
</article>
