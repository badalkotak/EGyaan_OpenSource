<html>
<body>
<form action="?" method="post">

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
    <label for="type">Type of test:</label>
    <input type="radio" id="type" name="type" value="online" checked required>Online
    <input type="radio" id="type" name="type" value="offline" required>Offline
    <button formaction="add_questions.php" formmethod="post" id="test_button" name="test_button" type="submit">Next</button>
    <?
}
?>

</form>
</body>
</html>