<?php 
echo('<script type="text/javascript" src="\public\js\connection.js"></script>');
?>



<form class="needs-validation" id="connectionForm" novalidate>
    <div class="form-group">
        <label for="email">Adresse courriel</label>
        <input type="email" class="form-control" id="email" REQUIRED>
        <div class="invalid-feedback">
            Veuillez entrer une adresse email valide.
        </div>
    </div>
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control" id="password" REQUIRED>
        <div class="invalid-feedback">
            Veuillez remplir ce champ.
        </div>
    </div>
    <button class="btn btn-primary" id="connect_btn">Se connecter</button>
</form>
