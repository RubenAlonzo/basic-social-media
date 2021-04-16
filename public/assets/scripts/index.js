$( document ).ready(function() {
 
  $(".replyBtn").click(function () {
    let targetId = $(this).siblings(".self-id").attr("value");
    let targetType = $(this).siblings(".self-type").attr("value");
    let postId = $(this).siblings(".self-type").attr("value");
    $("#targetReply").val(targetId);
    $("#targetReplyType").val(targetType);
    $("#parentPost").val(postId);
  });
 
});