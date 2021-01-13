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


function viewImg(id,typ,url) {
    
    $.ajax({
        method: "POST",
        url: url+'/mod/quiz/accessrule/mproctoring/api/getImages.php',
        data: {atmid: id ,type:typ},
        success:function(data){
            $("#viewimg").attr("src",data);
          $("#imgModal").modal("show")
        }
      });
      
}
define(['jquery','datatables.net'], function($) {
    return {
        /**
         * Init function.
         *
         */ 

        init: function(data) {
            loadCss("//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css");


            $("body").append('<div id="imgModal" class="modal fade" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"><img id="viewimg" style="height:auto;width:auto;" /></div>  </div></div> </div>');




            $('.quizattemptcounts').append(
                $('</br>'),
                $('<table/>', {
                    'id':"dataUser" ,
                    'class' : "table table-striped table-bordered" ,
                    'width':"100%"
                }));


                $('#dataUser').DataTable( {
                    data: data,
                    columns: [
                        { title: "Id" },
                        { title: "Firstname" },
                        { title: "Lastname" },
                        { title: "Email" },
                        { title: "Attempt" },
                        { title: "Browser History" },
                        { title: "Out of Focus(OOF)" },
                        { title: "OOF time in Mins" },
                        { title: "ScreenShots" },
                        { title: "Student Photo" },
                        { title: "Student Identity" },
                        { title: "Average Matching Percentage" },
                        { title: "During Exam student Photos" },
                        { title: "Audio" }
                    ]
                } );
            }
        };
    });