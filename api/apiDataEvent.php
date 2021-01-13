<?php

require($_COOKIE['dirroot'].'/config.php');

$t1='MEETCS-';
$id=$_COOKIE['attemptid'];
$quiz=$_COOKIE['quizid'];
$userid=$_COOKIE['userid'];
$attempt=$_COOKIE['attempt'];
$moodleData=$CFG->dataroot;


$u=$_POST['username'];
// path to ~/tmp directory
if (!file_exists($moodleData.'/m_proctoring_uploads/attempt_'.$id.'/url/')) {
    mkdir($moodleData.'/m_proctoring_uploads/attempt_'.$id.'/url/', 0777, true);
}
$filePathURL=$moodleData.'/m_proctoring_uploads/attempt_'.$id.'/url/'.$id.'-'.$t1 ."-url.txt";
$myfile = fopen($filePathURL, "w") or die("Unable to open file!");
$val=$_POST["students"];
fwrite($myfile,str_replace(",","\n",$val));

fclose($myfile);

$urlFileSize=filesize($filePathURL);
// $contract_path = $id.'-'.$t1 ."-url.txt";
// $contract_video_path =  $id.'-'. $_POST['video-filename'];
$eventSecond=$_POST['eventSecond'];

$startTime=$_POST['startTime'];
$endTime=$_POST['endTime'];
       

$filePathURL='/m_proctoring_uploads/attempt_'.$id.'/url/'.$id.'-'.$t1 ."-url.txt";

$record = new stdClass();
$record->attemptid = $id;
$record->quizid =    $quiz;
$record->userid=     $userid;
$record->attempt=    $attempt;
$record->urlfilesize=  $urlFileSize;
$record->url=$filePathURL;
$record->eventsecond=$eventSecond;

$t=time();
$record->timecreated= $t;
$record->timemodified= $t;

$rec=$DB->get_record('quiz',[ 'id'=>$quiz ], $fields='timelimit', $strictness=IGNORE_MISSING);
$qtime=$rec->timelimit;
$totalsecper=0;
if($qtime!='0')
{
    $totalsec=floatval ($qtime);
    $totalsecper=floatval((floatval ($eventSecond)/$totalsec)*100);
}else
{
    $totalmil=$endTime-$startTime;
    $totalsec=$totalmil/1000;
    $totalsecper=(floatval ($eventSecond)/floatval ($totalsec))*100.0;
}
$record->eventsecond=strval($eventSecond);
$record->eventpercentage=strval($totalsecper);

$DB->insert_record('quizaccess_mproct_userevent', $record);
print_r($rec);
echo $totalsecper."-".$totalsec."-".$eventSecond;

?>





