<?php
    echo '<script type="text/javascript" src="/'.PATH_PUBLIC.'\js\mainJS.js"></script>';
?>

<form class="needs-validation" method="post" action="/team/addTeam" novalidate>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="Name">Nom</label>
                <input class="form-control" id="Name" name="Name" required>
                <div class="invalid-feedback">
                    Le nom est requis.
                </div>
            </div>
            <div class="form-group">
                <label for="Email">Adresse courriel</label>
                <input type="Email" class="form-control" id="Email" name="Email" required>
                <div class="invalid-feedback">
                    Une adresse courriel valide est requise.
                </div>
            </div>
            <div class="form-group">
                <label for="Password">Mot de passe</label>
                <input type="Password" class="form-control" id="Password">
                <div class="invalid-feedback">
                    Un mot de passe est requis.
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>