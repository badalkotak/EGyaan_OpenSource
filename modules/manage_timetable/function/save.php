<?php
require_once("../../notifications/classes/Notifications.php");

$notifications = new Notifications();
				$notifications->sendNotif("eJ1wQ5hDZwU:APA91bHEQv7Ultk3qSXHyDpcB6oFgraGzC37oYWXr36GO8EgjzXo7D4tDDwrwy-sW6OGJOkFH60nvEphoIhYQ4O5KijQ3Znlc_edYTbaV19_7xTf_wYsTdRoFwJybnejB-J9hZ8AMUIm","Timetable","Hey, there is a change in your Timetable!");

header('Location: timetable_select_branch_batch.php');
?>