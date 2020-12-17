<?php 
echo('<script type="text/javascript" src="\public\js\gameView.js"></script>');
?>

<div class="container">
    <img id="image" src="/game/retrieveFile/1" class="img-fluid" alt="">
    <h2 id="title"></h2>
    <h4 id="question"></h4>
    <form id="gameForm" action="/game/change_puzzle" method="GET">
        <div class="form-group">
            <label for="answer">Votre réponse</label>
            <input type="text" class="form-control" id="answer">
<!--             <div class="invalid-feedback">
                Mauvaise réponse... Voulez-vous un indice?
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="indice">
                    <label class="form-check-label" for="indice">Indice</label>
                </div>
            </div> -->
        </div>
        <button type="submit" id="btn_answer" class="btn btn-primary">Répondre</button>
    </form>
</div>