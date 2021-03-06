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
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
define(["jquery"], function ($) {
    return {
        init: function () {
            var isChrome = !!window.chrome && (!!window.chrome.webstore || !!window.chrome.runtime);
            setCookie("bd", isChrome, 3);
            if (isChrome) {
                $('.quizattempt').show();
            }
            else{
                alert("Plzz use chrome");
                $('.quizattempt').hide();
            }
            if (typeof RecordRTC_Extension != "undefined") {
                $('.quizattempt').show();
                var isenable = "true";
                setCookie("ext", isenable, 3);
            } else {
                alert("Extension is not installed or enable.");
                $('.quizattempt').hide();
                var isenable = "false";
                setCookie("ext", isenable, 3);
            }
        },
    };
});
