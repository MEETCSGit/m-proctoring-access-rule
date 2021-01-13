<?php

require($_COOKIE['dirroot'].'/config.php');

$t1='MEETCS-';
$id=$_COOKIE['attemptid'];
$quiz=$_COOKIE['quizid'];
$userid=$_COOKIE['userid'];
$attempt=$_COOKIE['attempt'];
$moodleData=$CFG->dataroot;
if (!file_exists($moodleData.'/m_proctoring_uploads/attempt_'.$id.'/video')) {
    mkdir($moodleData.'/m_proctoring_uploads/attempt_'.$id.'/video', 0777, true);
}

if (!file_exists($moodleData.'/m_proctoring_uploads/attempt_'.$id.'/url')) {
    mkdir($moodleData.'/m_proctoring_uploads/attempt_'.$id.'/url', 0777, true);
}


$filePathVideo = $moodleData.'/m_proctoring_uploads/attempt_'.$id.'/video/'.$id.'-'. $_POST['video-filename'];
$u=$_POST['username'];
// path to ~/tmp directory
$tempName = $_FILES['video-blob']['tmp_name'];





// move file from ~/tmp to "uploads" directory
if (!move_uploaded_file($tempName, $filePathVideo)) {
    // failure report
    echo 'Problem saving file: '.$tempName;
    die();
}

$filePathURL=$moodleData.'/m_proctoring_uploads/attempt_'.$id.'/url/'.$id.'-'.$t1 ."-url.txt";
$myfile = fopen($filePathURL, "w") or die("Unable to open file!");
$val=$_POST["students"];
fwrite($myfile,str_replace(",","\n",$val));

fclose($myfile);

$urlFileSize=filesize($filePathURL);
// $contract_path = $id.'-'.$t1 ."-url.txt";
// $contract_video_path =  $id.'-'. $_POST['video-filename'];

$filePathURL='/m_proctoring_uploads/attempt_'.$id.'/url/'.$id.'-'.$t1 ."-url.txt";
$filePathVideo='/m_proctoring_uploads/attempt_'.$id.'/video/'.$id.'-'. $_POST['video-filename'];

$record = new stdClass();
$record->attemptid = $id;
$record->quizid =    $quiz;
$record->userid=     $userid;
$record->attempt=    $attempt;
$record->urlfilesize=    $urlFileSize;
$record->url=$filePathURL;
$record->screencapture=$filePathVideo;

$t=time();
$record->timecreated= $t;
$record->timemodified= $t;


$DB->insert_record('quizaccess_mproct_uservideo', $record);


?>





