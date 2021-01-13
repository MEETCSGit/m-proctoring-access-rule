<?php

require($_COOKIE['dirroot'].'/config.php');

$t1='MEETCS-';
$id=$_COOKIE['attemptid'];
$quiz=$_COOKIE['quizid'];
$userid=$_COOKIE['userid'];
$moodleData=$CFG->dataroot; 

if (!is_dir($moodleData.'/m_proctoring_uploads/attempt_'.$id.'/photos/')) {
    mkdir($moodleData.'/m_proctoring_uploads/attempt_'.$id.'/photos/', 0777, true);
}

// new filename
$filename = 'pic_'.$userid.'_'.date('YmdHis') . '.jpeg';

// $filePathURL=$moodleData.'/m_proctoring_uploads/photos/upload/'.$filename;
$filePathURL=$moodleData.'/m_proctoring_uploads/attempt_'.$id.'/photos/'.$filename;


if(!move_uploaded_file($_FILES['webcam']['tmp_name'],$filePathURL) ){

    // echo 'Problem saving file: '.$filename;
    error_log('user id : '.$userid.'Problem saving file: '.$filename); 
    die();
}

$urlFileSize=filesize($filePathURL);

$filePathURL='/m_proctoring_uploads/attempt_'.$id.'/photos/'.$filename;

require_once 'HTTP/Request2.php';

function  get_face_id($auth_image_url,$moodleData){
    
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
    
    $photopath = $moodleData.''.$auth_image_url;

    $profile = fopen($photopath, 'r');
     
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
        // echo "<pre>" . $ex . "</pre>";
        error_log('user id : '.$userid.' '.$ex); 

    }
    
    $result_array = array();

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

    $body = json_encode(array('faceId1' =>$auth_face_id,'faceId2' => $current_face_id));
    
    // Request body
    $verify_request->setBody($body);

    try
    {
        $response3 = $verify_request->send();
    }
    catch (HttpException $ex)
    {
        // echo "<pre>" . $ex . "</pre>";
        error_log('user id : '.$userid.' '.$ex); 
    }
    $result = json_decode($response3->getBody());

    return $result;
}

$confidence = null;

$current_face_count = null;

try{
    $faceid = $DB->get_record("quizaccess_mproct_auth", array("attemptid" => $id), $fields='id,auth_face_id', $strictness=IGNORE_MISSING);


    $auth_face_id = ($faceid->{'auth_face_id'});

    if($auth_face_id == null){
        // echo "auth face id is null";
        //get auth image url

        $facepath = $DB->get_record("quizaccess_mproct_auth", array("attemptid" => $id), $fields='facepath', $strictness=IGNORE_MISSING);
        
        $auth_image_url = ($facepath->{'facepath'});

        $result = get_face_id($auth_image_url,$moodleData);

        $auth_face_id = $result[0];
        
        $DB->execute("update mdl_quizaccess_mproct_auth set auth_face_id = '".$auth_face_id."' where id = ".$faceid->{'id'});

    }
    
    $current_face_id = get_face_id($filePathURL,$moodleData);
    
    $current_face_count = count($current_face_id);
    
    if($current_face_count == 1){
        $result = verify_faces($auth_face_id,$current_face_id[0]);
        $confidence = $result->{'confidence'} * 100;
    }

}catch(Exception $e){
    error_log('user id : '.$userid.' '.$e); 

}
$record = new stdClass();
if($current_face_count > 1){
    $record->multiplefaces = 1;
}


$record->attemptid = $id;
$record->quizid =    $quiz;
$record->userid=     $userid;
$record->urlfilesize = $urlFileSize;
$record->url= $filePathURL;
$record->matchingpercent= $confidence;
 
$t=time();
$record->timecreated= $t;
$record->timemodified= $t;
$DB->insert_record('quizaccess_mproct_userphoto', $record);

$result = array("matchingpercent" => $confidence, "face_count" => $current_face_count);

echo json_encode($result);

?>