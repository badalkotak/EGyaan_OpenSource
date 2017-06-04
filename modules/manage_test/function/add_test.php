<html>
<body>
<form id="test_input" action="?" method="post" enctype="multipart/form-data">

<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Test.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
$teacher_id = 1; //To Do: Change This
$test = new Test($dbConnect->getInstance());
if(isset($_REQUEST["branch_id"])){
    $branch_id = $_REQUEST["branch_id"];
}else{
    $branch_id = 0;
}
if(isset($_POST["batch_id"])){
    $batch_id = $_POST["batch_id"];
    if(isset($_POST["branch_button"])){
        $batch_id = 0;
    }
}else{
    $batch_id = 0;
}
if(isset($_POST["course_id"])){
    $course_id = $_POST["course_id"];
    if(isset($_POST["branch_button"]) || (isset($_POST["batch_button"]))){
        $course_id = 0;
    }
}else{
    $course_id = 0;
}
$result=$test->getBranch();
if($result!=null)
{
    ?>

    <select title="Select branch" name="branch_id" required>
        <?php
        echo "<option value='0' selected> Select a Branch </option>";
        while($row = $result->fetch_assoc()){
            echo "<option value='" . $row["id"] . "' " . ((($row["id"]) == $branch_id)?"selected":"") . ">" . $row["name"] . "</option>";
        }
        ?>
    </select>
    <button id="branch_button" name="branch_button" type="submit">Send</button><br>
    <?
}else{
    echo "No Records";
}

if($branch_id>0){
    $result=$test->getBatch($teacher_id,$branch_id);
    if($result!=null)
    {
        ?>

        <select title="Select batch" name="batch_id" required>
            <?php
            echo "<option value='0' selected> Select a Batch </option>";
            while($row = $result->fetch_assoc()){
                echo "<option value='" . $row["id"] . "' " . ((($row["id"]) == $batch_id)?"selected":"") . ">" . $row["name"] . "</option>";
            }
            ?>
        </select>
        <button id="batch_button" name="batch_button" type="submit">Send</button><br>
        <?
    }else{
        echo "No Records";
    }
}


if($batch_id>0){
    $result=$test->getCourse($teacher_id,$branch_id,$batch_id);
    if($result!=null)
    {
        ?>

        <select title="Select course" name="course_id" required>
            <?php
            echo "<option value='0' selected> Select a Course </option>";
            while($row = $result->fetch_assoc()){
                echo "<option value='" . $row["id"] . "' " . ((($row["id"]) == $course_id)?"selected":"") . ">" . $row["name"] . "</option>";
            }
            ?>
        </select>
        <button id="course_button" name="course_button" type="submit">Send</button><br>
        <?
    }else{
        echo "No Records";
    }
}
if($course_id>0){
    ?>
    <!-- Input for name marks date and type -->
    <label>Enter Test Title:</label>
    <input type="text" id="title" name="title" placeholder="Enter test title" required><br>
    <label>Enter Marks:</label>
    <input type="number" min=1 id="marks" name="marks" placeholder="Enter marks here" required><br>
    <label for="date">Date of test:</label>
    <input type="date" id="date" name="date" required><br>
    <label>Type of test:</label>
    <input type="radio" id="online" name="type" value="online" onchange="changeAction()" checked required><label for="online">Online</label>
    <input type="radio" id="offline" name="type" value="offline" onchange="changeAction()" required><label for="offline">Offline</label><br>
    <button formaction="add_questions.php" formmethod="post" id="test_button" name="test_button" type="submit">Next</button>
    <script>
        var form = document.getElementById("test_input");
        var br = document.createElement("br");
        function changeAction(){
            form.removeChild(document.getElementById("test_button"));
            var button = document.createElement("button");
            if(document.getElementById("online").checked){
                console.log("online");
                var visible_file_input=document.getElementById("test_file");
                if (typeof(visible_file_input) != 'undefined' && visible_file_input != null)
                {
                    if(typeof(visible_file_input.nextElementSibling) != 'undefined' && visible_file_input.nextElementSibling != null){
                        form.removeChild(visible_file_input.nextElementSibling);
                    }
                    form.removeChild(visible_file_input);
                }
                button.setAttribute('formaction','add_questions.php');
            }else{
                console.log("offline");
                button.setAttribute('formaction','add_offline_test.php');
                var file_input=document.createElement("input");
                file_input.setAttribute('type','file');
                file_input.setAttribute('id','test_file');
                file_input.setAttribute('name','test_file');
                form.appendChild(file_input);
                form.appendChild(br);
            }
            button.setAttribute('formmethod','post');
            button.setAttribute('id','test_button');
            button.setAttribute('name','test_button');
            button.setAttribute('type','submit');
            button.innerHTML = 'Next';
            form.appendChild(button);
        }
    </script>
    <?
}
?>

</form>
</body>
</html>