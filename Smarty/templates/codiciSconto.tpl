<div class="row d-flex justify-content-between mx-2">
    <h2>Codici sconto</h2>
</div>
{if $nessun_codice_sconto == 1}
    <div class="mt-5 d-flex justify-content-center">
        <div class="alert alert-info" role="alert">
            Nessun codice sconto riscattato
        </div>
    </div>
{else}
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Codice sconto</th>
                    <th>Valore</th>
                    <th>Stato</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$codici_sconto item=codice_sconto}
                    <tr>
                        <td><p>{$codice_sconto->getCodiceSconto()}</p></td>
                        <td><p>{$codice_sconto->getValore_sconto()}%</p></td>
                        <td>
                            {if $codice_sconto->isValid()}
                                <p class="text-success">Da utilizzare</p>
                            {else}
                                <p class="text-danger">Utlizzato</p>
                            {/if}
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
{/if}