<?php


require($_COOKIE['dirroot'].'/config.php');

$atmid=$_REQUEST['atmid'];
$typ=$_REQUEST['type'];
$mdl=$CFG->dataroot;


$sql="SELECT ".$typ." from  mdl_quizaccess_mproct_auth as aut where aut.attemptid=". $atmid ;

$rec= $DB->get_field_sql($sql);

$path = $mdl.$rec;
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

echo $base64;


?>