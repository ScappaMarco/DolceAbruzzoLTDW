{if $errorImageUpload == 1}
    <div class="mt-5 d-flex justify-content-center">
        <div class="alert alert-danger" role="alert">
            Errore nell'upload delle immagini! Size troppo grande o tipo del file diverso da jpeg/png !
        </div>
    </div>
{/if}

<div class="product-form-container">
    <h2>Inserisci una nuova ricetta</h2>
    <form id="productForm" method="POST" action="/Dolce_Abruzzo/gestioneRicette/addRicetta" enctype="multipart/form-data">
        <div class="left-column">
            <div class="form-group">
                <label>Titolo della ricetta</label>
                <input name="titolo" type="text" class="form-control" id="nome" placeholder="Titolo..." required>
            </div>

            <div class="form-group">
                <label>Descrizione</label>
                <textarea name="descrizione" id="description" rows="10" cols="57" required></textarea>
            </div>
            <br>
            <div class="form-group">
                <label for="images">Aggiungi l'immagine per la ricetta(massimo 1 immagine):</label>
                <input name="image" type="file" single required>
            </div>
        </div>

        <div class="right-column">
            <fieldset>
                <legend>Specifiche</legend>
                <div class="form-group">
                    <label for="brand">Ingredienti</label>
                    <textarea name="ingredienti" id="ingredienti" rows="3" cols="57" required></textarea>
                </div>
                <div class="form-group">
                    <label>Procedimento</label>
                    <textarea name="procedimento" id="procedimento" rows="10" cols="57" required></textarea>
                </div>
            </fieldset>

            <button type="submit" class="btn btn-primary">Aggiungi</button>
        </div>

        <div class="form-group mb-2">
            <label class="form-label d-block">Difficoltà:</label>
            <div class="star-rating">
                <input type="radio" id="star5" name="difficolta" value="5" required /><label for="star5" title="5 stelle"></label>
                <input type="radio" id="star4" name="difficolta" value="4" /><label for="star4" title="4 stelle"></label>
                <input type="radio" id="star3" name="difficolta" value="3" /><label for="star3" title="3 stelle"></label>
                <input type="radio" id="star2" name="difficolta" value="2" /><label for="star2" title="2 stelle"></label>
                <input type="radio" id="star1" name="difficolta" value="1" /><label for="star1" title="1 stella"></label>
            </div>
            <div class="invalid-feedback mt-2">
                Per favore, seleziona una valutazione.
            </div>
        </div>

    </form>
</div>