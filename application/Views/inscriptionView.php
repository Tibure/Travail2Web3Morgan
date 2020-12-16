<?php 
echo('<script type="text/javascript" src="\public\js\inscription.js"></script>');
?>



<form class="needs-validation" id="inscriptionForm" action="/home/show"novalidate>
    <div class="form-group">
        <label for="email">Adresse courriel</label>
        <input type="email" class="form-control" id="email" REQUIRED>
        <div class="invalid-feedback">
            Veuillez entrer une adresse email valide.
        </div>
    </div>
    <div class="form-group">
        <label for="username">nom d'utilisateur</label>
        <input type="text" class="form-control" id="username" REQUIRED>
        <div class="invalid-feedback">
            Veuillez remplir ce champ (3 caractère minimum et 16 maximum).
        </div>
    </div>
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control needs-Equal" id="password" REQUIRED pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*\/#?&()])[A-Za-z\d@$!%*\/#?&()]{3,}$">
        <div class="invalid-feedback">
            Veuillez remplir ce champ (vous devez utiliser minimum une lettre, un chiffre et un symbole).
        </div>
    </div>
    <div class="form-group">
        <label for="password">Confirmez mot de passe</label>
        <input type="password" class="form-control needs-Equal" id="confirm_password" REQUIRED pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*\/#?&()])[A-Za-z\d@$!%*\/#?&()]{3,}$">
        <div class="invalid-feedback">
            Veuillez remplir ce champ, il doit correspondre avec le mot de passe.
        </div>
    </div>
    
    <button class="btn btn-primary" id="inscription_btn">S'inscrire</button>

    <div class="modal fade" id="signedUpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
     <div class="modal-content">
     <div class="modal-header">
         <h4 class="modal-title">Inscription !</h4>
     </div>
     <div class="modal-body">
         <p>Vous êtes inscrit avec succès !</p>
     </div>
     <div class="modal-footer">
         <button type="submit" class="btn btn-white" >OK</button>
     </div>
   </div>
  </div>
</div>     
</form>
