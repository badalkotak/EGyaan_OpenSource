
<?php
$ch = curl_init("https://fcm.googleapis.com/fcm/send");

    //The device token.
    $token = "eJ1wQ5hDZwU:APA91bHEQv7Ultk3qSXHyDpcB6oFgraGzC37oYWXr36GO8EgjzXo7D4tDDwrwy-sW6OGJOkFH60nvEphoIhYQ4O5KijQ3Znlc_edYTbaV19_7xTf_wYsTdRoFwJybnejB-J9hZ8AMUIm"; //token here
    
    //Jignesh Android token
    // $token = "cZyNhvdl2Sg:APA91bHCPb7zm_viB72ucQJBp3NWmJshkHxctcRhfnh4qJDQueMqXbifmLCqKY1gaypEVgKRxrRFDCNrdagkFtSnVHwnIuHwsTOR27dKiFLncyo-50RqKRu_IHFx0jyFQ1J6m-vdqkxK";

    //Server Key
    $key="AAAAvMWRCd4:APA91bG4GveyfLkeuKDqxVaIKAD1kEhZeMdmmKnHTPSl9KTsDCE3nrTt6EhdXi4_1W06zV5TZqQSBsx0t0x2ceWv_ZeWzdxUL23g5WJBum8Wp6fLIAbXhzhFIi-R2zSvtlcphx43Bwfb";

    //Title of the Notification.
    $title = "EGyaan";

    //Body of the Notification.
    $body = "Hey Bro, wassup man!!";

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
?>