<?php

require($_COOKIE['dirroot'].'/config.php');
$error_message = "This is an error message!"; 
  
// path of the log file where errors need to be logged 
$log_file = "./my-errors.log"; 
  
// setting error logging to be active 
ini_set("log_errors", TRUE);  
  
// setting the logging file in php.ini 
ini_set('error_log', $log_file); 
  
// logging the error 
$userid=$_COOKIE['userid'];

$moodleData=$CFG->dataroot; 

$dirpath = $moodleData.'/m_proctoring_uploads/temp/profile/';
if (!is_dir($dirpath)) {
    mkdir($dirpath, 0777, true);
}
$img = $_POST['imgdata'];


        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);

       
        $file = $dirpath . uniqid() . '.png';
        $success = file_put_contents($file, $data);

$profile =  fopen($file,'r');

$ocpApimSubscriptionKey = 'f821fba7287b4a93b687033a16fb519a';
$uriBase = 'https://meetcs.cognitiveservices.azure.com/face/v1.0/';

// $imageUrl =
//     'https://raw.githubusercontent.com/Azure-Samples/cognitive-services-sample-data-files/master/ComputerVision/Images/faces.jpg';

// This sample uses the PHP5 HTTP_Request2 package
// (https://pear.php.net/package/HTTP_Request2).
require_once 'HTTP/Request2.php';

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

// Request body parameters
$body = $profile;

// Request body
$request->setBody($body);

$facecount = 0;

try
{
    $response1 = $request->send();
    $facecount = count(json_decode($response1->getBody()));
}
catch (HttpException $ex)
{
    echo "<pre>" . $ex . "</pre>";
}

echo $facecount;

?>