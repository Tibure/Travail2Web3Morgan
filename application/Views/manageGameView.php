<div class="container">
    <label for="puzzleSelect">Choisissez l'énigme à modifier</label>
    <div class="list-group">
        <a href="?=CodeMorse" class="list-group-item list-group-item-action">code morse
            <a href="#" class="list-group-item list-group-item-action">images turbulantes</a>
            <a href="#" class="list-group-item list-group-item-action">l'animal et l'homme</a>
            <a href="#" class="list-group-item list-group-item-action">les chiffres</a>
            <a href="?=NewPuzzle" class="list-group-item list-group-item-action active">Ajouter une énigme</a>
    </div>
</div>
<br>
<form class="needs-validation" novalidate>
    <div class="container">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="nom">Nom de l'énigme : </span>
            </div>
            <input type="text" class="form-control" value="Entrer un nom." aria-label="nom" aria-describedby="nom"
                REQUIRED>
            <div class="invalid-feedback">
                Le champ ne peux pas être vide.
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="image">Image de l'énigme : </span>
            </div>
            

            <?php 
            echo ('<script type="text/javascript" src="/'.PATH_PUBLIC.'\js\addFile.js"></script>');
            ?>

        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="question">Question de l'énigme : </span>
            </div>
            <input type="text" class="form-control" value="Entrer une Question." aria-label="question"
                aria-describedby="question" REQUIRED>
            <div class="invalid-feedback">
                Le champ ne peux pas être vide.
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="indice">indice de l'énigme :</span>
            </div>
            <input type="text" class="form-control" value="Entrer un indice." aria-label="indice"
                aria-describedby="indice" REQUIRED>
            <div class="invalid-feedback">
                Le champ ne peux pas être vide.
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="reponse">Réponse de l'énigme</span>
            </div>
            <input type="text" class="form-control" value="Entrer une réponse." aria-label="reponse"
                aria-describedby="reponse" REQUIRED>
            <div class="invalid-feedback">
                Le champ ne peux pas être vide.
            </div>
        </div>

        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="enablePuzzle">
            <label class="form-check-label" for="enablePuzzle">Énigme active </label>
        </div>

        <div class="input-group mb-3">
            <button type="submit" class="btn btn-success " style="margin-right:10px">Ajouter</button>
            <button type="submit" class="btn btn-primary " style="margin-right:10px" hidden>Sauvegarder</button>
            <button type="submit" class="btn btn-danger " style="margin-right:10px" hidden>Supprimer</button>
        </div>
    </div>
</form>
