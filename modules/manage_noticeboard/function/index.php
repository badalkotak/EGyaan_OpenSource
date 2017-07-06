<!DOCTYPE html>
<html>
<?php
include("../../../Resources/sessions.php");
include("../../../Resources/Dashboard/header.php");
    
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Noticeboard.php");
require_once("../../manage_branch/classes/Branch.php");
require_once("../../manage_course/classes/Course.php");
    
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$user_id=$id;
// $email="badalkotak@gmail.com";
//$role_id=7;
//student

//select branch_id from egn_batch where id in (select batch_id from egn_student where email="badalkotak@gmail.com")
?>
<!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Hello!<small>User</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                <li class="active"><b>Noticeboard</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content"> 
            <?php
            if($role_id==Constants::ROLE_STUDENT_ID)
            {
                $noticeboard = new Noticeboard($dbConnect->getInstance());
                $selectData=$noticeboard->getNested2("egn_batch","egn_student","branch_id",1,1,1,1,"id","batch_id",1,1,"email",$email);
                if($selectData!=null)
                {	
            ?>
            <h2 class="page-header">Branch Student</h2>
            <div class="row"><!--start of row2-->
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
                                $urgent=$row['urgent_notice'];
            ?>
            <div class="col-md-6">
            <div class="box box-warning collapsed-box">
            <div class="box-header with-border">
            <div class="user-block">
            <h4>Title :
                <?php
                    echo $title;
                ?>
            </h4>
            
            <?php
//                                        echo '<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id>read more..</button> </a>';
                                        
                                        echo "<button type='button' class='btn btn-default btn-box-tool' data-widget='collapse'>Read More <span class='fa fa-ellipsis-h'></span>
                                </button>";
                                        
                                        if($file!=null)
                                        {
                                            echo "<a href=$file class='btn btn-default btn-box-tool'>
                                    <i class='fa fa-paperclip'></i> Attached Notice</a>";
                                        }
                                        if($urgent=="u")
                                        {
                                            echo '<h4 class="alert-message pull-right"><i class="icon fa fa-exclamation-triangle"></i><b>Urgent Notice</b></h4>';
                                        }
                                echo'</div>
                                        </div>
                                        <div class="box-body">
                                            <h4>Description :</h4>
                                            <p class="text-justify">'.                          
                                                    $notice.
                                            '</p>
                                        </div>
                                    </div>
                                </div>';
							}
							
						}
						else
						{
							echo '<div class="col-md-12"><h4>No Branch Notice!</h4></div>';
						}	
                        
					}
                    echo '</div>';//end of row2
				}
				else{
					$student_branch="";
				}
			}
			else if($role_id==Constants::ROLE_TEACHER_ID){
//select branch_id from egn_batch where id in (select batch_id from egn_course WHERE id in (select course_id from egn_teacher_course where user_id=3))
//$sql="Select * from $table1 where $var1=$value1 and $var2=$value2 and  $var3 in ( select $value3 from $table 2 where $var4=$value4 and $var5=$value5 and $var6 in (select $value6 from $table3 where $var7=$value7 and $var8=$value8 ))"
				$course = new Course($dbConnect->getInstance());
				$branchData=$course->getCourse("yes", $user_id, 'no',0, 0,null,0);


				if($branchData!=null)
				{
					?>
					<h2 class="page-header">Teacher Branch</h2>
                    
					<?php
					while($row=$branchData->fetch_assoc())
					{	
						$teacher_branch=$row['branchId'];
						$teacher_branch_name=$row['branchName'];
						echo"<h4 class='page-header'>".$teacher_branch_name."</h4>";
                        echo '<div class="row">';//start of row3
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
								$urgent=$row['urgent_notice'];

								?>
                                    <div class="col-md-6">
                                    <div class="box box-warning collapsed-box">
                                    <div class="box-header with-border">
                                    <div class="user-block">
									<h4>Title :
										<?php
										echo $title;
										?>
									</h4>
										<?php
//										echo'
//										<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id >read more..</button> </a>';
                                
                                        echo "<button type='button' class='btn btn-default btn-box-tool' data-widget='collapse'>Read More <span class='fa fa-ellipsis-h'></span>
                                        </button>";
                                
                                
										if($file!=null)
										{
											echo "<a href=$file class='btn btn-default btn-box-tool'>
                                    <i class='fa fa-paperclip'></i> Attached Notice</a>";
										}
										if($urgent=="u"){
											echo '<h4 class="alert-message pull-right"><i class="icon fa fa-exclamation-triangle"></i><b>Urgent Notice</b></h4>';
										}
                                        echo'</div>
                                                </div>
                                                    <div class="box-body">
                                                        <h4>Description :</h4>
                                                        <p class="text-justify">'.                       
                                                                $notice.
                                                        '</p>
                                                    </div>
                                                </div>
                                            </div>';
									}
									
                                    
								}
								else{
									echo "<div class='col-md-12'><h4>No Branch Notice!</h4></div>";
								}
                            echo '</div>';//end of row3
							}
                    
						}
						else{
							$teacher_branch="";
						}
					}


					else if($role_id==Constants::ROLE_ADMIN_ID){
						$branch = new Branch($dbConnect->getInstance());
						$branchData=$branch->getBranch(0);

						if($branchData!=null)
						{
							?>
							<h2 class="page-header">Admin Branch</h2>
                            
							<?php
							while($row=$branchData->fetch_assoc())
							{	
								$teacher_branch=$row['id'];
								$teacher_branch_name=$row['name'];
								echo"<h4>".$teacher_branch_name."</h4>";
                                echo '<div class="row">';//start of row4
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
										$urgent=$row['urgent_notice'];


										?>
                                    <div class="col-md-6">
                                    <div class="box box-warning collapsed-box">
                                    <div class="box-header with-border">
                                    <div class="user-block">
											<h4>Title :
												<?php
												echo $title;
												?>
											</h4>
												<?php
//												echo'
//												<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id >read more..</button> </a>';
                                        
                                                echo "<button type='button' class='btn btn-default btn-box-tool' data-widget='collapse'>Read      More <span class='fa fa-ellipsis-h'></span></button>&nbsp;";

												echo'<a href="delete_noticeboard.php?delete='.$id.'" onclick=del_confirm()><button type=button name=delete id=delete  class="btn btn-default btn-box-tool btn-sm"><span class="fa fa-trash"></span>Delete</button> </a>';
												if($file!=null)
												{
													echo "<a href=$file class='btn btn-default btn-box-tool'>
                                    <i class='fa fa-paperclip'></i> Attached Notice</a>";
												}
												if($urgent=="u"){
													echo '<h4 class="alert-message pull-right"><i class="icon fa fa-exclamation-triangle"></i><b>Urgent Notice</b></h4>';
												}
                                            echo'</div>
                                                </div>
                                                    <div class="box-body">
                                                        <h4>Description :</h4>
                                                        <p class="text-justify">'.                       
                                                                $notice.
                                                        '</p>
                                                    </div>
                                                </div>
                                            </div>';
                                            }
											
										}
										else{
											echo "<div class='col-md-12'><h4>No Branch Notice!</h4></div>";
										}
                                    echo '</div>';//end of row4
									}
                            
								}
								else{
									$teacher_branch="";
								}
							}
							?>
							<h2 class="page-header">Common Notice</h2>
                            <div class="row"><!--start of row5-->
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
									$urgent=$row['urgent_notice'];

									?>
                                    <div class="col-md-6">
                                    <div class="box box-warning collapsed-box">
                                    <div class="box-header with-border">
                                    <div class="user-block">
										<h4>Title :
											<?php
											echo $title;
											?>
										</h4>
										
											<?php
//											echo'
//											<a href="view_notice.php?id='.$id.'"><button type=button name=id id=id >read more..</button> </a>';
                                    
                                            echo "<button type='button' class='btn btn-default btn-box-tool' data-widget='collapse'>Read      More <span class='fa fa-ellipsis-h'></span>
                                            </button>&nbsp;";
                                    
											if($role_id==Constants::ROLE_ADMIN_ID){
												echo'<a href="delete_noticeboard.php?delete='.$id.'" onclick=del_confirm()><button type=button name=delete id=delete class="btn btn-default btn-box-tool btn-sm"><span class="fa fa-trash"></span> Delete</button> </a>';
											}
											if($file!=null)
											{
												echo "<a href=$file class='btn btn-default btn-box-tool'>
                                    <i class='fa fa-paperclip'></i> Attached Notice</a>";
											}
											if($urgent=="u"){
												echo '<h4 class="alert-message pull-right"><i class="icon fa fa-exclamation-triangle"></i><b>Urgent Notice</b></h4>';   
											}
                                            echo'</div>
                                                </div>
                                                    <div class="box-body">
                                                        <h4>Description :</h4>
                                                        <p class="text-justify">'.                       
                                                                $notice.
                                                        '</p>
                                                    </div>
                                                </div>
                                            </div>';
										}
										
									}
									else{
										echo "<div class='col-md-12'><h4>No Common Notice!</h4></div>";
									}
                                    echo '</div>';//end of row5
									?>
            
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php
    include("../../../Resources/Dashboard/footer.php");
?>
    </body>
</html>
