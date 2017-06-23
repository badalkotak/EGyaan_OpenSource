
<html>
<head>
<script type="text/javascript" src="../../../Resources/jquery.min.js">
</script>
<script type="text/javascript" src="get_branch.js">
</script>
<script type="text/javascript" src="add_noticeboard.js">
</script>
<script type="text/javascript" src="add_noticeboard.js">
</script>
</head>
<body>
<form action="insert_get_noticeboard.php" method="post" enctype="multipart/form-data" id=add_notice>

<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
include("../../../Resources/sessions.php");


$dbConnect = new DBConnect(Constants::SERVER_NAME,
        Constants::DB_USERNAME,
        Constants::DB_PASSWORD,
        Constants::DB_NAME);
if(isset($_REQUEST['type']) && $_REQUEST['type']=="b")
{
	require_once("../../manage_branch/classes/Branch.php");
	$branch = new Branch($dbConnect->getInstance());
	$selectData = $branch->getBranch(0);



	$type=$_REQUEST['type'];
	if(isset($_REQUEST['title']))
	{
		$title=$_REQUEST['title'];
	}
	else{
		$title="";
	}
	if(isset($_REQUEST['notice']))
	{
		$notice=$_REQUEST['notice'];
	}
	else{
		$notice="";
	}


	echo'Title: <input type=text name=title id=title placeholder="title" value='.$title.'> 
	Notice: <textarea name=notice id=notice placeholder=notice > '.$notice.'</textarea>
	file:<input type=file name=file id=file >
	<input type="radio" name="type" id="type" value="b" checked>Branch
	<input type="radio" name="type" id="type" value="c">Common
	<div id=branch>';
	if($selectData)
	{
	    while ($row = $selectData->fetch_assoc()) 
	    {
	    	$id=$row['id'];
	    	$name=$row['name'];
	    	echo'<input type=checkbox name=select_branch[] id=select_branch[] value=' .$id. ' />'.$name;

	    }
	}



	echo'</div>';
	if($_REQUEST['u']=="u"){
		echo'<input type="checkbox" name="u" id="u" value="u" checked> Urgent';
	}
	else{
		echo'<input type="checkbox" name="u" id="u" value="u"> Urgent';
	}
	echo'
	<input type=submit value=submit id=add_notice_submit />';
}
else{
	?>

Title: <input type="text" name="title" id="title" placeholder="title" /> 
Notice: <textarea name="notice" id="notice" placeholder="notice"> </textarea>
file:<input type="file" name="file" id="file" />

<label><input type="radio" name="type"  value=b />Branch</label>
<label><input type="radio" name="type"  value=c  />Common</label>
<div id=branch></div>
<input type="checkbox" name="u" id="u" value="u" /> Urgent
<input type=submit value=submit id=add_notice_submit />
<div id=errormessage>
</div>


<?php
}
?>

</form>
</body>
</html>
