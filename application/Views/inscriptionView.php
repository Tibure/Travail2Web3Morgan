<?php 
echo('<script type="text/javascript" src="\public\js\inscription.js"></script>');
?>



<form class="needs-validation" id="inscriptionForm" action="home/show"novalidate>
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
            Veuillez remplir ce champ.
        </div>
    </div>
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control" id="password" REQUIRED>
        <div class="invalid-feedback">
            Veuillez remplir ce champ.
        </div>
    </div>
    
    <button class="btn btn-primary" id="inscription_btn">S'inscrire</button>
</form>