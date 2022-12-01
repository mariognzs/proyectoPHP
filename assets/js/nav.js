$(document).ready(function(){
    $("#registerForm").hide();
    $("#registerNav").addClass("text-warning");

})


$("#loginNav").click(function(){
    $("#loginNav").addClass("active");
    $("#registerNav").addClass("text-warning");
    $("#registerNav").removeClass("active");
    $("#loginNav").removeClass("text-warning");


    $("#loginForm").show();
    $("#registerForm").hide();
    


});

$("#registerNav").click(function(){
    $("#loginNav").removeClass("active");
    $("#registerNav").removeClass("text-warning");
    $("#registerNav").addClass("active");
    $("#loginNav").addClass("text-warning");




    $("#registerForm").show();
    $("#loginForm").hide();


});
