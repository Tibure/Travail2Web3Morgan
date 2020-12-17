<?php 
echo('<script type="text/javascript" src="\public\js\gameView.js"></script>');
?>

<div class="container">
    <img id="image" src="" class="img-fluid" alt="" width="400" height="400">
    <h2 id="title"></h2>
    <h4 id="question"></h4>
    <form id="gameForm" action="/game/change_puzzle" method="GET">
        <div class="form-group">
            <label for="answer">Votre réponse</label>
            <input type="text" class="form-control" id="answer">
        </div>
        <button type="button" id="btn_answer" class="btn btn-primary">Répondre</button>
        <button type="button" id="btn_hint" data-toggle="modal" data-target="#modalHints" class="btn btn-secondary">Indices</button>
        <button type="submit" id="btn_next_puzzle" style="opacity:0%" class ="btn btn-primary" disabled>Voir l'énigme suivante</button>
        </form>
</div>
<div class="modal fade" id="modalHints" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalLabel">Indices accessibles</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
          </div>
        </div>
    </div>