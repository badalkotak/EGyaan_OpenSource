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

	if(isset($_POST['role_id']))
	{
		$role_id=$_POST['role_id'];
	}
	else{
		$role_id=1;
	}

	if($role_id==1)
	{
		?>
		<form action="?" method=post>
			<label><input type ="radio" name=type id=type value=s />Suggestion</label>
			<label><input type ="radio" name=type id=type value=c />Complaint</label>
			<?php echo'<input type=hidden name=role_id id=role_id value='. $role_id .' />';?>
			<input type=submit value=submit />
		</form>
		<?php

		$var2="type";
		if(isset($_REQUEST['type']))
		{
			$type=$_REQUEST['type'];
		}
		else{
			$type="s";
		}

				if($type=="s")
				{
					?><h1>Suggestion</h1><?php
				}
				else{
					?><h1>Complaint</h1><?php

				}
		$var1=1;
		$id=1;
		$suggestion = new Suggestioncomplaint($dbConnect->getInstance());
		$selectData=$suggestion->getSuggestioncomplaint($var1,$id,$var2,$type);
		if($selectData!=null)
		{
			echo'<table border=0>';
			while($row=$selectData->fetch_assoc())
			{
				$title=$row['title'];
				$description=$row['description'];
				$id=$row['id'];

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
				echo'
				<td><a href="view_suggestion_complaint.php?id='.$id.'"><button type=button name=id id=id >read more..</button> </a></td>';?>
				</tr>
				<?php
			}
		}
	}
	else if($role_id==2)
	{
		?>

		<form action="insert_get_suggestion_complaint.php" method="post">
			Title: <input type=text name=title id=title placeholder="title"> </input>
			Description: <textarea name=description id=description placeholder=description> </textarea>
			<label><input type ="radio" name=type id=type value=s />Suggestion</label>
			<label><input type ="radio" name=type id=type value=c />Complaint</label>
			<input type=submit value=submit></input>
		</form>

		<?php
	}
	else{
		echo "error";
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


</body>
</html>