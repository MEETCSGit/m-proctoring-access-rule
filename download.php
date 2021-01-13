<?php
$url=$_REQUEST['url1'];
$file_name = basename($url);
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"".$file_name."\""); 
readfile($url);
exit;

?>