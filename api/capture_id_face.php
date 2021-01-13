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

$quiz=$_COOKIE['quizid'];
$userid=$_COOKIE['userid'];


$moodleData=$CFG->dataroot;
$filePathSS = $moodleData.'/m_proctoring_uploads/profile/'.$userid.'/'.$quiz.'/';
$su=true;
           
        if (!is_dir($filePathSS))
        {
          
            $su= mkdir($filePathSS, 0777, true);
        }

        
       if ($su)
       {
        define('UPLOAD_DIR', $filePathSS);
        $imgid = $_POST['imgdataid'];


        $imgid = str_replace('data:image/png;base64,', '', $imgid);
        $imgid = str_replace(' ', '+', $imgid);
        $dataid = base64_decode($imgid);
        $fnameid= uniqid() .'_id'. '.png';
        $fileid = UPLOAD_DIR . $fnameid;
        $successid = file_put_contents($fileid, $dataid);
       
       
        $imgface = $_POST['imgdataface'];


        $imgface = str_replace('data:image/png;base64,', '', $imgface);
        $imgface = str_replace(' ', '+', $imgface);
        $dataface = base64_decode($imgface);
        $fnameface= uniqid() .'_face'. '.png';
        $fileface = UPLOAD_DIR .$fnameface;
        $successface = file_put_contents($fileface, $dataface);


                if ($successid && $successface){
                    

                    $fileface='/m_proctoring_uploads/profile/'.$userid.'/'.$quiz.'/'.$fnameface;
                    $fileid='/m_proctoring_uploads/profile/'.$userid.'/'.$quiz.'/'.$fnameid;
                    $record = new stdClass();
                    $record->quizid =    $quiz;
                    $record->userid=     $userid;
                    $record->facepath=$fileface;
                    $record->idpath=$fileid;
                    $t=time();
                    $record->timecreated= $t;
                    $record->timemodified= $t;

                    
                   $data=$DB->insert_record('quizaccess_mproct_auth', $record);
                   
                   setcookie("userAuth", 'true',time() + 3600,'/');
                   setcookie("face_id", $data,time() + 3600,'/');
                echo "done";
                }

}
            else{
                echo "error";
            }
?>