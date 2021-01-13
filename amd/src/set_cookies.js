function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
  var expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
define(["jquery"], function ($) {
  return {
    init: function () {
    
      var isChrome =
        !!window.chrome &&
        (!!window.chrome.webstore || !!window.chrome.runtime);
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
