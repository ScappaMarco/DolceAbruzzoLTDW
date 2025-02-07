<div class="container mt-5">
    <h2 class="text-center">Storico Ordini</h2>
    {if $ordini}
        <table class="table">
            <thead>
                <tr>
                    <th>ID Ordine</th>
                    <th>Data</th>
                    <th>Stato</th>
                    <th>Totale</th>
                    <th>Dettagli</th>
                </tr>
            </thead>
            <tbody>
                {foreach $ordini as $ordine}
                    <tr>
                        <td>{$ordine->getId_ordine()}</td>
                        <td>{$ordine->getData_ordine()->format('d/m/Y')}</td>
                        <td>
                            {if $ordine->getStato_ordine() == 'Spedito'}
                                <p class="text-warning">Spedito</p>
                            {elseif $ordine->getStato_ordine() == 'Consegnato'}
                                <p class="text-success">Consegnato</p>
                            {else}
                                {$ordine->getStato_ordine()}
                            {/if}
                        </td>
                        <td>€{$ordine->getImporto_ordine()|string_format:"%.2f"}</td>
                        <td><a href="/Dolce_Abruzzo/gestioneAcquisti/dettaglioOrdine/{$ordine->getId_ordine()}"
                                class="btn btn-info btn-sm">Dettagli</a></td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    {else}
        <div class="mt-3 d-flex justify-content-center">
            <div class="alert alert-info" role="alert">
                Non hai ancora effettuato ordini.
            </div>
        </div>
    {/if}
</div>