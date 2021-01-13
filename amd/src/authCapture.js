
require.config( {
  paths: {
      'datatables.net': '//cdn.datatables.net/1.10.21/js/jquery.dataTables.min',
    
      
  }
} );
function loadCss(url) {
  var link = document.createElement("link");
  link.type = "text/css";
  link.rel = "stylesheet";
  link.href = url;
  document.getElementsByTagName("head")[0].appendChild(link);
}
define(['jquery'], function($) {
  return {
      /**
       * Init function.
       *
       */ 

      init: function(url) 
          {
              var streams;
              var validDataface;
              var validDataid;
              var s2=false;
              var s3=false;
              

              loadCss("accessrule/mproctoring/cam.css");
                  $("body").append('<div class="modal fade" id="myModal" role="dialog"><div class="modal-dialog modal-lg"> <div class="modal-content"><div class="modal-header"> '+
                  ' <h2><b><center>Validate Yourself</center></b></h2>          </div>              <div class="modal-body">  '+
                  '<center> <h3> Face Capture</h3></center><h4 style="color:red;"><b>Instructions: </b></h4><br><h6 style="color:red;">1. There is no backgorund image When capturing face. </h6><h6 style="color:red;">2. More than one person for capture face authentication fails.   </h6> <br><div class="row">    <div class="col-6">      '
                  +' <div class="camera"><center>  <label><h3> Step 1 </h3></label> </center><video id="video">Video stream not available.</video> <button id="startbutton">Take photo</button> </div></div><div class="col-6">'
                 +'<canvas id="canvas"></canvas><div class="output"><center> <label><h3> Step 2 </h3></label></center><img id="photo" alt="The screen capture will appear in this box.">  <button id="validCap">validate</button>   </div>   </div> </div>  '
                 +'  <center><h3>Identity Card Capture</h3></center><h4 style="color:red;"><b>Instructions: </b></h4><br><h6 style="color:red;">Please bring ID card on front on camera</h6> <br><div class="row">    <div class="col-6">      '
                 +'   <div class="camera"><center> <label><h3> Step 3 </h3></label></center>  <video id="videopan">Video stream not available.</video> <button id="startpan">Take photo</button> </div></div>'
                 +'<div class="col-6"><canvas id="canvaspan"></canvas><div class="output"> <center> <label><h3> Step 4 </h3></label></center><img id="photopan" alt="The screen capture will appear in this box.">  '
                 +'</div>   </div>         </div>              <div class="modal-footer">      '
                 +'<span style="color:red;"> Confirm button will not be enabled till all the 4 steps are done.  </span>  <button type="button" class="btn btn-success" id="camConfirm">Confirm</button>     '
                 +'  <button type="button" class="btn btn-default" id="camClose" data-dismiss="modal">Close</button></div></div></div></div>');
                 $('</br>')
                  $('.quizattempt').prepend(
                    
                  $('<button/>', {
                      'id':"btnCap" ,
                      'class' : "btn btn-secondary" 
                  }),$('</br>'),$('</br>'));

                
                  //$('#btnCap').append('<br/>');
                  $('#btnCap').text(" Step 1 : Authenticate Yourself")
                  $('#btnCap').click(function(){
                  $("#myModal").modal("show")
                  startup();
                  })

                  $('#camClose').click(function(){
                      streams.getTracks().forEach(function(track) {
                          track.stop();
                        });
                      })
                  



                      
                      $('#camConfirm').click(function(){
                        
                        $.ajax({
                            method: "POST",
                            url: url+'/mod/quiz/accessrule/mproctoring/api/capture_id_face.php',
                            data: {imgdataface: validDataface ,imgdataid:validDataid},
                            success:function(data){
                              if(data=="done")
                              {
                                alert("Authentication successful. Click on Attempt quiz to proceed");
                                window.location.reload();
                              }
                              else{
                                alert("Error in Authentication");
                              }
                            }
                          });
                          
                                                })

                     

                    
                      
        $('#validCap').click(function(){
          
                         $("#validCap").html("please wait...")
          $("#validCap").css("background-color","red");
  $.ajax({
      method: "POST",
      url: url+'/mod/quiz/accessrule/mproctoring/api/face_count.php',
      data: {imgdata: validDataface },
      success:function(data){
        if(data=='1')
        {
          s2=true;
          alert("Face Validation Successful")
          $("#validCap").html("&#10004;validated")
          $("#validCap").css("background-color","green");

          if (s2 && s3)
          {
            $('#camConfirm').prop("disabled", false); 
          }
         
        }
        else
        {
          alert("Face could not be detected.<br>Multiple faces detected. Only one person is allowed. Kindly re-take.");
          $("#validCap").html("validate")
          $("#validCap").css("background-color","orange");
        }
      }
    });
    
                          })

                  var width = 320;    // We will scale the photo width to this
                  var height = 0;     // This will be computed based on the input stream
                
                  // |streaming| indicates whether or not we're currently streaming
                  // video from the camera. Obviously, we start at false.
                
                  var streaming = false;
                
                  // The various HTML elements we need to configure or control. These
                  // will be set by the startup() function.
                
                  var video = null;
                  var canvas = null;
                  var photo = null;
                  var startbutton = null;
                  var videopan = null;
                  var canvaspan = null;
                  var photopan = null;
                  var startpan = null;
                
                  function startup() {
                    video = document.getElementById('video');
                    canvas = document.getElementById('canvas');
                    photo = document.getElementById('photo');
                    startbutton = document.getElementById('startbutton');

                    videopan = document.getElementById('videopan');
                    canvaspan = document.getElementById('canvaspan');
                    photopan = document.getElementById('photopan');
                    startpan = document.getElementById('startpan');
                    navigator.mediaDevices.getUserMedia({video: true, audio: false})
                    .then(function(stream) {
                      streams=stream;
                      video.srcObject = stream;
                      video.play();
                      videopan.srcObject = stream;
                      videopan.play();
                    })
                    .catch(function(err) {
                      console.log("An error occurred: " + err);
                    });
                
                    video.addEventListener('canplay', function(ev){
                      if (!streaming) {
                        height = video.videoHeight / (video.videoWidth/width);
                      
                        // Firefox currently has a bug where the height can't be read from
                        // the video, so we will make assumptions if this happens.
                      
                        if (isNaN(height)) {
                          height = width / (4/3);
                        }
                      
                        video.setAttribute('width', width);
                        video.setAttribute('height', height);
                        canvas.setAttribute('width', width);
                        canvas.setAttribute('height', height);
                        streaming = true;
                      }
                    }, false);

                    videopan.addEventListener('canplay', function(ev){
                      if (!streaming) {
                        height = videopan.videoHeight / (videopan.videoWidth/width);
                      
                        // Firefox currently has a bug where the height can't be read from
                        // the video, so we will make assumptions if this happens.
                      
                        if (isNaN(height)) {
                          height = width / (4/3);
                        }
                      
                        videopan.setAttribute('width', width);
                        videopan.setAttribute('height', height);
                        canvaspan.setAttribute('width', width);
                        canvaspan.setAttribute('height', height);
                        streaming = true;
                      }
                    }, false);
                
                    $("#camConfirm").prop("disabled",true); 
                    $("#validCap").prop("disabled",true);

                    startbutton.addEventListener('click', function(ev){
                      $("#validCap").prop("disabled",false);
                      $("#startbutton").text("Retake Photo");   
                        
                      takepicture();
                      ev.preventDefault();
                    }, false);


                    startpan.addEventListener('click', function(ev){
                      
                      s3=true;
                      takepicturepan();
                      if (s2 && s3)
                      {
                        $('#camConfirm').prop("disabled", false); 
                      }
                      ev.preventDefault();
                    }, false);
                    
                    clearphoto();
                    clearphotopan();
                  }
                
                  // Fill the photo with an indication that none has been
                  // captured.
                
                  function clearphoto() {
                      var context = canvas.getContext('2d');
                      context.fillStyle = "#AAA";
                      context.fillRect(0, 0, canvas.width, canvas.height);
                  
                      var data = canvas.toDataURL('image/png');
                      photo.setAttribute('src', data);


                     
                  }
                  

                  function clearphotopan() {
             

                      var context = canvaspan.getContext('2d');
                      context.fillStyle = "#AAA";
                      context.fillRect(0, 0, canvaspan.width, canvaspan.height);
                  
                      var data = canvaspan.toDataURL('image/png');
                      photopan.setAttribute('src', data);
                  }
                  
                  function takepicture() {
                    var context = canvas.getContext('2d');
                    if (width && height) {
                      canvas.width = width;
                      canvas.height = height;
                      context.drawImage(video, 0, 0, width, height);
                      validDataface=canvas.toDataURL('image/png');
                      var data = canvas.toDataURL('image/png');
                      photo.setAttribute('src', data);
                    } else {
                      clearphoto();
                    }
                  }
                

                    
                  function takepicturepan() {
                      var context = canvaspan.getContext('2d');
                      if (width && height) {
                        canvaspan.width = width;
                        canvaspan.height = height;
                        context.drawImage(videopan, 0, 0, width, height);
                      
                        var data = canvaspan.toDataURL('image/png');
                        validDataid= canvaspan.toDataURL('image/png');
                        photopan.setAttribute('src', data);
                      } else {
                        clearphotopan();
                      }
                    }
                  // Set up our event listener to run the startup process
                  // once loading is complete.
                



          }
      };
  });