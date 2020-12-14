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
require($_COOKIE['dirroot'].'/config.php');
$t1 = 'MEETCS-';
$id = $_COOKIE['attemptid'];
$quiz = $_COOKIE['quizid'];
$userid = $_COOKIE['userid'];
$attempt = $_COOKIE['attempt'];
$moodledata = $CFG->dataroot;
$u = $_POST['username'];
if (!file_exists($moodledata.'/m_proctoring_uploads/url')) {
    mkdir($moodledata.'/m_proctoring_uploads/url' , 0777 , true);
}
$filepathurl = $moodledata.'/m_proctoring_uploads/url/'.$id.'-'.$t1 ."-url.txt";
$myfile = fopen($filepathurl , "w") or die("Unable to open file!");
$val = $_POST["students"];
fwrite($myfile , str_replace("," , "\n" , $val));
fclose($myfile);
$urlfilesize = filesize($filepathurl);$_POST['video-filename'];
$eventsecond = $_POST['eventSecond'];
$starttime = $_POST['startTime'];
$endtime = $_POST['endTime'];
$record = new stdClass();
$record->attemptid = $id;
$record->quizid = $quiz;
$record->userid = $userid;
$record->attempt = $attempt;
$record->urlfilesize = $urlfilesize;
$record->url = $filepathurl;
$record->eventsecond = $eventsecond;
$t = time();
$record->timecreated = $t;
$record->timemodified = $t;
$rec = $DB->get_record('quiz' , ['id' => $quiz ] , $fields = 'timelimit' , $strictness = IGNORE_MISSING);
$qtime = $rec->timelimit;
$totalsecper = 0;
if ($qtime != '0') {
    $totalsec = floatval ($qtime);
    $totalsecper = floatval((floatval($eventsecond) / $totalsec) * 100);
} else {
    $totalmil = $endtime - $starttime;
    $totalsec = $totalmil / 1000;
    $totalsecper = (floatval($eventsecond) / floatval($totalsec)) * 100.0;
}
$record->eventsecond = strval($totalsecper);
$DB->insert_record('quizaccess_mproctoring_ueve' , $record);
echo $totalsecper."-".$totalsec."-".$eventsecond;