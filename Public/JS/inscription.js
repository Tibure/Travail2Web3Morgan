$(document).ready(function(){
    
    document.getElementById("inscription_btn").addEventListener("click", function(event){
    event.preventDefault();
    const email = $("#email").val();
    const password = $("#password").val();
    const username = $("#username").val();
    clearInputCSS();
    /* const confirmPassword = $("#confirmPassword").val(); */
    $.ajax({       
        method:"POST",   
        url: "/inscription/signIn",
        dataType: "json",
        data: {'email': email, 'password': password, 'username': username}
    })
    .then(function(response){
       console.log(response);
        if(response.isValid === true){
            $("#signedUpModal").modal('show')
       }
       else{
            if(response.isValid != null && response.errorMessage != null && response.inputID){
            $("#"+response.inputID).css("background-color", "red");
            $("#"+response.inputID).css("color", "white");
            $("#"+response.inputID).attr("title", response.errorMessage); 
            }
            else{
                alert("unknown error, please notify our support team (Err#1)");
            }
         }
       
    }).catch(function(error){
        alert("unknown error, please notify our support team (Err#2)");
    });
    });

     // Fetch all the forms we want to apply custom Bootstrap validation styles to
     /*  $(".needs-Equal").keydown(function(event) {
         if($("password").text() === $("confirmPassword").text())
         $(".needs-Equal").addClass('was-validated');
         else
         $(".needs-Equal").removeClass('was-validated');

       }); */
});

function clearInputCSS(){
    $("input").css("background-color", "");
    $("input").css("color", "");
    $("input").css("title", "");
}