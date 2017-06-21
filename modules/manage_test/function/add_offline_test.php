<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Test.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
$teacher_id = 3; //To Do: Change This
$test = new Test($dbConnect->getInstance());
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $test_id = $test->insertTest($_POST['title'], $_POST['marks'], $_POST['date'], $_POST['course_id'], $teacher_id, $_POST['type']);
    if (is_numeric($test_id) && $test_id > 0) {
        if (empty($_FILES)) {
            $test->parentPageRedirect("Please attach a soft copy of the test");
        } else {
            $new_name_of_uploaded_file = $test_id . '.pdf';
            if (!is_dir('offline_test')) {
                $test->deleteTest($test_id, $teacher_id);
                $test->parentPageRedirect("Folder not found on server");
            } else {
                $name_of_uploaded_file = basename($_FILES["test_file"]["name"]);
                $type_of_uploaded_file = substr($name_of_uploaded_file, strrpos($name_of_uploaded_file, '.') + 1);
                if ($type_of_uploaded_file != "pdf") {
                    $test->deleteTest($test_id, $teacher_id);
                    $test->parentPageRedirect("Please attach soft copy in pdf format only");
                } else {
                    $path_of_uploaded_file = "offline_test/" . $new_name_of_uploaded_file;
                    $tmp_path = $_FILES["test_file"]["tmp_name"];
                    if (is_uploaded_file($tmp_path)) {
                        if (copy($tmp_path, $path_of_uploaded_file)) {
                            $test->parentPageRedirect("Test added successfully");
                        } else {
                            $test->deleteTest($test_id, $teacher_id);
                            $test->parentPageRedirect("Error while uploading file");
                        }
                    } else {
                        $test->deleteTest($test_id, $teacher_id);
                        $test->parentPageRedirect("Error while uploading file");
                    }
                }
            }
        }
    } else {
        if ($test_id == null) {
            $test->parentPageRedirect("Error while processing"); //Error generated while inserting test details
        } else {
            $test->parentPageRedirect($test_id); //Duplicate test entry
        }
    }
}else{
    $test->parentPageRedirect("Error while processing");
}