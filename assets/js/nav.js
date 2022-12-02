function alerta(){
    console.log("funciona")
    swal ( "Oops" ,  "Something went wrong!" ,  "error" )

}

$(".navli").click(function(){
    swal ( "Oops" ,  "Debes iniciar sesion para acceder ahí!" ,  "error" )
})

$(document).ready(function(){
    $("#registerForm").hide();
    $("#spinnerRegister").hide();
    $("#registerNav").addClass("text-warning");

    

})


$("#loginNav").click(function(){
    $("#loginNav").addClass("active");
    $("#registerNav").addClass("text-warning");
    $("#registerNav").removeClass("active");
    $("#loginNav").removeClass("text-warning"); 



    $("#spinnerLogin").show();
    $("#spinnerRegister").hide();
    $("#loginForm").show();
    $("#registerForm").hide();
    


});

$("#registerNav").click(function(){
    $("#loginNav").removeClass("active");
    $("#registerNav").removeClass("text-warning");
    $("#registerNav").addClass("active");
    $("#loginNav").addClass("text-warning");



    $("#spinnerLogin").hide();
    $("#spinnerRegister").show();
    $("#registerForm").show();
    $("#loginForm").hide();


});
