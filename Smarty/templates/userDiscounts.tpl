<div class="external-area">
    <div class="content-area">
        <div class="points">
            <h2><b>Hai <span id="points">{$punti_fedelta}</span> punti fedeltà</b></h2>
            {if $punti_fedelta_non_sufficienti == 1}
                <div class="mt-5 d-flex justify-content-center">
                    <div class="alert alert-warning" role="alert">
                        Punti fedeltà non sufficienti per generare lo sconto desiderato
                    </div>
                </div>
            {/if}

            {if $errore_valore_sconto == 1}
                <div class="mt-5 d-flex justify-content-center">
                    <div class="alert alert-danger" role="alert">
                        Valore sconto errato!
                    </div>
                </div>
            {/if}

            {if $codice_success != 0}
                <div class="mt-5 d-flex justify-content-center">
                    <div class="alert alert-success" role="alert">
                        Codice sconto del {$codice_success}% generato con successo
                    </div>
                </div>
            {/if}
        </div>
        <div class="discounts">
            <div class="discount">
                <h3>5% di sconto sul prossimo acquisto</h3>
                <p>Richiede 100 punti fedeltà</p>
                <a href="/Dolce_Abruzzo/utente/verificaSconto/5" class="btn btn-success">Riscatta</a>
            </div>
            <div class="discount">
                <h3>10% di sconto sul prossimo acquisto</h3>
                <p>Richiede 200 punti fedeltà</p>
                <a href="/Dolce_Abruzzo/utente/verificaSconto/10" class="btn btn-success">Riscatta</a>
            </div>
            <div class="discount">
                <h3>15% di sconto sul prossimo acquisto</h3>
                <p>Richiede 300 punti fedeltà</p>
                <a href="/Dolce_Abruzzo/utente/verificaSconto/15" class="btn btn-success">Riscatta</a>
            </div>
            <div class="col-12 mt-5 d-flex justify-content-center">
                <a href="/Dolce_Abruzzo/utente/codiciSconto" class="btn btn-outline-primary">Visualizza codici riscattati</a>
            </div>
        </div>
    </div>
</div>