<?php


require($_COOKIE['dirroot'].'/config.php');

$atmid=$_REQUEST['atmid'];
$mdl=$CFG->dataroot;

$sql="SELECT GROUP_CONCAT( ss.filepath SEPARATOR ',') as files1  from  mdl_quizaccess_mproct_screenshot as ss where ss.attemptid=". $atmid ." GROUP BY ss.attemptid";

$rec= $DB->get_field_sql($sql);
$files=explode(",",$rec);

if (!file_exists($mdl.'/m_proctoring_uploads/garbage_zip/')) {
  mkdir($mdl.'/m_proctoring_uploads/garbage_zip/', 0777, true);
}


$zip = new ZipArchive();
$zip_name = time().".zip"; // Zip name
$zip->open($mdl.'/m_proctoring_uploads/garbage_zip/'.$zip_name,  ZipArchive::CREATE);
foreach ($files as $file) {
 $path = $mdl.$file;
  if(file_exists($path)){
  $zip->addFromString(basename($path),  file_get_contents($path));  
  }
  
}
$zip->close();



header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$zip_name);
header('Content-Length: ' . filesize($mdl.'/m_proctoring_uploads/garbage_zip/'.$zip_name));
readfile($mdl.'/m_proctoring_uploads/garbage_zip/'.$zip_name);



?>