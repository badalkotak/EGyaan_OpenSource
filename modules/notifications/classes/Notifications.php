<?php

class Notifications
{
    public function sendNotif($token,$title,$body)
    {
    	$ch = curl_init("https://fcm.googleapis.com/fcm/send");

	    //Server Key
	    $key="AAAAAGv28AA:APA91bF2aPtEWRaU1sQm5DINpIRrGjSVs2fkCEfDeicBONJP2FHuf1bFI6hCceeVKusO-5WokX4dWf0fBRcQEdkyGJ9roi-ARTNNpZ0uDMmaIFjdwsudKVlZivH6J-0EICQjMZhu23NC";
	    
	    //Creating the notification array.
	    $notification = array('title' =>$title , 'text' => $body);

	    //This array contains, the token and the notification. The 'to' attribute stores the token.
	    $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');

	    //Generating JSON encoded string form the above array.
	    $json = json_encode($arrayToSend);

	    //Setup headers:
	    $headers = array();
	    $headers[] = 'Content-Type: application/json';
	    $headers[] = 'Authorization: key= '.$key; // key here

	    //Setup curl, add headers and post parameters.
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);       

	    //Send the request
	    $response = curl_exec($ch);

	    //Close request
	    curl_close($ch);
	    // return $response;
    }
}
?>