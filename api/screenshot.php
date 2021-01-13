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
error_log($error_message); 
$t1='MEETCS-';

$t=time();
$t1='MEETCS-';
$id=$_COOKIE['attemptid'];
$quiz=$_COOKIE['quizid'];
$userid=$_COOKIE['userid'];


$moodleData=$CFG->dataroot;
$filePathSS = $moodleData.'/m_proctoring_uploads/attempt_'.$id.'/screenshot/';
$su=true;
           
        if (!is_dir($filePathSS))
        {
          
            $su= mkdir($filePathSS, 0777, true);
        }

        
       if ($su)
       {
        define('UPLOAD_DIR', $filePathSS);
        $img = $_POST['imgdata'];


        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        
        $t=date("Y-m-d_H:i:s",$t);
        error_log($t);
        $fname=uniqid() . '.png';
        $file = UPLOAD_DIR .$fname;
        $success = file_put_contents($file, $data);
        error_log($file); 
        if ($success){
            $file='/m_proctoring_uploads/attempt_'.$id.'/screenshot/'.$fname;
            $record = new stdClass();
            $record->attemptid = $id;
            $record->quizid =    $quiz;
            $record->userid=     $userid;
            $record->filepath=$file;
            $t=time();
            $record->timecreated= $t;
            $record->timemodified= $t;
            $DB->insert_record('quizaccess_mproct_screenshot', $record);
            
        echo $file;
        }

}
            else{
                echo "sfsf";
            }
?>