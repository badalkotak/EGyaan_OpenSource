<!DOCTYPE html>
<html>
<?php
include("privilege.php");

if($add!=true)
{
    $message=Constants::NO_PRIVILEGE;
    echo "<script>alert('$message');window.location.href='../../login/functions/logout.php'</script>";
}
include("../../../Resources/Dashboard/header.php");
    
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Test.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$teacher_id = $id;
$test = new Test($dbConnect->getInstance());
?>
    
    <!--START OF SIDEBAR===========================================================================================================-->
    <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <?
                        if($profile!=null)
                            		{
                            			echo "<img src='../../manage_student/images/student/$profile' class=img-circle alt='User Image'>";
                            		}
                           			else
                            		{
                            			echo "<img src='../../../Resources/images/boy.png' class=img-circle alt='User Image'>";
                            		}
                        ?>
                    </div>
                    <div class="pull-left info">
                    <?
                    echo "<p>$display_name</p>";
                    ?>
                        <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
                    </div>
                </div>
                        <!-- search form -->
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
                <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="treeview">
                        <a href="../../login/functions/Dashboard.php">
                            <i class="fa fa-home"></i> <span>Home</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-gears"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>
    
<!--END OF SIDEBAR=============================================================================================================-->
    
    
<body onload="addQuestionSet(1)">
<!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Hello!<small>User</small></h1>
            <ol class="breadcrumb">
                <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="manage_test.php">List Of Test</a></li>
                <li><a href="add_test.php">Add Test</a></li>
                <li class="active"><b>Add Questions</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Questions</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
<!--                           <body onload="addQuestionSet(1)">-->
                                <form id="question_input" name="question_input" action="save_questions.php" method="post" > 
                                    <?php
                                    if($_SERVER["REQUEST_METHOD"] == "POST") 
                                    {
                                        $message = $test->checkTestDetails($_POST['title'], $_POST['marks'], $_POST['date'], $_POST['course_id'], $_POST['type']);
                                        if ($message == Constants::STATUS_SUCCESS) 
                                        {
                                    ?>
                                    <input type="hidden" id="title" name="title" value=<? echo $_POST['title']; ?>>
                                    <input type="hidden" id="total_marks" name="total_marks" value=<? echo $_POST['marks']; ?>>
                                    <input type="hidden" id="date" name="date" value=<? echo $_POST['date']; ?>>
                                    <input type="hidden" id="course_id" name="course_id" value=<? echo $_POST['course_id']; ?>>
                                    <input type="hidden" id="type" name="type" value=<? echo $_POST['type']; ?>>
                                    <input type="hidden" id="index" name="index" value="0">
                                    <script>
                                        var form = document.getElementById("question_input");
                                        function addQuestionSet(i) 
                                        {
                                            var question_set = '<div class="row" style="border: 2px solid lightgrey;border-radius: 5px; padding:2em"><div class="form-group"><label>Question '+i+'</label></div><div class="form-group "><textarea name="question' + i + '" placeholder="Enter Question ' + i + '..." class="form-control" style="resize: vertical;" required></textarea></div>' +
//                                                        '<label for="question' + i + '_marks">Marks:</label>' +
                                                        '<div class="form-group"><input type="number" placeholder="Enter Marks" class="form-control" min="1" id="question' + i + '_marks" name="question' + i + '_marks" required></div>' +
                                                        '<div class="form-group"><label for="answer' + i + '">Answer:</label></div>' +
                                                
                                                        '<div class="form-group col-md-1 col-xs-2"><input type="radio" id="answer' + i + '" name="answer' + i + '" value="1" required checked></div>' +
                                                        '<div class="form-group col-md-5 col-xs-10"><input type="text" class="form-control" id="option' + i + '.1" name="option' + i + '.1" placeholder="Option 1" required></div>' +
                                                       
                                                
                                                        '<div class="form-group col-md-1 col-xs-2"><input type="radio" id="answer' + i + '" name="answer' + i + '" value="2" required></div>' +
                                                        '<div class="form-group col-md-5 col-xs-10"><input type="text" class="form-control" id="option' + i + '.2" name="option' + i + '.2" placeholder="Option 2" required></div>' +
                                                        
                                                
                                                        '<div class="form-group col-md-1 col-xs-2"><input type="radio" id="answer' + i + '" name="answer' + i + '" value="3" required></div>' +
                                                        '<div class="form-group col-md-5 col-xs-10"><input type="text" class="form-control" id="option' + i + '.3" name="option' + i + '.3" placeholder="Option 3" required></div>' +
                                                        
                                                
                                                        '<div class="form-group col-md-1 col-xs-2"><input type="radio" id="answer' + i + '" name="answer' + i + '" value="4" required></div>' +
                                                        '<div class="form-group col-md-5 col-xs-10"><input type="text" class="form-control" id="option' + i + '.4" name="option' + i + '.4" placeholder="Option 4" required></div></div>' +
                                                
                                                        '<br><button type="button" class="btn btn-info" id="add_question_set" name="add_question_set" onclick="addQuestionSet(' + (i + 1) + ')">Add Question</button>' +
                                                        '&nbsp;' +
                                                        '<button type="button" class="btn btn-success" id="submit_questions" name="submit_questions" onclick="checkMarks(' + i + ')">Save Questions</button>';
                                                    if (i > 1) {
                                                        document.getElementById("question_" + (i - 1)).removeChild(document.getElementById("add_question_set"));
                                                        document.getElementById("question_" + (i - 1)).removeChild(document.getElementById("submit_questions"));
                                                    }
                                                    var div = document.createElement("div");
                                                    div.setAttribute('class', 'col-md-8 col-md-offset-2');
                                                    div.name = "question_" + i;
                                                    div.id = "question_" + i;
                                                    div.innerHTML = question_set;
                                                    form.appendChild(div);
                                                }
                                                var total_marks = document.getElementById("total_marks").value;
                                                function checkMarks(index) {
                                                    var temp_total = parseInt(0);

                                                    for (var i = 1; i <= index; i++) {
                                                        var negative_marks_flag = 0;
                                                        var current_marks = parseInt(document.getElementById("question" + i + "_marks").value);
                                                        if (isNaN(current_marks)) {
                                                            current_marks = parseInt(0);
                                                        }
                                                        if (current_marks < 1) {
                                                            negative_marks_flag = 1;
                                                            alert("Marks entered for question " + i + " must be greater than 0")
                                                        }
                                                        temp_total = temp_total + current_marks;
                                                    }
                                                    if (total_marks - temp_total == 0) {
                                                        document.getElementById("index").value = index;
                                                        if (negative_marks_flag != 1) {
                                                            document.getElementById("question_input").submit();
                                                        }
                                                    } else {
                                                        alert("Sum of marks does not match to total marks");
                                                    }
                                                }
                                            </script>
                                            <?

                                        } else {
                                            header("Location: add_test.php?message=" . $message);
                                        }
                                    }else{
                                        echo $test->parentPageRedirect("Error processing request");
                                    }
                                    ?>
                                    </form>
                            
                        </div>
                    </div>
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
