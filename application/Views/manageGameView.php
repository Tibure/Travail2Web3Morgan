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
    <?php
        if($message != "")
        {
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    ?>
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
    <form action="/file/addFile" id="add_file" method="POST" novalidate class="needs-validation"
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
<form class="needs-validation" method="POST" novalidate>
    <div class="container">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="nom">Nom de l'énigme : </span>
            </div>
            <input type="text" class="form-control" placeholder="Entrer un nom." aria-label="nom" aria-describedby="nom"
                id="puzzleName"  name="puzzleName" REQUIRED>
            <div class="invalid-feedback">
                Le champ ne peux pas être vide.
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="image">Image de l'énigme : </span>
            </div>
            <select class="form-control" id="selectImage" name="selectImage">
            </select>
        </div>

        <div class="text-center mb-3">
        <img id="previewImagePuzzle" src=" " width="400" height="300" class="rounded">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="question">Question de l'énigme : </span>
            </div>
            <input type="text" class="form-control" placeholder="Entrer une Question." aria-label="question"
               id="puzzleQuestion" name="puzzleQuestion" aria-describedby="question" REQUIRED>
            <div class="invalid-feedback">
                Le champ ne peux pas être vide.
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="indice">indice de l'énigme :</span>
            </div>
            <input type="text" class="form-control" placeholder="Entrer un indice." aria-label="indice"
            id="puzzleHint" name="puzzleHint" aria-describedby="indice">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" >Réponse de l'énigme</span>
            </div>
            <input type="text" class="form-control" placeholder="Entrer une réponse." aria-label="reponse"
            id="puzzleAnswer" name="puzzleAnswer" aria-describedby="reponse" REQUIRED>
            <div class="invalid-feedback">
                Le champ ne peux pas être vide.
            </div>
        </div>
        
        <input type="text" name="puzzleID" id="puzzleID" value="-1" hidden>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="puzzleActive" name="puzzleActive">
            <label class="form-check-label" for="enablePuzzle">Énigme active </label>
        </div>

        <div class="input-group mb-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalOrder" id="managerOrder" class="btn"style="margin-right:10px">Gérer l'ordre generale</button>
            <button type="submit" class="btn btn-success" id="btn_add" formaction="/manageGame/add_puzzle" style="margin-right:10px">Ajouter</button>
            <button disabled="false" type="submit" class="btn btn-primary" id="btn_save" formaction="/manageGame/save_puzzle" style="margin-right:10px">Sauvegarder</button>
            <button disabled="false" type="submit" class="btn btn-danger"  id="btn_delete" onclick="return confirm('Êtes vous sur ?')" formaction="/manageGame/delete_puzzle"style="margin-right:10px">Supprimer</button>
        </div>
    </div>
</form>

<div class="modal fade" id="modalOrder" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Changer l'ordre des énigmes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="button" class="btn btn-primary" id="saveOrder">Sauvegarder</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="/Public\js\addFile.js"></script>
<script type="text/javascript" src="/Public\js\manageGame.js"></script>