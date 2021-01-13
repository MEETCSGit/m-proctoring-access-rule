<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Implementation of the quizaccess_mproctoring plugin.
 *
 * @package    quizaccess_mproctoring
 * @author     MEETCS(Atul, Rushab & Abhishek)
 * @copyright  Meetcs@2020
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


require_once($CFG->dirroot . '/mod/quiz/accessrule/accessrulebase.php');


/**
 * Implementation of the quizaccess_mproctoring plugin.
 *
 * 
 */
class quizaccess_mproctoring extends quiz_access_rule_base
{
    private static $enablemproctoing;
    private static $enableevent;
    private static $enablescreencapture;
    private static $enableurl;
    public $attemptidval;
    public $quizid;
    /** @var array options that should be used for opening the secure popup. */
    protected static $popupoptions = array(
        'left' => 0,
        'top' => 0,
        'fullscreen' => true,
        'scrollbars' => true,
        'resizeable' => false,
        'directories' => false,
        'toolbar' => false,
        'titlebar' => false,
        'location' => false,
        'status' => false,
        'menubar' => false,
    );

    


    // public function get_popup_options() {
    //     return self::$popupoptions;
    // }
    public function is_preflight_check_required($attemptid) {
        
        return empty($attemptid);
    }
    public function  notify_preflight_check_passed($attemptid) {
      
    }

    public function add_preflight_check_form_fields(mod_quiz_preflight_check_form $quizform, MoodleQuickForm $mform, $attemptid) {
       
        $mform->addElement('header', 'mproctoingcheckheader',
                 get_string('mproctoingcheckheader', 'quizaccess_mproctoring'));
         $mform->addElement('static', 'mproctoingcheckstatement', '',
                 get_string('mproctoingcheckstatement', 'quizaccess_mproctoring'));
         $mform->addElement('checkbox', 'mproctoingcheck', '',
                 get_string('mproctoingchecklabel', 'quizaccess_mproctoring'));
       
    }

    public function validate_preflight_check($data, $files, $errors, $attemptid) {
        $dat=$_COOKIE["bd"];
        $ext1=$_COOKIE["ext"];

        if ($dat !="true")
        {
            $errors['quizbrowser'] = get_string('browsererror', 'quizaccess_mproctoring');
        } 
        if( $ext1 !="true")
        { 
             $errors['quizbrowser'] = get_string('browsererror', 'quizaccess_mproctoring');

        }
        if (empty($data['mproctoingcheck'])) {
            $errors['mproctoingcheck'] = get_string('youmustagree', 'quizaccess_mproctoring');
        }
        if (!(isset($_COOKIE['userAuth'])) ) {
            $errors['mproctoingcheck'] = get_string('youmustauth', 'quizaccess_mproctoring');
        }
        
        
        if ((isset($_COOKIE['userAuth'])) ) {
            if (($_COOKIE['userAuth']=="false")) {
                $errors['mproctoingcheck'] = get_string('youmustauth', 'quizaccess_mproctoring');
            } 
        }
      
      
        
        
        global $PAGE,$CFG;
        $CFG->cachejs = false;

       //$data= $PAGE->requires->js_call_amd("quizaccess_mproctoring/popupBrowser", 'init',array(get_string('browsererror', 'quizaccess_mproctoring')));

        return $errors;

     

    }
    public function end_time($attempt) {

        $this->attemptidval=$attempt;
        return false;
    }
    
    // public function attempt_must_be_in_popup() {
    //     return !$this->quizobj->is_preview_user();
    // }
    public static function make(quiz $quizobj, $timenow, $canignoretimelimits) {
     if (empty($quizobj->get_quiz()->enablemproctoing)) {
            return null;
        }
        

     
        return new self($quizobj, $timenow);
    }

    
    public  function setup_attempt_page($page){
      
        global $PAGE,$CFG;
        // print_r("<pre>");
        // print_r();
        // exit();
       // $page->set_pagelayout('popup');
       // $this->prevent_display_blocks();
       
      
       //print_r( $PAGE->url);
    
         $page->set_popup_notification_allowed(false); // Prevent message notifications.
        $page->set_title($this->quizobj->get_course()->shortname . ': ' . $page->title);
        $page->set_cacheable(false);
        $page->set_pagelayout('secure');
        
        if ($this->quizobj->is_preview_user()) {
            return;
        }

       $page->add_body_class('quiz-secure-window');
       $page->requires->js_init_call('M.mod_quiz.secure_window.init',null, false, quiz_get_js_module());
       $cm = $PAGE->cm;

       $params=[];

       $array = (array) $PAGE->url;

       //print_r($CFG->wwwroot);
       //exit();
       foreach ( $array as $key => $value )
            {
                if (strpos($key, 'params') !== false) {
                    $params=$value;
                }
                }
        
       //$var = $page->url;
        $site = urlencode($CFG->wwwroot);
        $enablescreencapture=$this->quizobj->get_quiz()->enablescreencapture;
        $enableevent=$this->quizobj->get_quiz()->enableevent;
        
       
       if(!isset($_COOKIE['es']) && array_key_exists("attempt",$params) ){
        setcookie("siteMoodle",$CFG->wwwroot,time() + 3600,'/');
        setcookie("dirroot",$CFG->dirroot,time() + 3600,'/');
        setcookie("es", "true",time() + 3600,'/');
        global $DB;
        $record = new stdClass();
                        $record->attemptid = $params['attempt'];
                        $face_id=$_COOKIE['face_id'];
                        
                        $record->id = $face_id;
                       
                        $t=time();
                        $record->timemodified= $t;
                        $DB->update_record('quizaccess_mproct_auth', $record);



        $page->requires->js_call_amd("quizaccess_mproctoring/record_control", 'init',array($params, $cm->id,$CFG->wwwroot,$site,$enableevent,$enablescreencapture));
       
       }
       
       if(isset($_COOKIE['es']) && $_COOKIE['es']=='false' && array_key_exists("attempt",$params) ){
        $array = (array) $PAGE->url;
        
        //print_r($CFG->wwwroot);
       // exit();
        foreach ( $array as $key => $value )
             {
                 if (strpos($key, 'path') !== false) {
                    if (strpos($value, 'review.php') !== false) {
                        setcookie("es", "false" ,time() + 3600,'/');
                    }
                    else{
                        global $DB;
                        setcookie("es", "true" ,time() + 3600,'/');
                        setcookie("siteMoodle",$CFG->wwwroot ,time() + 3600,'/');
                        setcookie("dirroot",$CFG->dirroot ,time() + 3600,'/');
                        $record = new stdClass();
                        $record->attemptid = $params['attempt'];
                        $face_id=$_COOKIE['face_id'];
                        
                        $record->id = $face_id;
                       
                        $t=time();
                        $record->timemodified= $t;
                        $DB->update_record('quizaccess_mproct_auth', $record);

                        $page->requires->js_call_amd("quizaccess_mproctoring/record_control", 'init',array($params, $cm->id,$CFG->wwwroot,$site,$enableevent,$enablescreencapture));
                    }
                 }
                 }
      
       
       }

    


        
      
    }


    public function prevent_access() {

        global $DB;
        global $PAGE,$CFG,$USER;
        //print_r($PAGE);
        
        //print_r( $PAGE->url);
        $cm = $PAGE->cm;

      
        $params=[];

        $array = (array) $PAGE->url;
 
        //print_r($CFG->wwwroot);
       // exit();
        foreach ( $array as $key => $value )
             {
                 if (strpos($key, 'params') !== false) {
                     $params=$value;
                 }
                 }
        //print_r($array); 
       // exit();
        $quizData=$DB->get_record('quiz', array('id' => $cm->instance));     
        $CFG->cachejs = false;
        $quizid= $quizData->id;
        setcookie("quizid",$quizid,time() + 3600,'/');
        setcookie("userid",$USER->id,time() + 3600,'/');
        
        $data= $PAGE->requires->js_call_amd("quizaccess_mproctoring/set_cookies", 'init');
        if( is_siteadmin())
        {

        $quizid= $quizData->id;
      
        $rec=$DB->get_records_sql('SELECT userevent.id as id,userevent.attemptid as atmid, user.firstname as firstname ,user.lastname as lastname,user.email as email,userevent.attempt as attempt,
        userevent.eventsecond as eventsecond, userevent.eventpercentage as eventpercentage,userevent.url as url1,userevent.urlfilesize as urlfilesize,AVG(up.matchingpercent) as mp
        FROM mdl_quizaccess_mproct_userevent as userevent Inner JOIN  mdl_user as user ON userevent.userid=user.id left join mdl_quizaccess_mproct_userphoto as up on userevent.attemptid=up.attemptid   where userevent.quizid='.$quizid .' group by up.attemptid'
    );
    setcookie("dirroot",$CFG->dirroot ,time() + 3600,'/');
            $table = new html_table();
        $table->head = array('ID','Firstname','Lastname','Email',"attempt","url","screencapture","eventsecond","screenshot","Matching Average");
        
        foreach ($rec as $records) {
            $id = $records->id;
            $firstname=$records->firstname;
            $lastname=$records->lastname;
            $email=$records->email;
            $attempt=$records->attempt;
           
            $urlfilesize=$records->urlfilesize;
            $urlfaceimg="<button class='btn btn-primary' onclick=viewImg('".$records->atmid."','facepath','".$CFG->wwwroot."')><center><i class='fa fa-eye' aria-hidden='true'></i></center></button>";
            $urlidimg="<button class='btn btn-primary' onclick=viewImg('".$records->atmid."','idpath','".$CFG->wwwroot."')><i class='fa fa-eye' aria-hidden='true'></i></button>";
           


            $sql="SELECT ss.screencapture  as files1  from  mdl_quizaccess_mproct_uservideo as ss where ss.attemptid=". $records->atmid ;
            $checkrec=$DB->record_exists_sql($sql, $params=null);
            $url_audio="";
            
            
            if($checkrec=='1')
            {
                $url_audio="<a class='btn  btn-primary'  href='".$CFG->wwwroot."/mod/quiz/accessrule/mproctoring/api/download_audio.php?atmid=".$records->atmid."' ><i class='fa fa-download' aria-hidden='true'></i> </a> ";
          
            }
          

             
            $scrSht="<a class='btn  btn-primary '  href='".$CFG->wwwroot."/mod/quiz/accessrule/mproctoring/api/zipfileDownload.php?atmid=".$records->atmid."' ><i class='fa fa-download' aria-hidden='true'></i></a> ";
            $facedw="<a class='btn  btn-primary '  href='".$CFG->wwwroot."/mod/quiz/accessrule/mproctoring/api/zipfileDownload_face.php?atmid=".$records->atmid."' ><i class='fa fa-download' aria-hidden='true'></i> </a> ";
            if($urlfilesize=='0'){
            $url="<a class='btn  btn-primary '  href='".$CFG->wwwroot."/mod/quiz/accessrule/mproctoring/download.php?url1=".$CFG->dataroot.$records->url1."' ><i class='fa fa-download' aria-hidden='true'></i></a> ";
            }
            else{
            
                $url="<a class='btn btn-danger' href='".$CFG->wwwroot."/mod/quiz/accessrule/mproctoring/download.php?url1=".$CFG->dataroot.$records->url1."' ><i class='fa fa-download' aria-hidden='true'></i></a> ";
          
            }
            //$screencapture="<a class='btn  btn-primary' href='".$CFG->wwwroot."/mod/quiz/accessrule/mproctoring/download.php?url1=".$records->screencapture."' >Download </a> ";
            $eventsecond=number_format(((float)$records->eventsecond)/60.0, 2, '.', '');
            $eventpercentage=number_format((float)$records->eventpercentage, 2, '.', '')."%";
            $mp=number_format((float)$records->mp, 2, '.', '')."%";

            $table->data[] = array($id,$firstname,$lastname, $email, $attempt, $url,$eventpercentage,$eventsecond,$scrSht,$urlfaceimg,$urlidimg,$mp,$facedw,$url_audio);
        }
        
      
       

        $PAGE->requires->js_call_amd("quizaccess_mproctoring/quizAttemptData", 'init',array($table->data));
      


    }
    
       
    $PAGE->requires->js_call_amd("quizaccess_mproctoring/authCapture", 'init',array($CFG->wwwroot));
    $PAGE->requires->js_call_amd("quizaccess_mproctoring/help", 'init');


    }

    
    public static function add_settings_form_fields(
            mod_quiz_mod_form $quizform, MoodleQuickForm $mform) {

                
        $mform->addElement('header', 'mproctoing',get_string('mproctoring', 'quizaccess_mproctoring'));

        $select=$mform->addElement('select', 'enablemproctoing',get_string('enablemproctoing', 'quizaccess_mproctoring'), array(
            1 => "Enable",
            0 => "Disable",
        ));
        $mform->addHelpButton('enablemproctoing',
                'enablemproctoing', 'quizaccess_mproctoring');
        $select->setSelected('0');
         echo self::$enablemproctoing;
       
                $mform->addElement('checkbox', 'enableevent',get_string('enableevent', 'quizaccess_mproctoring'));
        $mform->addHelpButton('enableevent',
                'enableevent', 'quizaccess_mproctoring');
                $mform->hideIf('enableevent', 'enablemproctoing', 'eq', 0);


                $mform->addElement('checkbox', 'enablescreencapture',get_string('enablescreencapture', 'quizaccess_mproctoring'));
        $mform->addHelpButton('enablescreencapture',
                'enablescreencapture', 'quizaccess_mproctoring');
                $mform->hideIf('enablescreencapture', 'enablemproctoing', 'eq', 0);


               $chk=$mform->addElement('checkbox', 'enableurl',get_string('enableurl', 'quizaccess_mproctoring'));
        $mform->addHelpButton('enableurl',
                'enableurl', 'quizaccess_mproctoring');
                $mform->hideIf('enableurl', 'enablemproctoing', 'eq', 0);

            $chk->setChecked(true);
            $mform->disabledIf('enableurl', 'enablemproctoing');


    }

    public static function save_settings($quiz) {
        global $DB;
        
        $cm = get_coursemodule_from_instance('quiz', $quiz->id, $quiz->course, false, MUST_EXIST);
        $record = new stdClass();
        $record->quizid = $quiz->id;
        $record->cmid = $cm->id;
        $record->enablemproctoing= $quiz->enablemproctoing;
        $array = (array) $quiz;
        //print_r($array);
       
        if(array_key_exists("enableurl",$array)){$record->enableurl= $quiz->enableurl;}else{$record->enableurl=1;}
        if(array_key_exists("enablescreencapture",$array)){$record->enablescreencapture= $quiz->enablescreencapture;}else{$record->enablescreencapture=0;}
        if(array_key_exists("enableevent",$array)){$record->enableevent= $quiz->enableevent;}else{$record->enableevent=0;}
        
       
      
        
            if (!$DB->record_exists('quizaccess_mproct_settings', array('quizid' => $quiz->id))) {
                if(array_key_exists("timecreated",$array)){$record->timecreated= $quiz->timecreated;}
                else{ $t=time(); $record->timecreated= $t;}
               
                $record->timemodified= $quiz->timemodified;
                $DB->insert_record('quizaccess_mproct_settings', $record);
            }else{
               $id= $DB->get_record('quizaccess_mproct_settings', array('quizid' => $quiz->id) , $fields='id', $strictness=IGNORE_MISSING);
               
                $record->timemodified= $quiz->timemodified;
                $record->id=(int)$id->id;
             
               $data= $DB->update_record('quizaccess_mproct_settings', $record);
               

            }
        
    }

    public static function delete_settings($quiz) {
        global $DB;
        $DB->delete_records('quizaccess_mproct_settings', array('quizid' => $quiz->id));
    }

    public static function get_settings_sql($quizid) {
        return array(
            'enablemproctoing,'.'enableurl,'.'enablescreencapture,'.'enableevent',
            'LEFT JOIN {quizaccess_mproct_settings} mproctoring ON mproctoring.quizid = quiz.id',
            array());
    }



    
    public function current_attempt_finished() {
        global $DB,$PAGE;
     
        setcookie("es", "false",time() + 3600,'/');
        setcookie("cf", "true",time() + 3600,'/');
        //$PAGE->requires->js_call_amd("quizaccess_mproctoring/record_control", 'test');
        setcookie("attemptid",$this->attemptidval->id ,time() + 3600,'/');
        setcookie("quizid",$this->attemptidval->quiz ,time() + 3600,'/');
        setcookie("userid", $this->attemptidval->userid,time() + 3600,'/');
        setcookie("attempt",$this->attemptidval->attempt ,time() + 3600,'/');
       
    //    $record = new stdClass();
    //    $record->attemptid = $this->attemptidval->id;
    //    $record->quizid =$this->attemptidval->quiz;
    //    $record->userid=$this->attemptidval->userid;
    //    $record->attempt=$this->attemptidval->attempt;

    //    $record->url="abc";
    //    $record->screencapture="xyz";

    //    $t=time();
    //    $record->timecreated= $t;
    //    $record->timemodified= $t;
    //    $DB->insert_record('quizaccess_mproct_uservideo', $record);
      
    }
    /**
     * Return an appropriately configured instance of this rule, if it is applicable
     * to the given quiz, otherwise return null.
     *
     * @param quiz $quizobj information about the quiz in question.
     * @param int $timenow the time that should be considered as 'now'.
     * @param bool $canignoretimelimits whether the current user is exempt from
     *      time limits by the mod/quiz:ignoretimelimits capability.
     * @return quiz_access_rule_base|null the rule, if applicable, else null.
     */
}
