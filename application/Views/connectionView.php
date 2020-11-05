<form class="needs-validation" novalidate>
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
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>