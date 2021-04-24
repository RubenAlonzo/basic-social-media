$( document ).ready(function() {
 
  $(".actionBtn").click(function () {
    let postId = $(this).siblings(".postid").attr("value");
    let selfId = $(this).siblings(".selfid").attr("value");
    let page = $(this).siblings(".page").attr("value");

    $("#postid").val(postId);
    $("#parentid").val(selfId);
    $("#page").val(page);
  });
 
  $(".link-delete").on("click",function(){
    let id = $(this).data("id");
    let action = $(this).data("action");
    let page = $(this).data("page");
    let proceedDeleting = confirm("Are you sure you want to delete it?");
    if(proceedDeleting && id) window.location.href = "../../app/controllers/home/" + action + ".php?id=" + id + "&page=" + page;
  }); 
});


