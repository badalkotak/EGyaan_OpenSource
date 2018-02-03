<?php
require_once("../../notifications/classes/Notifications.php");

$notifications = new Notifications();
				$notifications->sendNotif("fRNcXpfADPI:APA91bGB1dKdhsx0t7uGs3btdDTL584ukVL8p_z2CafbuNcKLcETHVQmcM0ftxcoYvW-ucrHAkJDSQe72TKakAE1EcJeXVnR-_sl9IQuRI51gxovVH_6BpIufIJ7LGigbkGrEHAwoiZ7","Timetable","Hey, there is a change in your Timetable!");

// header('Location: timetable_select_branch_batch.php');

if($notifications)
{
	echo "Success";
}
?>