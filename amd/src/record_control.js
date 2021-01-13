require.config( {
    paths: {
        'datatables.net': '//cdn.datatables.net/1.10.12/js/jquery.dataTables'
    }
} );



define(['jquery','datatables.net'], function() {
    return {
 init: function(data,id,site,encodediste,enableevent,enablescreencapture) {
window.location.href=site+"/mod/quiz/accessrule/mproctoring/attempt.php?attempt="+data["attempt"]+
"&cmid="+data["cmid"]+"&id="+id+"&site="+encodediste+"&eventcap="+enableevent+"&sc="+enablescreencapture;
        }
        };
    });