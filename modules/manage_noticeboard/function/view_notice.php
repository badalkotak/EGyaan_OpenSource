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

	$role_id=1;
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
		echo'<table>';
		while($row=$selectData->fetch_assoc())
		{
			$title=$row['title'];
			$notice=$row['notice'];
			$id=$row['id'];
			$file=$row['file'];
			$type=$row['type'];
			$urgent=$row['urgent_notice'];
			if($type=="c" )
			{
				?>
				<h1>Common</h1>
				<?php
			}
			else{
				?>
				<h1>Branch</h1>
				<?php
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
				<td>Description
					
					<?php
					echo$notice;
					?>
				</td>
			</tr>
			<tr>
				<td>
					<?php
					echo'
					<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id >read more..</button> </a>';
					if($role_id==1)
					{
						echo'<a href="delete_noticeboard.php?delete='.$id.'" onclick=del_confirm()><button type=button name=delete id=delete >Delete</button> </a>';
					}
					if($file!=null)
					{
						echo "<label>Attached File :</label>";echo "<a href=$file>Attached Notice</a>";
					}
					echo'</td><td>';
					if($urgent=="u"){
						echo"urgent";
					}
					echo'</td></tr>';
				}
				echo'</table>';
			}
			else{
				echo "No urgent notice!";
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

