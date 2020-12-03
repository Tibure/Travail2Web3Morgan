<div class="container">
    <!--
    <div class="list-group">
        <a href="?=CodeMorse" class="list-group-item list-group-item-action">code morse
            <a href="#" class="list-group-item list-group-item-action">images turbulantes</a>
            <a href="#" class="list-group-item list-group-item-action">l'animal et l'homme</a>
            <a href="#" class="list-group-item list-group-item-action">les chiffres</a>
            <a href="?=NewPuzzle" class="list-group-item list-group-item-action active">Ajouter une énigme</a>
    </div>
    -->

    <div class="form-group">
    <label for="PuzzleSelect">Choisissez l'énigme à modifier</label>
    <select class="form-control" id="PuzzleSelect">

    </select>
</div>
<br>
<div class="container">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="newImage">Téléversez une nouvelle image : </span>
        </div>
    </div>
    <form action="/file/addFile" id="add_file" method="post" novalidate class="needs-validation"
        enctype="multipart/form-data">
        <div class="form-group align-middle ">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="file" name="file">
                <label class="custom-file-label" for="file">Veuillez choisir une image de type jpg</label>
            </div>
        </div>
        <button type="submit" class="btn btn-warning">Soumettre l'image</button>

    </form>
</div>
<br>
<form class="needs-validation" novalidate>
    <div class="container">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="nom">Nom de l'énigme : </span>
            </div>
            <input type="text" class="form-control" placeholder="Entrer un nom." aria-label="nom" aria-describedby="nom"
                id="puzzleName"  REQUIRED>
            <div class="invalid-feedback">
                Le champ ne peux pas être vide.
            </div>
        </div>

        <div class="input-group mb-3">
            <!-- reverifier les validatre -->
            <div class="input-group-prepend">
                <span class="input-group-text" id="image">Image de l'énigme : </span>
            </div>
            <select class="form-control" id="selectImage" onchange="SelectedImagePuzzle()">
                <option>image1</option>
                <option>image2</option>
                <option>image3</option>
                <!-- cick image 1 -> va trouver le path de l<image dans la base de donner
                    
                    dans file controller(va regarder si la session est game master) un truc retreivefile() qui appel celui de file service.
                     il va falloir changer le content type de celui de file service pour adapter en image. kool
                     Pour toute question demander MOrgan KAtjounis du 01-->
            </select>
            <img id="previewImagePuzzle" src="" width="500" height="600">
            <div class="invalid-feedback">
                Le champ ne peux pas être vide.
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="question">Question de l'énigme : </span>
            </div>
            <input type="text" class="form-control" placeholder="Entrer une Question." aria-label="question"
               id="puzzleQuestion" aria-describedby="question" REQUIRED>
            <div class="invalid-feedback">
                Le champ ne peux pas être vide.
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="indice">indice de l'énigme :</span>
            </div>
            <input type="text" class="form-control" placeholder="Entrer un indice." aria-label="indice"
            id="puzzleHint" aria-describedby="indice" REQUIRED>
            <div class="invalid-feedback">
                Le champ ne peux pas être vide.
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="reponse">Réponse de l'énigme</span>
            </div>
            <input type="text" class="form-control" placeholder="Entrer une réponse." aria-label="reponse"
            id="puzzleAnswer" aria-describedby="reponse" REQUIRED>
            <div class="invalid-feedback">
                Le champ ne peux pas être vide.
            </div>
        </div>
        <!--
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="order">Ordre de l'énigme</span>
            </div>
            <input type="number" class="form-control" placeholder=" Entrer l'ordre de l'énigme" aria-label="order"
                aria-describedby="order" REQUIRED>
            <div class="invalid-feedback">
                Le champ ne peux pas être vide.
            </div>
        </div>
-->

        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="puzzleActive">
            <label class="form-check-label" for="enablePuzzle">Énigme active </label>
        </div>

        <div class="input-group mb-3">
            <button type="submit" class="btn btn-success " style="margin-right:10px">Ajouter</button>
            <button type="submit" class="btn btn-primary " style="margin-right:10px">Sauvegarder</button>
            <button type="submit" class="btn btn-danger " style="margin-right:10px">Supprimer</button>
        </div>
    </div>
</form>
<script type="text/javascript" src="/Public\js\addFile.js"></script>
<script type="text/javascript" src="/Public\js\manageGame.js"></script>