    <div class="container mt-5">
        <h2>Gestione Ordini Admin</h2>
        {if $ordini}
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Ordine</th>
                        <th>Data</th>
                        <th>Cliente</th>
                        <th>Stato</th>
                        <th>Totale</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach $ordini as $ordine}
                        <tr>
                            <td>{$ordine->getId_ordine()}</td>
                            <td>{$ordine->getData_ordine()->format('d/m/Y')}</td>
                            <td>{$ordine->getCliente()->getNome()} {$ordine->getCliente()->getCognome()}</td>
                            <td>{$ordine->getStato_ordine()}</td>
                            <td>€{$ordine->getImporto_ordine()|string_format:"%.2f"}</td>
                            <td class="d-flex align-items-center">
                                <form action="/Dolce_Abruzzo/utente/updateOrderStatus" method="POST">
                                    <input type="hidden" name="orderId" value="{$ordine->getId_ordine()}">
                                    <select name="newStatus" class="form-control">
                                        <option value="Preso in carico" {if $ordine->getStato_ordine() == 'Preso in carico'}selected{/if}>Preso in carico</option>
                                        <option value="Spedito" {if $ordine->getStato_ordine() == 'Spedito'}selected{/if}>Spedito</option>
                                        <option value="Consegnato" {if $ordine->getStato_ordine() == 'Consegnato'}selected{/if}>Consegnato</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary mt-1 ml-3">Aggiorna Stato</button>
                                </form>
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        {else}
            <p>Non ci sono ordini in attesa al momento.</p>
        {/if}
    </div>