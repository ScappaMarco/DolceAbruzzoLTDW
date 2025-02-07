<div class="section-indirizzi-carte">
    <div class="row d-flex justify-content-between mx-2">
        <h2 class="text-center">Le mie carte di credito</h2>
        <div class="">
            <a href="/Dolce_Abruzzo/utente/aggiungiCarte" class="btn btn-primary btn-block">Aggiungi nuova carta</a>
        </div>
    </div>
    {if isset($messages.success)}
        <div class="mt-3 d-flex justify-content-center">
            <div class="alert alert-success" role="alert">
                {$messages.success}
            </div>
        </div>
    {/if}
    {if isset($messages.info)}
        <div class="mt-3 d-flex justify-content-center">
            <div class="alert alert-info" role="alert">
                {$messages.info}
            </div>
        </div>
    {/if}
    {if isset($messages.error)}
        <div class="mt-3 d-flex justify-content-center">
            <div class="alert alert-danger" role="alert">
                {$messages.error}
            </div>
        </div>
    {/if}

    {if $errorEliminaCarta == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-danger" role="alert">
                Errore: carta non esistente
            </div>
        </div>
    {/if}

    {if isset($errorEliminaCarta) && $errorEliminaCarta}
        <div class="alert alert-danger mt-3" role="alert">
            Si è verificato un errore durante l'eliminazione della carta di credito. La carta potrebbe non esistere o potrebbe esserci un problema nel sistema.
        </div>
    {/if}
    <br>
    <div class="container">
        {if isset($carte_credito) && !empty($carte_credito)}
            <table>
                <thead>
                    <tr>
                        <th>Nome titolare</th>
                        <th>Cognome titolare</th>
                        <th>Numero carta</th>
                        <th>Scadenza</th>
                        <th>Gestore</th>
                        <th>Stato</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach $carte_credito as $carta}
                    <tr class="{if $carta->isDeleted()}row-hidden{/if}">
                        <td>{$carta->getNome_titolare()}</td>
                        <td>{$carta->getCognome_titolare()}</td>
                        <td>**** **** **** {$carta->getNumero_carta()|substr:-4}</td>
                        <td>{$carta->getData_scadenza()}</td>
                        <td>{$carta->getGestore_carta()}</td>
                        <td>{if $carta->isDeleted()}Nascosta{else}Attiva{/if}</td>
                        <td>
                            {if $carta->isDeleted()}
                                <a href="/Dolce_Abruzzo/utente/riattivaCarta/{$carta->getNumero_carta()}" class="btn btn-success btn-sm">Riattiva</a>
                            {else}
                                <a href="/Dolce_Abruzzo/utente/eliminaCarta/{$carta->getNumero_carta()}" class="btn btn-danger btn-sm">Elimina</a>
                            {/if}
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
        {else}
            <div class="alert alert-info" role="alert">
                Non hai ancora salvato nessuna carta di credito.
            </div>
        {/if}
    </div>
</div>