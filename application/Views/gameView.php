<div class="container">
    <span>58 secondes</span><br>
    <img src="public/images/MorseCode.jpg" class="img-fluid" alt="Responsive image">
    <h3>Question 1 : Vous devez résoudre le code morse</h3>
    <form class="needs-validation" novalidate>
        <div class="form-group">
            <label for="reponse">Votre réponse</label>
            <input type="text" class="form-control" id="reponse" REQUIRED>
            <div class="invalid-feedback">
                Mauvaise réponse... Voulez-vous un indice?
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="indice">
                    <label class="form-check-label" for="indice">Indice</label>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>