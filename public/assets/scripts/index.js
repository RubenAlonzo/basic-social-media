$( document ).ready(function() {
 
  $(".replyBtn").click(function () {
    let response = $(this).siblings(".response").attr("value");
    let selfId = $(this).siblings(".selfid").attr("value");

    $("#responsetype").val(response);
    $("#parentid").val(selfId);
  });
 
});