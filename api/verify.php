<?php

require_once('C:\xampp\htdocs\moodle_site\config.php');

require_once 'HTTP/Request2.php';
$error_message = "This is an error message!"; 
  
// path of the log file where errors need to be logged 
$log_file = "./check.log"; 
  
// setting error logging to be active 
ini_set("log_errors", TRUE);  
  
// setting the logging file in php.ini 
ini_set('error_log', $log_file); 
  
// logging the error 





function  get_face_id($auth_image_url){
    
    $ocpApimSubscriptionKey = 'f821fba7287b4a93b687033a16fb519a';
    $uriBase = 'https://meetcs.cognitiveservices.azure.com/face/v1.0/';

    $request = new Http_Request2($uriBase . '/detect');
    $url = $request->getUrl();

    $headers = array(
        // Request headers
        'Content-Type' => 'application/octet-stream',
        'Ocp-Apim-Subscription-Key' => $ocpApimSubscriptionKey
    );
    $request->setHeader($headers);

    $parameters = array(
        // Request parameters
        'detectionModel' => 'detection_02',
        'returnFaceId' => 'true');

    $url->setQueryVariables($parameters);

    $request->setMethod(HTTP_Request2::METHOD_POST);

    // $resource = fopen('./Shaki_waterfall.jpg', 'r');
    // $profile = fopen('C:/xampp/moodledata/'.$auth_image_url, 'r');

    $profile = fopen($auth_image_url, 'r');
     
    // Request body parameters
    // $body = json_encode(array('url' => $imageUrl));
    $body = $profile;

    // Request body
    $request->setBody($body);

    $response_body = "";
    try
    {
        $response = $request->send();
        $response_body = json_decode($response->getBody());
    }
    catch (HttpException $ex)
    {
        echo "<pre>" . $ex . "</pre>";
    }
    
    $result_array = array();
    print_r ($response_body);
    if(count($response_body) == 1){
        array_push($result_array,$response_body[0]->{'faceId'});
    }
    else if(count($response_body) > 1){
        foreach($response_body as $face){
            array_push($result_array,$face->{'faceId'});
        }
    }

    return $result_array;
}

function verify_faces($auth_face_id,$current_face_id){
    
    $ocpApimSubscriptionKey = 'f821fba7287b4a93b687033a16fb519a';
    $uriBase = 'https://meetcs.cognitiveservices.azure.com/face/v1.0/';

    // verify request
    $verify_request = new Http_Request2($uriBase . '/verify');
    $url = $verify_request->getUrl();

    $headers = array(
        // Request headers
        'Content-Type' => 'application/json',
        'Ocp-Apim-Subscription-Key' => $ocpApimSubscriptionKey
    );
    $verify_request->setHeader($headers);

    $verify_request->setMethod(HTTP_Request2::METHOD_POST);

    // echo $response1_body[0]->{'faceId'}.'<br>';
    // echo $response2_body[0]->{'faceId'}.'<br>';

    $body = json_encode(array('faceId1' =>$auth_face_id,'faceId2' => $current_face_id));
    // $body = json_encode(array('faceId1' => "93e61437-3649-4dd5-b730-000569a3e540",'faceId2' => "c3ea3222-079a-409d-beb1-735eb95a119a"));


    echo $body;

    // Request body
    $verify_request->setBody($body);

    try
    {
        $response3 = $verify_request->send();
    }
    catch (HttpException $ex)
    {
        echo "<pre>" . $ex . "</pre>";
    }
    $result = json_decode($response3->getBody());

    return $result;
}

$attempt_records=$DB->get_records_sql("select DISTINCT(attemptid), quizid, userid from mdl_quizaccess_mproct_userphoto where matchingpercent is null order by attemptid asc");

foreach($attempt_records as $attempt){

    try{
        $attempt_details =$DB->get_records_sql("select id, url from mdl_quizaccess_mproct_userphoto where attemptid = ".$attempt->{'attemptid'}." and matchingpercent is null");

        //get auth image url
        $facepath = $DB->get_record("quizaccess_mproct_auth", array("attemptid" => $attempt->{'attemptid'}), $fields='facepath', $strictness=IGNORE_MISSING);
        
        $auth_image_url = ($facepath->{'facepath'});
     
        // GET auth image face_id from azure for verification
        $result = get_face_id($CFG->dataroot.$auth_image_url);

        $auth_face_id = $result[0];
        
        //verify for images by api call
        foreach($attempt_details as $photo){
            try{
                $current_face_id = get_face_id($CFG->dataroot.$photo->{'url'});

                if(count($current_face_id) == 0){
                    //no face in image update matching percent is zero
                    $DB->execute('update mdl_quizaccess_mproct_userphoto set matchingpercent = 0 where id = '.$photo->{'id'});
                }
                else if(count($current_face_id) == 1) {
                    $result = verify_faces($auth_face_id,$current_face_id[0]);

                    $confidence = $result->{'confidence'} * 100;

                    //update matchingpercent in mdl_quizaccess_mproct_userphoto

                    $DB->execute('update mdl_quizaccess_mproct_userphoto set matchingpercent = '.$confidence.' where id = '.$photo->{'id'});
                }
                else if(count($current_face_id)  > 1){
                    $DB->execute('update mdl_quizaccess_mproct_userphoto set matchingpercent = 0 , multiplefaces = 1 where id = '.$photo->{'id'});
                }
            }catch(Exception $e){
                // exception for mathcing random picture
                echo "Exception ".$e;
            } 
            //sleep for 70 milisecond 70k microsec
            error_log("hello"); 
            usleep(70000);          
        }
    }catch(Exception $e){
        // exception for profile
        echo "Exception ".$e;
    }

}

?>