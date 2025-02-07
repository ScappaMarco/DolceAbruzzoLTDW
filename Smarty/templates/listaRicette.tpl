<form class="container-fluid text-center" method="GET" action="/Dolce_Abruzzo/gestioneRicette/addRicetta">
    <button type="submit" class="btn btn-primary">Aggiungi una nuova ricetta</button>
</form>
{if $recipeAddedSucces == 1}
    <div class="mt-5 d-flex justify-content-center">
        <div class="alert alert-success" role="alert">
            Aggiunta della ricetta avvenuta con successo!
        </div>
    </div>
{/if}
{if $modifiedRecipeSuccess == 1}
    <div class="mt-5 d-flex justify-content-center">
        <div class="alert alert-success" role="alert">
            Modifica della ricetta avvenuta con successo!
        </div>
    </div>
{/if}
{if $deletedRecipeSuccess == 1}
    <div class="mt-5 d-flex justify-content-center">
        <div class="alert alert-success" role="alert">
            Eliminazione della ricetta avvenuta con successo!
        </div>
    </div>
{/if}

{if $array_ricette['ricette'] != null }
    <div class="row">
        {foreach from=$array_ricette['ricette'] item=ricetta}
            <!-- recipe -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="product__item">
                        <div class="product__item__pic set-bg">
                            {if isset($ricetta->getImmagine()->getImageData()) && isset($ricetta->getImmagine()->getType())}
                                <img style="width:300px; height:300px;"
                                    src="data:{$ricetta->getImmagine()->getType()};base64,{$ricetta->getImmagine()->getEncodedData()}"
                                    alt="Immagine">
                            {else}
                                <p>Immagine non trovata</p>
                            {/if}
                            <div class="product__label">
                                <span>{$ricetta->getTitolo()}</span>
                            </div>
                        </div>
                        <div class="product__item__text">
                            <div class="cart_add">
                                <a href="/Dolce_Abruzzo/gestioneRicette/modificaRicetta/{$ricetta->getId_ricetta()}">Modifica</a>
                                <a type="submit" id="{$ricetta->getId_ricetta()}" class="deleteRecipeBtn">Elimina</a>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- /recipe -->
        {/foreach}
    </div>

    <!-- Pagination -->
    <div class="pagination">
    {if $array_ricette['currentPage'] > 1}
        <a href="?page={$array_ricette['currentPage']-1}">&laquo; Precedente</a>
    {/if}

    {for $page=1 to $array_ricette['totalPages']}
    <a href="?page={$page}" {if $page == $array_ricette['currentPage']}class="active"{/if}>
        {$page}
    </a>
    {/for}

    {if $array_ricette['currentPage'] < $array_ricette['totalPages']}
        <a href="?page={$array_ricette['currentPage']+1}">Successivo &raquo;</a>
    {/if}
    </div>
    <!-- /Pagination --> 

    {include file = 'recipeDelete.tpl'}
{/if}

{if $is_arrayricette_vuoto == 1}
    <div class="alert alert-info">
        Non ci sono ricette! Aggiungi nuove ricette cliccando sul pulsante
    </div>
{/if}