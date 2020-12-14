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
define(['jquery'] , function($) {
    return {
        init : function() {
            $('.quizinfo').append(
                $('</br>') ,
                $('<div/>', {
                    'class' : "container" ,
                    'width':"100%",
                })).append(` <div class = "card border-primary mb-3" >
                 <div class = "card-header bg-primary text-white" > <h3> INSTRUCTIONS </h3> </div>
                  <div class = "card-body text-primary ">
   <ol class = "text-left" >
   <li>
    To download the MEGA PROCTORING Extension <b><a target='_blank' style = "border-radius : 30px" href = 'https://chrome.google.com/webstore/search/meetcs%20mega%20proctoring'>   Click Here </a> </b>
    </li>   
    <li>
    Use CHROME BROWSER Only. To download the same <b><a style = "border-radius:30px" href = 'https://www.google.com/chrome/?brand=CHBD&gclid=Cj0KCQjw7ZL6BRCmARIsAH6XFDKX7KthILVZaAuxvOQSp38GUmDbcF9wZuI9wpIaE1X5Q7SL4SwrVmgaAmYNEALw_wcB&gclsrc=aw.ds' target='_blank'>   Click Here </a> </b>
    </li> 
    <li>The system will prompt for installing an extension, kindly Accept it and it will take care of the rest. </li>
    <li> To enable it, Click on Extension in your Chrome Browser and Enable the MEGA PROCTORING Extension.<br><b>Once you are done with above configuration just refresh
    page Exam button will Appear</b></li>
    <li>Your exam is being proctored and hence some of your activities are getting tracked.Data gathered through the proctoring activities might be used towards further analyses/investigation by the respective institution.</li>
    <li>MEETCS shall not be responsible for the actions taken by the participant nor the institution.</li>
    </ol>
    <b>YOU ARE ALL SET AND ALL THE BEST!! </b>
    </div>
  </div>
</div> `
        );
            }
        };
    });