{if $errorImageUpload == 1}
    <div class="mt-5 d-flex justify-content-center">
        <div class="alert alert-danger" role="alert">
        Errore nell'upload delle immagini! Size troppo grande o tipo del file diverso da jpeg/png !
    </div>
</div>
{/if}

<div class="product-form-container">
    <h2>Modifica la ricetta</h2>
    <form id="productForm" method="POST" action="/Dolce_Abruzzo/gestioneRicette/modificaRicetta/{$idRicetta}"
        enctype="multipart/form-data">
        <div class="left-column">
            <div class="form-group">
                <label>Titolo ricetta</label>
                <input name="titolo" type="text" class="form-control" id="titolo" placeholder="Titolo..."
                    value="{$titoloRicetta}" required>
            </div>
            <div class="form-group">
                <label>Descrizione</label>
                <br>
                <textarea name="descrizione" id="description" rows="10" cols="57" required>{$descrizione}</textarea>
            </div>
            <div class="form-group">
                <label for="images">Aggiungi l'immagine per la ricetta(massimo 1 immagine):</label>
                <input id="images" name="images" type="file" single>
            </div>

            <div class="image-preview" id="imagePreview">
                <div class="image-container">
                    <img src="data:{$immagine->getType()};base64,{$immagine->getImageData()}" alt="Immagine">
                    <button type="button" class="remove-button">Immagine attuale</button>
                </div>
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
                <div class="form-group">
                    <label for="brand">Procedimento</label>
                    <br>
                    <textarea name="procedimento" id="procedimento" rows="10" cols="57" required>{$procedimento}</textarea>
                </div>
            </fieldset>
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
        imageArray = files;

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