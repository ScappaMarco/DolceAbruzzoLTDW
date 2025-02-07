<form class="container-fluid text-center" method="GET" action="/Dolce_Abruzzo/gestioneProdotti/addProduct">
    <button type="submit" class="btn btn-primary">Aggiungi un nuovo prodotto</button>
</form>
{if $addedProductSuccess == 1}
    <div class="mt-5 d-flex justify-content-center">
        <div class="alert alert-success" role="alert">
            Aggiunta del prodotto avvenuta con successo!
        </div>
    </div>
{/if}
{if $modifiedProductSuccess == 1}
    <div class="mt-5 d-flex justify-content-center">
        <div class="alert alert-success" role="alert">
            Modifica del prodotto avvenuta con successo!
        </div>
    </div>
{/if}
{if $deletedProductSuccess == 1}
    <div class="mt-5 d-flex justify-content-center">
        <div class="alert alert-success" role="alert">
            Eliminazione del prodotto avvenuta con successo!
        </div>
    </div>
{/if}

{if $array_prodotti['prodotti'] != null }
    <div class="row">
        {foreach from=$array_prodotti['prodotti'] item=prodotto}
            <!-- product -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="product__item">
                        <div class="product__item__pic set-bg">
                            {if $prodotto->getImmagini()->first()}
                                <img style="width:300px; height:300px;"
                                    src="data:{$prodotto->getImmagini()->first()->getType()};base64,{$prodotto->getImmagini()->first()->getEncodedData()}"
                                    alt="Immagine">
                            {else}
                                <p>Immagine non trovata</p>
                            {/if}
                            <div class="product__label">
                                <span>{$prodotto->getNome()}</span>
                            </div>
                        </div>
                        <div class="product__item__text">
                            <h5>{$prodotto->getNomeCategoria()->getNomeCategoria()}</h5>
                            <div class="product__item__price">€{$prodotto->getPrezzo()}</div>
                            <div class="cart_add">
                                <a href="/Dolce_Abruzzo/gestioneProdotti/modificaProdotto/{$prodotto->getIdProdotto()}">Modifica</a>
                                <a type="submit" id="{$prodotto->getIdProdotto()}" class="deleteProdBtns">Elimina</a>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- /product -->
        {/foreach}
    </div>
    <!-- Pagination -->
    <div class="pagination">
    {if $array_prodotti['currentPage'] > 1}
        <a href="?page={$array_prodotti['currentPage']-1}">&laquo; Precedente</a>
    {/if}

    {for $page=1 to $array_prodotti['totalPages']}
    <a href="?page={$page}" {if $page == $array_prodotti['currentPage']}class="active"{/if}>
        {$page}
    </a>
    {/for}

    {if $array_prodotti['currentPage'] < $array_prodotti['totalPages']}
        <a href="?page={$array_prodotti['currentPage']+1}">Successivo &raquo;</a>
    {/if}
    </div>
    <!-- /Pagination --> 
    {include file = 'productDelete.tpl'}
{/if}

{if $is_arrayprodotti_vuoto == 1}
    <div class="alert alert-info">
        Non ci sono prodotti! Aggiungi nuovi prodotti cliccando sul pulsante
    </div>
{/if}