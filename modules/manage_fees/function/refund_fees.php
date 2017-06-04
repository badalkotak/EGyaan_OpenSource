<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Fees.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
$user_id = 1; //To Do: Change This
$fees = new Fees($dbConnect->getInstance());
$result = $fees->getPaidFees($_REQUEST["id"]);
if($result != null){
    $row=$result->fetch_assoc();
    if($row["fees_paid"] > 0){
        if($fees->refundFees($_REQUEST["id"])){
            $fees->parentPageRedirect("Give the refund amount Rs." .$row["fees_paid"] . " to the student now.");
        }else{
            $fees->parentPageRedirect("Error while processing");
        }
    }else{
        $fees->parentPageRedirect("The student have not submitted any fees yet.");
    }

}else{
    $fees->parentPageRedirect("Student entry not found");
}
?>