define(['jquery'], function($) {
    return {
        /**
         * Init function.
         *
         */

        init: function() {
           
            $('.quizinfo').append(
                $('</br>'),
                $('<div/>', {
                    'class' : "container" ,
                    'width':"100%",
                   
                })).append(`<div class="card border-primary mb-3" >
                <div  class="card-header bg-primary text-white" ><h3>INSTRUCTIONS</h3></div>
                  <div class="card-body text-primary ">
   <ol class="text-left" >
   <li>
    For downloading Extenstion <a style="border-radius:30px" class='btn btn-primary' href='https://chrome.google.com/webstore/search/meetcs%20mega%20proctoring'>   Click Here </a> 
    </li>   
    <li>
    Use chrome browser only. If you do not have Chrome Browser, click here to download the same <a style="border-radius:30px" class='btn btn-primary' href='https://www.google.com/chrome/?brand=CHBD&gclid=Cj0KCQjw7ZL6BRCmARIsAH6XFDKX7KthILVZaAuxvOQSp38GUmDbcF9wZuI9wpIaE1X5Q7SL4SwrVmgaAmYNEALw_wcB&gclsrc=aw.ds'>   Click Here </a> 
    </li> 
    <li> The system will prompt you to install the extension. Please accept it. The system will take you through the rest of the steps automatically. </li>
    <li> Go to your Chrome Brwoser and emable to "MEGA PROCTORING" Extension.
    </li>
     <li> After enabling the extension, refresh the quiz page, "Attempt Examination" page will appear now.</li>
     <li> Your exam is being proctored, your screen, audio and pictures would be captured. We advise you not use any unfair means.</li>
     </ol>
     <b>YOU ARE ALL SET AND ALL THE BEST!! </b>
     </div>
  </div>
</div>
                
                
                
                
                `);
            }
        };
    });