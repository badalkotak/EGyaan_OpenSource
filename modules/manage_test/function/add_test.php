<html>
<head>
    <script src="../../../Resources/jquery.min.js"></script>
    <script src="get_option.js"></script>
</head>
<body>
<form id="test_input" action="?" method="post" enctype="multipart/form-data">

<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Test.php");
require_once("../../manage_course/classes/Course.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

include("../../../Resources/sessions.php");

$teacher_id = $id;
if(isset($_REQUEST["message"]) && !empty(trim($_REQUEST["message"]))){
    echo '<script>alert("' . $_REQUEST["message"] . '");</script>';
}
$test = new Test($dbConnect->getInstance());
$course=new COurse($dbConnect->getInstance());
$result=$test->getBranch();
$getTeacherCourse=$course->getCourse("yes",$teacher_id,"no",0,0,null,0);
if($getTeacherCourse===false)
{
    $result=$course->getCourse("no",0,'no',0,0,null,0);
    if($result!=null) {
        ?>
        <select title="Select course" id="course_id" name="course_id" required>
        <?php
        echo "<option value='0' selected> Select a Course </option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['courseId'] . "'>" . $row['branchName'] . " - " . $row['batchName'] . " - " . $row['courseName'] . "</option>";
        }
        ?>
        </select>
        <?php
    }else{
        echo "No Course added yet!!!";
    }
        ?>
    </select>
    <?php
}
else
{
    ?>
    <div id="branch_list">
    <?php
    if($result!=null)
    {
        ?>

        <select title="Select branch" id="branch_id" name="branch_id" required>
            <?php
            echo "<option value='0' selected> Select a Branch </option>";
            while($row = $result->fetch_assoc()){
                echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
            }
            ?>
        </select>
        <?php
    }else{
        echo "No Branches added yet!!!";
    }
    ?>
    </div>
    <div id="batch_list"></div>
    <div id="course_list"></div>
    <?php
}
?>
    <div id="form_input"></div>
</form>
</body>
<script>
    var form = document.getElementById("form_input");
    var br = document.createElement("br");
    function changeAction() {
        form.removeChild(document.getElementById("test_button"));
        var button = document.createElement("button");
        if (document.getElementById("online").checked) {
            console.log("online");
            var visible_file_input = document.getElementById("test_file");
            if (typeof(visible_file_input) != 'undefined' && visible_file_input != null) {
                if (typeof(visible_file_input.nextElementSibling) != 'undefined' && visible_file_input.nextElementSibling != null) {
                    form.removeChild(visible_file_input.nextElementSibling);
                }
                form.removeChild(visible_file_input);
            }
            button.setAttribute('formaction', 'add_questions.php');
        } else {
            console.log("offline");
            button.setAttribute('formaction', 'add_offline_test.php');
            var file_input = document.createElement("input");
            file_input.setAttribute('type', 'file');
            file_input.setAttribute('id', 'test_file');
            file_input.setAttribute('name', 'test_file');
            form.appendChild(file_input);
            form.appendChild(br);
        }
        button.setAttribute('formmethod', 'post');
        button.setAttribute('id', 'test_button');
        button.setAttribute('name', 'test_button');
        button.setAttribute('type', 'submit');
        button.innerHTML = 'Next';
        form.appendChild(button);
    }
</script>
</html>