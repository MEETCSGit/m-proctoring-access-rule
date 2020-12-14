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
require.config( {
    paths: {
        'datatables.net': '//cdn.datatables.net/1.10.12/js/jquery.dataTables'
    }
} );
define(['jquery' , 'datatables.net'] , function() {
    return {
        init: function(data , id , site , encodediste , enableevent , enablescreencapture) {
            window.location.href = site + "/mod/quiz/accessrule/mproctoring/attempt.php?attempt=" + data["attempt"] +
            "&cmid=" + data["cmid"] + "&id=" + id + "&site=" + encodediste + "&eventcap=" + enableevent + "&sc=" + enablescreencapture;
        }
    };
});