(function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        document.getElementById("inscription_btn").addEventListener("click", function (event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();

$(document).ready(function () {

    document.getElementById("inscription_btn").addEventListener("click", function (event) {
        event.preventDefault();
        const email = $("#email").val();
        const password = $("#password").val();
        const confirmPassword = $("#confirm_password").val();
        const username = $("#username").val();
        clearInputCSS();
        $.ajax({
                method: "POST",
                url: "/inscription/signIn",
                dataType: "json",
                data: {
                    'email': email,
                    'password': password,
                    'confirm_password': confirmPassword,
                    'username': username
                }
            })
            .then(function (response) {
                if (response.isValid === true) 
                {
                    $("#signedUpModal").modal('show')
                } 
                else 
                {
                    if(!response.errorMessage)
                    {
                      alert("Inscription impossible ! Verifiez les données entrée. (les mots de passes doivent correspondre)");
                    }
                    else
                    {
                      alert("Inscription impossible ! Verifiez les données entrée. \n Erreur : " + response.errorMessage);
                    }
                }
            }).catch(function (error) {
                alert("Erreur inconnue ! Veuillez nous contactez");
            });
    });
});

function clearInputCSS() {
    $("input").css("background-color", "");
    $("input").css("color", "");
    $("input").css("title", "");
}