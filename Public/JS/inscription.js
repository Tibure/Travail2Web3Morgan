$(document).ready(function(){
    
    document.getElementById("inscription_btn").addEventListener("click", function(event){
    event.preventDefault();
    const email = $("#email").val();
    const password = $("#password").val();
    const username = $("#username").val();
    /* const confirmPassword = $("#confirmPassword").val(); */
    $.ajax({       
        method:"POST",   
        url: "/inscription/signIn",
        dataType: "json",
        data: {'email': email, 'password': password, 'username': username}
    })
    .then(function(isValid){
       if(isValid){
        $("#inscriptionForm").submit();
       }
       else{
         
       }
    });
    });


     // Fetch all the forms we want to apply custom Bootstrap validation styles to
     /*  $(".needs-Equal").keydown(function(event) {
         if($("password").text() === $("confirmPassword").text())
         $(".needs-Equal").addClass('was-validated');
         else
         $(".needs-Equal").removeClass('was-validated');

       }); */
})