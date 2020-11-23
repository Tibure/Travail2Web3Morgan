$(document).ready(function(){
    
        document.getElementById("connect_btn").addEventListener("click", function(event){
        event.preventDefault();
        const email = $("#email").val();
        const password = document.getElementById("password").value;

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
             
           }
        });
        });
})