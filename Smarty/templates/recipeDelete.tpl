<form id="formRecipe" method="POST" action="/Dolce_Abruzzo/gestioneRicette/eliminaRicetta/{$ricetta->getId_ricetta()}">
    <div id="confirmationRecipePopup" class="popup">
        <div class="popup-content">
            <h2>Conferma eliminazione ricetta</h2>
            <p>Per confermare l'eliminazione della ricetta, digitare "CONFERMA" nel campo sottostante e cliccare sul pulsante "Conferma"</p>
            <input type="text" id="confirmRecipeInput" placeholder="Digitare CONFERMA" required>
            <div class="bottoni">
                <button type="submit" href="" class="btn btn-danger btn-block" id="confirmRecipeBtn">Conferma</button>
                <button type="button" class="btn btn-danger btn-block" id="cancelRecipeBtn">Annulla</button>
            </div>
        </div>
    </div>
</form>