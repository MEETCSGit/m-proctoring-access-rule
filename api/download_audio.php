<?php



require($_COOKIE['dirroot'].'/config.php');

$atmid=$_REQUEST['atmid'];
$mdl=$CFG->dataroot;

$sql="SELECT ss.screencapture  as files1  from  mdl_quizaccess_mproct_uservideo as ss where ss.attemptid=". $atmid ;






$rec= $DB->get_field_sql($sql);



$url=$mdl.$rec;
$file_name = basename($mdl.$rec);
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"".$file_name."\""); 
readfile($url);
exit;

?>