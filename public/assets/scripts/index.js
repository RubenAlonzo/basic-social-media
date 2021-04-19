$( document ).ready(function() {
 
  $(".actionBtn").click(function () {
    let postId = $(this).siblings(".postid").attr("value");
    let selfId = $(this).siblings(".selfid").attr("value");

    $("#postid").val(postId);
    $("#parentid").val(selfId);
  });
 
});