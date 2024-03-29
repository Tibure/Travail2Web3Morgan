$(document).ready(function(){
    
        document.getElementById("connect_btn").addEventListener("click", function(event){
        event.preventDefault();
        const email = $("#email").val();
        const password = $("#password").val();

        $.ajax({       
            method:"POST",   
            url: "/connection/verifyLogin",
            dataType: "json",
            data: {'email': email, 'password': password }
        })
        .then(function(isValid){
           if(isValid){
            $("#connectionForm").submit();
           }
           else{
            alert('Email ou mot de passe incorrecte');
           }
        });
        });
})