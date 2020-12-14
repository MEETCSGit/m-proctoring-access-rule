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
 * Strings for the quizaccess_MProctoring plugin.
 *
 * @package    quizaccess_MProctoring
 * @author     MEETCS (admin@meetcs.com)
 *             Atul (atul.adhikari@camplus.co.in)
 *             Rushab (rushab.ambre@camplus.co.in)
 *             Abhishek (abhishek.ambokar@camplus.co.in)
 * @copyright  Meetcs@2020
 */
defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/mod/quiz/accessrule/accessrulebase.php');
class quizaccess_mproctoring extends quiz_access_rule_base {
    private static $enablemproctoing;
    private static $enableevent;
    private static $enablescreencapture;
    private static $enableurl;
    public $attemptidval;
    public $quizid;
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
    public function is_preflight_check_required($attemptid) {
        return empty($attemptid);
    }
    public function notify_preflight_check_passed($attemptid) {

    }
    public function add_preflight_check_form_fields(mod_quiz_preflight_check_form $quizform, MoodleQuickForm $mform, $attemptid) {
        $mform->addElement(
            'header',
            'mproctoingcheckheader',
             get_string('mproctoingcheckheader', 'quizaccess_mproctoring')
        );
        $mform->addElement(
            'static',
            'mproctoingcheckstatement',
            '',
            get_string('mproctoingcheckstatement', 'quizaccess_mproctoring')
        );
        $mform->addElement(
            'checkbox',
            'mproctoingcheck',
            '',
            get_string('mproctoingchecklabel', 'quizaccess_mproctoring')
        );
    }
    public function validate_preflight_check($data, $files, $errors, $attemptid) {
        $dat = $_COOKIE["bd"];
        $ext1 = $_COOKIE["ext"];
        if ($dat != "true") {
            $errors['quizbrowser'] = get_string('browsererror', 'quizaccess_mproctoring');
        }
        if ($ext1 != "true") {
            $errors['quizbrowser'] = get_string('browsererror', 'quizaccess_mproctoring');
        }
        if (empty($data['mproctoingcheck'])) {
            $errors['mproctoingcheck'] = get_string('youmustagree', 'quizaccess_mproctoring');
        }
        global $PAGE, $CFG;
        $CFG->cachejs = false;
        return $errors;
    }
    public function end_time($attempt) {
        $this->attemptidval = $attempt;
        return false;
    }
    public static function make(quiz $quizobj, $timenow, $canignoretimelimits) {
        if (empty($quizobj->get_quiz()->enablemproctoing)) {
            return null;
        }
        return new self($quizobj, $timenow);
    }
    public function setup_attempt_page($page) {
        global $PAGE, $CFG;
        $page->set_popup_notification_allowed(false);
        $page->set_title($this->quizobj->get_course()->shortname . ': ' . $page->title);
        $page->set_cacheable(false);
        $page->set_pagelayout('secure');
        if ($this->quizobj->is_preview_user()) {
            return;
        }
        $page->add_body_class('quiz-secure-window');
        $page->requires->js_init_call(
            'M.mod_quiz.secure_window.init',
            null,
            false,
            quiz_get_js_module()
        );
        $cm = $PAGE->cm;
        $params = [];
        $array = (array) $PAGE->url;
        foreach ($array as $key => $value) {
            if (strpos($key, 'params') !== false) {
                $params = $value;
            }
        }
        $site = urlencode($CFG->wwwroot);
        $enablescreencapture = $this->quizobj->get_quiz()->enablescreencapture;
        $enableevent = $this->quizobj->get_quiz()->enableevent;
        if (!isset($_COOKIE['es']) && array_key_exists("attempt", $params)) {
            setcookie("siteMoodle", $CFG->wwwroot, time() + 3600, '/');
            setcookie("dirroot", $CFG->dirroot, time() + 3600, '/');
            setcookie("es", "true", time() + 3600, '/');
            $page->requires->js_call_amd("quizaccess_mproctoring/record_control", 'init', array($params, $cm->id, $CFG->wwwroot, $site, $enableevent, $enablescreencapture));
        }
        if (isset($_COOKIE['es']) && $_COOKIE['es'] == 'false' && array_key_exists("attempt", $params)) {
            $array = (array) $PAGE->url;
            foreach ($array as $key => $value) {
                if (strpos($key, 'path') !== false) {
                    if (strpos($value, 'review.php') !== false) {
                        setcookie("es", "false", time() + 3600, '/');
                    } else {
                        setcookie("es", "true", time() + 3600, '/');
                        setcookie("siteMoodle", $CFG->wwwroot, time() + 3600, '/');
                        setcookie("dirroot", $CFG->dirroot, time() + 3600, '/');
                        $rc = "quizaccess_mproctoring/record_control";
                        $page->requires->js_call_amd($rc , 'init', array($params, $cm->id, $CFG->wwwroot, $site, $enableevent, $enablescreencapture));
                    }
                }
            }
        }
    }
    public function prevent_access() {
        global $DB;
        global $PAGE, $CFG, $USER;
        $cm = $PAGE->cm;
        $quizdata = $DB->get_record('quiz', array('id' => $cm->instance));
        $CFG->cachejs = false;
        $data = $PAGE->requires->js_call_amd("quizaccess_mproctoring/set_cookies", 'init');
        if (is_siteadmin()) {
            $quizid = $quizdata->id;
            $u = 'mdl_user';
            $ue = 'mdl_quizaccess_mproctoring_ueve';
            $sql = 'SELECT ue.id, u.*,ue.attempt,ue.eventsecond,ue.url url1,ue.urlfilesize FROM '.$ue.' ue JOIN '.$u.' u ON ue.userid=u.id where ue.quizid='.$quizid;
            $rec = $DB->get_records_sql($sql);
            $table = new html_table();
            $table->head = array('ID', 'Firstname', 'Lastname', 'Email', "attempt", "url", "screencapture", "eventsecond");
            foreach ($rec as $records) {
                $id = $records->id;
                $firstname = $records->firstname;
                $lastname = $records->lastname;
                $email = $records->email;
                $attempt = $records->attempt;
                $urlfilesize = $records->urlfilesize;
                if ($urlfilesize == '0') {
                    $url = "<a class='btn  btn-primary '  href='" . $CFG->wwwroot . "/mod/quiz/accessrule/mproctoring/download.php?url1=" . $records->url1 . "' >Download </a> ";
                } else {
                    $url = "<a class='btn btn-danger' href='" . $CFG->wwwroot . "/mod/quiz/accessrule/mproctoring/download.php?url1=" . $records->url1 . "' >Download </a> ";
                }
                $eventsecond = number_format((float)$records->eventsecond, 2, '.', '') . "%";
                $table->data[] = array($id, $firstname, $lastname, $email, $attempt, $url, $eventsecond);
            }
            $PAGE->requires->js_call_amd("quizaccess_mproctoring/quizAttemptData", 'init', array($table->data));
        }
        $PAGE->requires->js_call_amd("quizaccess_mproctoring/help", 'init');
    }
    public static function add_settings_form_fields (mod_quiz_mod_form $quizform, MoodleQuickForm $mform ) {
        $mform->addElement('header', 'mproctoing', get_string('mproctoring', 'quizaccess_mproctoring'));
        $select = $mform->addElement('select', 'enablemproctoing', get_string('enablemproctoing', 'quizaccess_mproctoring'), array(
            1 => "Enable",
            0 => "Disable",
        ));
        $mform->addHelpButton(
            'enablemproctoing',
            'enablemproctoing',
            'quizaccess_mproctoring'
        );
        $select->setSelected('0');
        echo self::$enablemproctoing;
        $mform->addElement('checkbox', 'enableevent', get_string('enableevent', 'quizaccess_mproctoring'));
        $mform->addHelpButton(
            'enableevent',
            'enableevent',
            'quizaccess_mproctoring'
        );
        $mform->hideIf('enableevent', 'enablemproctoing', 'eq', 0);
        $mform->addElement('checkbox', 'enablescreencapture', get_string('enablescreencapture', 'quizaccess_mproctoring'));
        $mform->addHelpButton(
            'enablescreencapture',
            'enablescreencapture',
            'quizaccess_mproctoring'
        );
        $mform->hideIf('enablescreencapture', 'enablemproctoing', 'eq', 0);
        $chk = $mform->addElement('checkbox', 'enableurl', get_string('enableurl', 'quizaccess_mproctoring'));
        $mform->addHelpButton(
            'enableurl',
            'enableurl',
            'quizaccess_mproctoring'
        );
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
        $record->enablemproctoing = $quiz->enablemproctoing;
        $array = (array) $quiz;
        if (array_key_exists("enableurl", $array)) {
            $record->enableurl = $quiz->enableurl;
        } else {
            $record->enableurl = 1;
        }
        if (array_key_exists("enablescreencapture", $array)) {
            $record->enablescreencapture = $quiz->enablescreencapture;
        } else {
            $record->enablescreencapture = 0;
        }
        if (array_key_exists("enableevent", $array)) {
            $record->enableevent = $quiz->enableevent;
        } else {
            $record->enableevent = 0;
        }
        if (!$DB->record_exists('quizaccess_mproctoring_sett', array('quizid' => $quiz->id))) {
            if (array_key_exists("timecreated", $array)) {
                $record->timecreated = $quiz->timecreated;
            } else {
                $t = time();
                $record->timecreated = $t;
            }
            $record->timemodified = $quiz->timemodified;
            $DB->insert_record('quizaccess_mproctoring_sett', $record);
        } else {
            $id = $DB->get_record('quizaccess_mproctoring_sett', array('quizid' => $quiz->id), $fields = 'id', $strictness = IGNORE_MISSING);
            $record->timemodified = $quiz->timemodified;
            $record->id = (int)$id->id;
            $data = $DB->update_record('quizaccess_mproctoring_sett', $record);
        }
    }
    public static function delete_settings($quiz) {
        global $DB;
        $DB->delete_records('quizaccess_mproctoring_sett', array('quizid' => $quiz->id));
    }
    public static function get_settings_sql($quizid) {
        return array(
            'enablemproctoing,' . 'enableurl,' . 'enablescreencapture,' . 'enableevent',
            'LEFT JOIN {quizaccess_mproctoring_sett} mproctoring ON mproctoring.quizid = quiz.id',
            array()
        );
    }
    public function current_attempt_finished() {
        global $DB, $PAGE;
        setcookie("es", "false", time() + 3600, '/');
        setcookie("cf", "true", time() + 3600, '/');
        setcookie("attemptid", $this->attemptidval->id, time() + 3600, '/');
        setcookie("quizid", $this->attemptidval->quiz, time() + 3600, '/');
        setcookie("userid", $this->attemptidval->userid, time() + 3600, '/');
        setcookie("attempt", $this->attemptidval->attempt, time() + 3600, '/');
    }
}