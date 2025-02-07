
{if $errorImageUpload == 1}
    <div class="mt-5 d-flex justify-content-center">
        <div class="alert alert-danger" role="alert">
            Errore nell'upload delle immagini! Size troppo grande o tipo del file diverso da jpeg/png !
        </div>
    </div>
{/if}

<div class="product-form-container">
    <h2>Modifica il prodotto</h2>
    <form id="productForm" method="POST" action="/Dolce_Abruzzo/gestioneProdotti/modificaProdotto/{$productId}" enctype="multipart/form-data">
        <div class="left-column">
            <div class="form-group">
                <label>Titolo prodotto</label>
                <input name="nome" type="text" class="form-control" id="nome" placeholder="Nome..." value="{$nomeProdotto}" required>
            </div>
            
            <div class="form-group">
            <label>Descrizione</label>
            <br>
                <textarea name="descrizione" id="description" rows="10" cols="57" required>{$descrizione}</textarea>
            </div>

            <label>Categoria</label>
                <select name="categoria" id="categoria" disabled>
                    <option value="{$categoria}">{$categoria}</option>
                </select>
            <br>
            <div class="form-group">
                <label for="images">Aggiungi al massimo 5 immagini (le immagini attuali saranno eliminate) :</label>
                    <input id="images" name="images[]" type="file" multiple>
            </div>

                <div class="image-preview" id="imagePreview">
                {foreach from=$immagini item=immagine}
                    <div class="image-container">
                        <img src="data:{$immagine.type};base64,{$immagine.imageData}" alt="Immagine">
                        <button type="button" class="remove-button">Immagine attuale</button>
                    </div>
                {/foreach}
                </div>

        </div>

        <div class="right-column">
            <fieldset>
                <legend>Specifiche</legend>

                <div class="form-group">
                <label for="brand">Ingredienti</label>
                <br>
                    <textarea name="ingredienti" id="ingredienti" rows="10" cols="57" required>{$ingredienti}</textarea>
                </div>

                <label for="quantity">Quantità</label>
                <input type="number" name="quantita_disp" id="quantita_disp" value={$quantita_disp} min="0" step="1" required>

                <label for="quantity">Punti fedeltà</label>
                <input type="number" name="punti_fedelta" id="punti_fedelta" value={$punti_fedelta} min="10" step="10" required>
            </fieldset>
        <div class="form-group price-for-new">
            <label for="price">Prezzo</label>
            <input type="number" name="prezzo" id="prezzo" value={$prezzo} min="1" step="0.01" placeholder="€####">
        </div>

            <button type="submit" class="btn btn-primary">Modifica</button>
        </div>

    </form>
</div>
<script>
    const input = document.getElementById('images');
    const imagePreview = document.getElementById('imagePreview');
    let imageArray = [];

    input.addEventListener('change', () => {
        const files = Array.from(input.files);

        if (files.length + imageArray.length > 5) {
            alert('Puoi caricare un massimo di 5 immagini.');
            input.value = ''; // Resetta il campo file input
            return;
        }

        imageArray = imageArray.concat(files);
        
        updateImagePreview();
        updateInputFiles();
    });

    function updateImagePreview() {
        imagePreview.innerHTML = '';

        imageArray.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = () => {
                const imgContainer = document.createElement('div');
                imgContainer.classList.add('image-container');

                const img = document.createElement('img');
                img.src = reader.result;
                imgContainer.appendChild(img);

                const removeButton = document.createElement('button');
                removeButton.classList.add('remove-button');
                removeButton.textContent = 'Rimuovi';
                removeButton.onclick = () => {
                    imageArray.splice(index, 1);
                    updateImagePreview();
                    updateInputFiles();
                };

                imgContainer.appendChild(removeButton);
                imagePreview.appendChild(imgContainer);
            };
            reader.readAsDataURL(file);
        });
    }

    function updateInputFiles() {
        const dataTransfer = new DataTransfer();
        imageArray.forEach(file => dataTransfer.items.add(file));
        input.files = dataTransfer.files;
    }

    function removeImage(button) {
        const index = Array.from(imagePreview.children).indexOf(button.parentElement);
        imageArray.splice(index, 1);
        updateImagePreview();
        updateInputFiles();
    }
</script>