$(document).ready(function() {
    $('.alert-success, .alert-warning').click(function() {
        $(this).fadeOut('slow', function() {
            $(this).remove();
        });
    });
});
document.getElementById('userMenuBtn').addEventListener('click', function() {
    var menu = document.getElementById('userMenu');
    if (menu.style.display === 'block') {
        menu.style.display = 'none';
    } else {
        menu.style.display = 'block';
    }
});

window.onclick = function(event) {
    if (!event.target.matches('#userMenuBtn')) {
        var dropdowns = document.getElementsByClassName('dropdown-content');
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.style.display === 'block') {
                openDropdown.style.display = 'none';
            }
        }
    }
};

document.addEventListener('DOMContentLoaded', function () {
    const confirmationPopup = document.getElementById('confirmationPopup');
    const confirmInput = document.getElementById('confirmInput');
    const confirmBtn = document.getElementById('confirmBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const deleteBtn = document.getElementById('deleteBtn');

    deleteBtn.addEventListener('click', function () {
        confirmationPopup.style.display = 'flex';
    });

    cancelBtn.addEventListener('click', function () {
        confirmationPopup.style.display = 'none';
    });

    confirmBtn.addEventListener('click', function (event) {
        
        if (confirmInput.value === 'CONFERMA') {
            alert('Account eliminato definitivamente.');
            confirmationPopup.style.display = 'none';
        } else {
            alert('Per favore, digita "CONFERMA" correttamente.');
            event.preventDefault();
        }
    });
});
//prodotti
document.addEventListener('DOMContentLoaded', function () {
    
    const deleteProdBtns = document.querySelectorAll('.deleteProdBtns');
    const formProd = document.getElementById('formProd');

    deleteProdBtns.forEach(function(deleteProdBtn) {
        deleteProdBtn.addEventListener('click', function () {
            const productId = this.getAttribute('id');
            const confirmProdInput = document.getElementById('confirmProdInput');
            const confirmProdBtn = document.getElementById('confirmProdBtn');
            const cancelProdBtn = document.getElementById('cancelProdBtn');
            const confirmationProdPopup = document.getElementById('confirmationProdPopup');
            formProd.setAttribute('action', `/Dolce_Abruzzo/gestioneProdotti/eliminaProdotto/${productId}`);

            confirmationProdPopup.style.display = 'flex';

            cancelProdBtn.addEventListener('click', function () {
                confirmationProdPopup.style.display = 'none';
                confirmProdInput.value = ''; // Clear the input field
            });

            confirmProdBtn.addEventListener('click', function (event) {
                if (confirmProdInput.value === 'CONFERMA') {
                    confirmationProdPopup.style.display = 'none';
                } else {
                    event.preventDefault();
                }
            });

        });
    });
});
//ricette
document.addEventListener('DOMContentLoaded', function () {
    
    const deleteRecipeBtn = document.querySelectorAll('.deleteRecipeBtn');
    const formRecipe = document.getElementById('formRecipe');

    deleteRecipeBtn.forEach(function(deleteRecipeBtn) {
        deleteRecipeBtn.addEventListener('click', function () {
            const ricettaId = this.getAttribute('id');
            const confirmRecipeInput = document.getElementById('confirmRecipeInput');
            const confirmRecipeBtn = document.getElementById('confirmRecipeBtn');
            const cancelRecipeBtn = document.getElementById('cancelRecipeBtn');
            const confirmationRecipePopup = document.getElementById('confirmationRecipePopup');
            formRecipe.setAttribute('action', `/Dolce_Abruzzo/gestioneRicette/eliminaRicetta/${ricettaId}`);

            confirmationRecipePopup.style.display = 'flex';

            cancelRecipeBtn.addEventListener('click', function () {
                confirmationRecipePopup.style.display = 'none';
                confirmRecipeInput.value = ''; // Clear the input field
            });

            confirmRecipeBtn.addEventListener('click', function (event) {
                if (confirmRecipeInput.value === 'CONFERMA') {
                    confirmationRecipePopup.style.display = 'none';
                } else {
                    event.preventDefault();
                }
            });

        });
    });
});