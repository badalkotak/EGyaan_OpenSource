<html>
<body>

	<?php
	require_once("../../../classes/Constants.php");
	require_once("../../../classes/DBConnect.php");
	require_once("../classes/Noticeboard.php");
	require_once("../../manage_branch/classes/Branch.php");
	require_once("../../manage_course/classes/Course.php");


//include("../../../Resources/sessions.php");


	$dbConnect = new DBConnect(Constants::SERVER_NAME,
		Constants::DB_USERNAME,
		Constants::DB_PASSWORD,
		Constants::DB_NAME);

	$user_id=3;
	$email="badalkotak@gmail.com";
//$role_id=7;
//student

//select branch_id from egn_batch where id in (select batch_id from egn_student where email="badalkotak@gmail.com")


	$noticeboard = new Noticeboard($dbConnect->getInstance());
	$selectData=$noticeboard->getNested2("egn_batch","egn_student","branch_id",1,1,1,1,"id","batch_id",1,1,"email",$email);
	if($selectData!=null)
	{	
		?>
		<h1>BRANCH Student</h1>
		<?php
		while($row=$selectData->fetch_assoc())
		{
			$student_branch=$row['branch_id'];
			$var1="type";
			$var2=1;
			$var3=1;
			$urgent=1;
			$id=1;

			$selData=$noticeboard->getNoticeboard($var1,$student_branch,$var2,$urgent,$var3,$id);
			if($selData!=null)
			{
				while($row=$selData->fetch_assoc())
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
					<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id >read more..</button> </a>';
					if($file!=null)
					{
						echo "<label>Attached File :</label>";echo "<a href=$file>Attached Notice</a>";
					}

				}
			}
			else
			{
				echo "No BRANCH notice!";
			}	

			?>
			<h1>Student Urgent</h1>
			<?php
			$var1="type";
			$var2="urgent_notice";
			$var3=1;
			$urgent="u";
			$id=1;

			$result=$noticeboard->getNoticeboard($var1,$student_branch,$var2,$urgent,$var3,$id);
			if($result!=null)
			{
				while($row=$result->fetch_assoc())
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
					<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id >read more..</button> </a>';
					if($file!=null)
					{
						echo "<label>Attached File :</label>";echo "<a href=$file>Attached Notice</a>";
					}

				}


			}
			else{
				echo "No Urgent notice!";
			}
		}
	}
	else{
		$student_branch="";
	}
//select branch_id from egn_batch where id in (select batch_id from egn_course WHERE id in (select course_id from egn_teacher_course where user_id=3))
//$sql="Select * from $table1 where $var1=$value1 and $var2=$value2 and  $var3 in ( select $value3 from $table 2 where $var4=$value4 and $var5=$value5 and $var6 in (select $value6 from $table3 where $var7=$value7 and $var8=$value8 ))"
	$course = new Course($dbConnect->getInstance());
	$branchData=$course->getCourse("yes", $user_id, 'no',0, 0,null,0);


	if($branchData!=null)
	{
		echo"in";
		?>
		<h1>TeacherBRANCH</h1>
		<?php
		while($row=$branchData->fetch_assoc())
		{	
			$teacher_branch=$row['branchId'];
			$teacher_branch_name=$row['branchName'];
			echo"<h3>".$teacher_branch_name."</h3>";
			$var1="type";
			$var2=1;
			$var3=1;
			$urgent=1;
			$id=1;

			$noticeboard = new Noticeboard($dbConnect->getInstance());
			$selectData=$noticeboard->getNoticeboard($var1,$teacher_branch,$var2,$urgent,$var3,$id);
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
					<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id >read more..</button> </a>';
					if($file!=null)
					{
						echo "<label>Attached File :</label>";echo "<a href=$file>Attached Notice</a>";
					}

				}
			}
			else{
				echo "No BRANCH notice!";
			}
		}
	}
	else{
		$teacher_branch="";
	}
	$course = new Course($dbConnect->getInstance());
	$branchData=$course->getCourse("yes", $user_id, 'no',0, 0,null,0);
	if($branchData!=null)
	{

		?>
		<h1>TeacherBRANCH Urgent</h1>
		<?php
		while($row=$branchData->fetch_assoc())
		{	
			$teacher_branch=$row['branchId'];
			$teacher_branch_name=$row['branchName'];
			echo"<h3>".$teacher_branch_name."</h3>";
			$var1="type";
			$var2="urgent_notice";
			$var3=1;
			$urgent="u";
			$id=1;

			$noticeboard = new Noticeboard($dbConnect->getInstance());
			$selectData=$noticeboard->getNoticeboard($var1,$teacher_branch,$var2,$urgent,$var3,$id);
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
					<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id >read more..</button> </a>';
					if($file!=null)
					{
						echo "<label>Attached File :</label>";echo "<a href=$file>Attached Notice</a>";
					}
				}
			}
			else{
				echo "No Urgent notice!";
			}	
		}
	}


	$branch = new Branch($dbConnect->getInstance());
	$branchData=$branch->getBranch(0);

	if($branchData!=null)
	{
		?>
		<h1>AdminBRANCH</h1>
		<?php
		while($row=$branchData->fetch_assoc())
		{	
			$teacher_branch=$row['id'];
			$teacher_branch_name=$row['name'];
			echo"<h3>".$teacher_branch_name."</h3>";
			$var1="type";
			$var2=1;
			$var3=1;
			$urgent=1;
			$id=1;

			$noticeboard = new Noticeboard($dbConnect->getInstance());
			$selectData=$noticeboard->getNoticeboard($var1,$teacher_branch,$var2,$urgent,$var3,$id);
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
					echo'<a href="delete_noticeboard.php?delete='.$id.'" onclick=del_confirm()><button type=button name=delete id=delete >Delete</button> </a>';

					echo'
					<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id >read more..</button> </a>';
					if($file!=null)
					{
						echo "<label>Attached File :</label>";echo "<a href=$file>Attached Notice</a>";
					}
				}
			}
			else{
				echo "No BRANCH notice!";
			}
		}
	}
	else{
		$teacher_branch="";
	}
	$branch = new Branch($dbConnect->getInstance());
	$branchData=$branch->getBranch(0);

	?>
	<h1>AdminBRANCH Urgent</h1>
	<?php
	while($row=$branchData->fetch_assoc())
	{	
		$teacher_branch=$row['id'];
		$teacher_branch_name=$row['name'];
		echo"<h3>".$teacher_branch_name."</h3>";
		$var1="type";
		$var2="urgent_notice";
		$var3=1;
		$urgent="u";
		$id=1;

		$noticeboard = new Noticeboard($dbConnect->getInstance());
		$selectData=$noticeboard->getNoticeboard($var1,$teacher_branch,$var2,$urgent,$var3,$id);
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
				echo'<a href="delete_noticeboard.php?delete='.$id.'" onclick=del_confirm()><button type=button name=delete id=delete >Delete</button> </a>';

				echo'
				<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id >read more..</button> </a>';
				if($file!=null)
				{
					echo "<label>Attached File :</label>";echo "<a href=$file>Attached Notice</a>";
				}
			}
		}
		else{
			echo "No Urgent notice!";
		}	
	}
	?>

	<h1>COMMON</h1>
	<?php
	$var1="type";
	$var2=1;
	$var3=1;
	$type="c";
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
			echo'<a href="delete_noticeboard.php?delete='.$id.'" onclick=del_confirm()><button type=button name=delete id=delete >Delete</button> </a>';
			echo'<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id >read more..</button> </a>';
			if($file!=null)
			{
				echo "<label>Attached File :</label>";echo "<a href=$file>Attached Notice</a>";
			}

		}
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



