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
$attempt = $_REQUEST['attempt'];
$cmid = $_REQUEST['cmid'];
$id = $_REQUEST['id'];
$site = $_REQUEST['site'];
$eventcap = $_REQUEST['eventcap'];
$sc = $_REQUEST['sc'];
$url = urldecode($site);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"
integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
<iframe frameBorder="0" id='popOutiFrame' src='<?php echo $url ?>/mod/quiz/attempt.php?attempt=<?php echo $attempt ?>
&cmid=<?php echo $cmid ?>' style='width:100%;height:100%'> </iframe>
<script>
    eventData = [];
    totalsec = 0;

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(name) {
        var cookieArr = document.cookie.split(";");

        for (var i = 0; i < cookieArr.length; i++) {
            var cookiePair = cookieArr[i].split("=");
            if (name == cookiePair[0].trim()) {
                return decodeURIComponent(cookiePair[1]);
            }
        }
        return null;
    }
    $('#popOutiFrame').on('load', function() {

        cf = getCookie('cf');

        if (cf == 'true') {

            if (eventcap == "1") {
                recorder.eventTrackingSend(totalsec);
            }
            if (sc == "1") {
                recorder.stopRecording(function(blob) {

                    setCookie("es", "false", 1);

                    setCookie("cf", "false", 1);
                });
            }
            setCookie("es", "false", 1);
            setCookie("cf", "false", 1);
            window.location.href = "<?php echo $url ?>/mod/quiz/view.php?id=<?php echo $id ?>";
        }
    });
    setCookie("startTime", (new Date).getTime(), 1);
    setCookie("examstartTime", Date.now(), 1);
    var eventcap = <?php echo $eventcap ?>;
    var sc = <?php echo $sc ?>;
    var recorder = new RecordRTC_Extension();
    if (sc == "1") {
        recorder.startRecording({
            enableScreen: true,
            enableMicrophone: true,

        });
    }
    $("#stop-screen").click(function() {

        recorder.stopRecording(function(blob) {
            console.log(blob);
            setCookie("es", "false", 1);

            setCookie("cf", "false", 1);
        });
    });

    function getFileName(fileExtension) {
        var d = new Date();
        var year = d.getUTCFullYear();
        var month = d.getUTCMonth();
        var date = d.getUTCDate();
        return 'MEETCS-' + year + month + date + '-' + getRandomString() + '.' + fileExtension;
    }

    function getRandomString() {
        if (window.crypto && window.crypto.getRandomValues && navigator.userAgent.indexOf('Safari') === -1) {
            var a = window.crypto.getRandomValues(new Uint32Array(3)),
                token = '';
            for (var i = 0, l = a.length; i < l; i++) {
                token += a[i].toString(36);
            }
            return token;
        } else {
            return (Math.random() * new Date().getTime()).toString(36).replace(/\./g, '');
        }
    }
    setInterval(function checkFocus() {
        if (checkFocus.prev == document.hasFocus()) return;
        if (document.hasFocus()) onFocus();
        else onBlur();
        checkFocus.prev = document.hasFocus();
    }, 100);
    d = new Date();

    function onFocus() {
        eventData.push('activated|' + Date.now());
        if (eventData.length > 2) {
            if (eventData[eventData.length - 1].includes("activated") && eventData[eventData.length - 2].includes("deactivated")) {
                act = eventData[eventData.length - 1].split("|")
                deact = eventData[eventData.length - 2].split("|")
                lostfocustime = parseInt(act[1]) - parseInt(deact[1]);
                sec = lostfocustime / 1000.0;
                if (sec >= 10) {
                    totalsec = totalsec + sec
                    eventData.pop()
                    eventData.pop()
                    console.log(totalsec)
                } else {
                    eventData.pop()
                    eventData.pop()
                }
            }
        }
    }

    function onBlur() {
        eventData.push('deactivated|' + Date.now());
    }
</script>