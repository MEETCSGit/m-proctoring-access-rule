<?php

require($_COOKIE['dirroot'].'/config.php');

$attempt = $_REQUEST['attempt'];
$cmid = $_REQUEST['cmid'];
$id = $_REQUEST['id'];
$site = $_REQUEST['site'];
$eventcap = $_REQUEST['eventcap'];
$sc = $_REQUEST['sc'];
$url = urldecode($site);
$quiz=$_COOKIE['quizid'];

setcookie("attemptid", $attempt,time() + 3600,'/');

$rec=$DB->get_record('quiz',[ 'id'=>$quiz ], $fields='timelimit', $strictness=IGNORE_MISSING);
$qtime=$rec->timelimit;

?>

<!-- Script -->
<script type="text/javascript" src="<?php echo $url ?>/mod/quiz/accessrule/mproctoring/amd/src/webcam.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>



<iframe frameBorder="0" id='popOutiFrame' src='<?php echo $url ?>/mod/quiz/attempt.php?attempt=<?php echo $attempt ?>&cmid=<?php echo $cmid ?>' style='width:100%;height:100%'> </iframe>
<div style="display: none;"><video id="video" autoplay></video></canvas></div>
<!-- <center> <button class="btn btn-primary" id='stop-screen'>Submit Exam</button>  </center> -->
<div id="my_camera" style = "display : none"></div>
<div id="results" style = "display : none"></div>

<script language="JavaScript">

eventData=[];
totalsec=0;
var timer;

    function getRandomInt(min,max) {
        return Math.floor((Math.random() * (max - min) + min) * 1000) ;
        // return Math.floor(Math.random() * Math.floor(max) * 1000);
    }

    var random_time_arr = Array();

    
    var examtime = <?php if($qtime){
                    echo $qtime;
                    } 
                    else{
                        echo "10800";
                    }?>;

    // console.log(examtime);
    
    // first random time is between 10 to 30 second
    var first_random=getRandomInt(10,30);
    console.log(first_random);
    random_time_arr.push(first_random);

    // next 4 random time between 30 to exam time duration.
    for(let i = 0; i < 4; i++){
        random_time_arr.push(getRandomInt(30,examtime));
    }
    console.log(random_time_arr);

    random_time_arr.sort(function(a, b){return a-b});
    var time_index = 0;

    console.log(random_time_arr);

    $( document ).ready(function() {

        Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90
        });
        Webcam.attach( '#my_camera' );
        
        setTimeout(saveSnap, random_time_arr[0]);

    });

    function saveSnap(){
        console.log('save snap called');
        // take snapshot and get image data
        Webcam.snap( function(data_uri) {
            // display results in page
            document.getElementById('results').innerHTML = 
                '<img id="imageprev" src="'+data_uri+'"/>';
        });

        // Get base64 value from <img id='imageprev'> source
        var base64image = document.getElementById("imageprev").src;
    
        Webcam.upload( base64image, '<?php echo $url ?>/mod/quiz/accessrule/mproctoring/api/apiStorePicture.php', function(code, text) {
            
            if(code == 200){
                var response = JSON.parse(text);

                if(typeof(response['face_count']) != 'undefined' & response['face_count'] > 1){
                    alert("WARNING: Multiple faces detected");
                }
                else if(typeof(response['face_count']) != 'undefined' & response['face_count']  == 0){
                    alert("WARNING: No user detected. Click Ok to continue");
                }
                else if(typeof(response['matchingpercent']) != 'undefined' & response['matchingpercent'] < 50 ){
                    alert("WARNING: Face mis-match detected ");
                }
            }   
        });
        
        if(time_index < random_time_arr.length - 1){
            time_index += 1;
            console.log('current value',random_time_arr[time_index]);
            console.log('next value',random_time_arr[time_index -1]);

            timeout = random_time_arr[time_index] - random_time_arr[time_index -1];

            console.log("next time out ", timeout);
            
            setTimeout(saveSnap, timeout);
        }
    }

var displayMediaOptions = {
  video: {
    cursor: "always"
  },
  audio: false
};
const videoElem = document.getElementById("video");
function dumpOptionsInfo() {
  const videoTrack = videoElem.srcObject.getVideoTracks()[0];
 
  console.info("Track settings:");
  console.info(JSON.stringify(videoTrack.getSettings(), null, 2));
  console.info("Track constraints:");
  console.info(JSON.stringify(videoTrack.getConstraints(), null, 2));
}


function stopCapture(evt) {
  let tracks = videoElem.srcObject.getTracks();

  tracks.forEach(track => track.stop());
  videoElem.srcObject = null;
}


async function startCapture() {
 

  try {
    videoElem.srcObject = await navigator.mediaDevices.getDisplayMedia(displayMediaOptions);
    dumpOptionsInfo();
  } catch(err) {
    console.error("Error: " + err);
  }
}

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }



    async function get_stream()
{
    return await navigator.mediaDevices.getDisplayMedia({
        video: { mediaSource: 'screen' },
      });
}

    function getCookie(name) {
        // Split cookie string and get all individual name=value pairs in an array
        var cookieArr = document.cookie.split(";");

        // Loop through the array elements
        for (var i = 0; i < cookieArr.length; i++) {
            var cookiePair = cookieArr[i].split("=");

            /* Removing whitespace at the beginning of the cookie name
            and compare it with the given string */
            if (name == cookiePair[0].trim()) {
                // Decode the cookie value and return
                return decodeURIComponent(cookiePair[1]);
            }
        }

        // Return null if not found
        return null;
    }





    $('#popOutiFrame').on('load', function() {

        cf = getCookie('cf');

        if (cf == 'true') {

            if (eventcap=="1"){
            recorder.eventTrackingSend(totalsec);
            }
            if (sc=="1")
            {
            recorder.stopRecording(function(blob) {

                setCookie("es", "false", 1);

                setCookie("cf", "false", 1);
                setCookie("userAuth", "false", 1);
              
                // uploadToPHPServer(fileObject, function(progress, videoURL) {});
            });
             }
             setCookie("es", "false", 1);
            setCookie("cf", "false", 1);
            setCookie("userAuth", "false", 1);
        window.location.href = "<?php echo $url ?>/mod/quiz/view.php?id=<?php echo $id ?>";
        }
    });


    setCookie("startTime", (new Date).getTime(), 1);
    setCookie("examstartTime",  Date.now(), 1);
    var eventcap = <?php echo $eventcap ?>;
    var sc = <?php echo $sc ?>;

    var recorder = new RecordRTC_Extension();

    var imageCapture;
var track;
// const canIRun  = navigator.mediaDevices.getDisplayMedia;
//  navigator.mediaDevices.getDisplayMedia({
//     video: true

//       }).then(mediaStream => {
   

//     track = mediaStream.getVideoTracks()[0];
   
//   });
       
startCapture();
  let stream="";
let setStream="0"
      const takeScreenShot = async () => {

var canvas = document.createElement('canvas');

    var ctx = canvas.getContext('2d');
    var video = document.getElementById("video");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    var img_data = canvas.toDataURL('image/jpg');
    // var filename = file.name;
    // var filename = filename.split('.').slice(0, -1).join('.');

    $.ajax({
  method: "POST",
  url: '<?php echo $url ?>/mod/quiz/accessrule/mproctoring/api/screenshot.php',
  data: {imgdata: img_data }
});




}     

if (sc=="1")
{
    recorder.startRecording({
        enableMicrophone: true
    });
}

 
    $("#stop-screen").click(function() {

        recorder.stopRecording(function(blob) {
            console.log(blob);
            setCookie("es", "false", 1);

            setCookie("cf", "false", 1);
            
            //window.location.href = "http://localhost:8030/moodle_site/mod/quiz/view.php?id=<?php echo $id ?>";
            // uploadToPHPServer(fileObject, function(progress, videoURL) {});
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
    setInterval(function checkFocus(){
    if( checkFocus.prev == document.hasFocus() ) return;  
    if(document.hasFocus()) onFocus();
    else onBlur();                    
    checkFocus.prev = document.hasFocus();  
},100);
d=new  Date();
        function onFocus(){
      
            clearInterval(timer);
            console.log("focus")
eventData.push('activated|'+ Date.now());
if (eventData.length > 2)
{

    if(eventData[eventData.length-1].includes("activated") && eventData[eventData.length-2].includes("deactivated") )
          {
            
            act=eventData[eventData.length-1].split("|")
            deact=eventData[eventData.length-2].split("|")
            lostfocustime=parseInt(act[1])-parseInt(deact[1]);
            
            sec = lostfocustime / 1000.0;
            if (sec >= 10){
                totalsec=totalsec+sec
                eventData.pop()
                eventData.pop()
                console.log(totalsec)
            }else{
                eventData.pop()
                eventData.pop()
            }
          }
}


    }

function onBlur(){ 
 
        timer= setInterval(takeScreenShot, 7000);
      console.log("blur")
        eventData.push('deactivated|'+ Date.now());
   }

</script>