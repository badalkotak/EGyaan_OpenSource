<?php
/**
 * Created by PhpStorm.
 * User: adityajthakker
 * Date: 30/12/16
 * Time: 12:07 PM
 */
require_once "classes/DBConnect.php";
session_start();
$_SESSION["teacher_id"] = 2;
if (!isset($_SESSION["teacher_id"])) {
    //redirect
}
$db = new DBConnect();
$connection = $db->getInstance();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mark Attendance</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>

</head>
<body>
<div id="message">
    <p>
        <?php
        if (isset($_REQUEST["status"], $_REQUEST["message"])) {
            echo $_REQUEST["message"];
        }
        ?>
    </p>
</div>

</body>
</html>
