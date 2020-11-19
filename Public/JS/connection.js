window.onload= function(){
    
        document.getElementById("connect_btn").addEventListener("click", function(event){
        event.preventDefault();
        const email = $("#email").val();
        const password = document.getElementById("password").value;
        const dataToSend= {email: email, password: password};
            console.log(email + " " + password);
        $.ajax({       
            type:"POST",   
            url: "/connection/verifyLogin",
            dataType: "JSON",
            data: dataToSend
        }).then(function(inData){
           const data = inData;
        });
        }
    )
}