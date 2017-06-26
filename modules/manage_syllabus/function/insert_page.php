<!DOCTYPE html>
<html>
<?php
include("../../../Resources/sessions.php");
include("../../../Resources/Dashboard/header.php");
$user_id=$_SESSION['id'];
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Syllabus.php");
require_once("../../manage_course/classes/Course.php");
$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$syllabus=new Syllabus($dbconnect->getInstance());
$course=new Course($dbconnect->getInstance());
?>
    
<!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Hello!<small>User</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                <li class="active"><b>Insert Syllabus</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Insert Syllabus</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form method="post" action="insert_syllabus.php" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="file" name="fileToUpload">
                                </div>
                                <?php
                                // $result=$course->getCourse("yes",$user_id,'no');
                                $getTeacherCourse=$course->getCourse("yes",$user_id,"no",0,0,null,0);
                                if($getTeacherCourse===false)
                                {
                                    $result=$course->getCourse("no",0,'no',0,0,null,0);	
                                }
                                else
                                {
                                    $result=$course->getCourse("yes",$user_id,"no",0,0,null,0);
                                }
                                ?>
                                <div class="form-group">
                                    <select name="course" class="form-control select2" style="width: 100%;">
                                        <option value="0" selected="selected">Select Course</option>
                                        <?php
                                        if($result!=null)
                                        {
                                            while($row=$result->fetch_assoc())
                                            {
                                                echo "<option value=".$row['courseId'].">".$row['branchName']." - ".$row['batchName']." - ".$row['courseName']."</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success" name="submit"><span class="fa fa-check"></span>Submit</button>
                                </div>
                            </form>
                        </div>
                        <?php
                        $getTeacherCourse=$course->getCourse("yes",$user_id,"no",0,0,null,0);
                        if($getTeacherCourse===false)
                        {
                            $courses_result=$course->getCourse("no",0,'no',0,0,null,0);	
                        }
                        else
                        {
                            $courses_result=$course->getCourse("yes",$user_id,"no",0,0,null,0);
                        }
                        ?>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                             <h4>List Of Syllabus:</h4>
                            <div class="table-container1">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Branch</th>
                                            <th>Batch</th>
                                            <th>Course</th>
                                            <th>File</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if($courses_result!=null)
                                        {
                                            while($rowCourses=$courses_result->fetch_assoc())
                                            {
                                                $result=$syllabus->getSyllabus($rowCourses['courseId']);
                                                if($result!=null)
                                                {	
                                                    $no=1;
                                                    while($row=$result->fetch_assoc())
                                                    {
                                                        echo '<tr><td>'.$no.'</td><td>'.$rowCourses['branchName'].'</td><td>'.$rowCourses['batchName'].'</td><td>'.$rowCourses['courseName'].'</td>';
                                                        echo '<td><a href='.$row['file'].'><span class="fa fa-file-pdf-o fa-lg "></span></a></td>';
                                                        echo '<td><form action=delete.php method=post><input type=hidden name=file value='.$row['file'].'><input type=hidden name=id value='.$row['id'].'><button type=submit name=delete class="btn btn-danger btn-sm"><span class="fa fa-trash"></span>Delete</button></td></form></tr>';
                                                        $no=$no+1;
                                                    }
                                                }
                                            }	
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php
    include("../../../Resources/Dashboard/footer.php");
    ?>
    </body>
</html>