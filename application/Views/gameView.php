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
        <button type="submit" id="btn_answer" class="btn btn-primary">Répondre</button>
    </form>
</div>