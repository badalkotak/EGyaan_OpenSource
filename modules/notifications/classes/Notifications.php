<?php

class Notifications
{
    public function sendNotif($token,$title,$body)
    {
    	$ch = curl_init("https://fcm.googleapis.com/fcm/send");

	    //Server Key
	    $key="AAAAvMWRCd4:APA91bG4GveyfLkeuKDqxVaIKAD1kEhZeMdmmKnHTPSl9KTsDCE3nrTt6EhdXi4_1W06zV5TZqQSBsx0t0x2ceWv_ZeWzdxUL23g5WJBum8Wp6fLIAbXhzhFIi-R2zSvtlcphx43Bwfb";
	    
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
	    return $response;
    }
}
?>