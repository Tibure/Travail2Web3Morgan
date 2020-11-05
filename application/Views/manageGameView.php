<div class="container">
    <label for="puzzleSelect">Choisissez l'énigme à modifier</label>
    <div class="list-group">
        <a href="?=CodeMorse" class="list-group-item list-group-item-action active">code morse</a>
        <a href="#" class="list-group-item list-group-item-action">images turbulantes</a>
        <a href="#" class="list-group-item list-group-item-action">l'animal et l'homme</a>
        <a href="#" class="list-group-item list-group-item-action">les chiffres</a>
    </div>
</div>
<br>
<div class="container">

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Image de l'énigme : </span>
        </div>
        <img src="public/images/MorseCode.jpg" class="img-fluid" alt="Responsive image">
        <button type="button" class="btn btn-warning">choisissez une image</button>
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Question de l'énigme : </span>
        </div>
        <input type="text" class="form-control" value="Question 1 : Vous devez résoudre le code morse."
            aria-label="question" aria-describedby="question">
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">indice de l'énigme :</span>
        </div>
        <input type="text" class="form-control" value="Déchiffrer le code dans le bas de l'image." aria-label="question"
            aria-describedby="question">
    </div>
    <div class="input-group mb-3">
        <button type="button" class="btn btn-primary "style="margin-right:10px">Sauvegarder</button>
        <button type="button" class="btn btn-danger "style="margin-right:10px">Supprimer</button>
    </div>
</div>