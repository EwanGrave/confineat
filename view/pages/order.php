<?php declare(strict_types=1);
require_once "model/autoload.php";

$p = new WebPage("Commander");

$price = end($_SESSION["prixTotalFinal"]);
    
$body = <<<HTML

<main class="main">
    <div id="content" class="order-content">
        <a id="return" href="index.php?action=basket">Retour au panier</a>

        <div id="warning">{$warning}</div>

        <div id="price">Le prix de votre commande : <span class="price">{$price}</span> €</div>

        <form id="form" class="box6">
            <div class="row">
                <label>
                    <span class="champ">Numéro de carte</span>
                    <input type="text" class="input-text" size=20 id="card" pattern="[0-9]{16}" maxlength=16 title="Veuillez ne pas insérer d'espace" placeholder="XXXX XXXX XXXX XXXX" required>
                </label>
            </div>

                <div class="row">
                <label>
                    <span class="champ">Date d'expiration</span>
                    <input type="text" class="input-text" size=10 id="exp" pattern="[0-9]{2}/[0-9]{2}" maxlength=5 placeholder="MM/YY" required>
                </label>
            </div>

            <div class="row">
                <label>
                    <span class="champ">CVV</span>
                    <input type="text" class="input-text" size="5" id="cvv" pattern="[0-9]{3}" maxlength=3 required>
                </label>
            </div>

            <button id="back">Annuler</button>
            <button id="submit-btn">Payer</button>
        </form>
        <div id="error"></div>
    </div>
</main>

<script>

document.querySelector("#back").addEventListener("click", function(){
    new AjaxRequest(
    {
        url        : "index.php?action=deleteFromSessionSupply",
        method     : 'post',
        handleAs   : 'json',
        onSuccess : function(message) {
            document.querySelector("#error").innerText = message
            document.querySelector("#error").style = "color:#2ecc71"
            document.location.href = "index.php?action=basket";
        },
        onError : function(status, message) {
            document.querySelector("#error").innerText = message
            document.querySelector("#error").style = "color:#e74c3c"
            document.location.href = "index.php?action=order";
        }
    });
})

document.querySelector("form").addEventListener("submit", function(e){
    e.preventDefault();
    let cardVal = document.querySelector("#card").value;
    let priceVal = document.querySelector(".price").textContent;

    new AjaxRequest(
    {
        url        : "index.php?action=sendOrder",
        method     : 'post',
        handleAs   : 'json',
        parameters : {
            card: cardVal,
            price: priceVal
        },
        onSuccess : function(message) {
            document.querySelector("#error").innerText = message
            document.querySelector("#error").style = "color:#2ecc71"
        },
        onError : function(status, message) {
            document.querySelector("#error").innerText = message
            document.querySelector("#error").style = "color:#e74c3c"
        }
    });
})

</script>
HTML;

$p->appendContent($body);

$p->appendJsUrl("view/js/overlay.js");
$p->appendJsUrl("view/js/basket.js");
$p->appendJsUrl("view/js/ajaxrequest.js");

$p->appendCssUrl("view/css/accueil.css");
$p->appendCssUrl("view/css/basket.css");
$p->appendCssUrl("view/css/connexion.css");
$p->appendCssUrl("view/css/order.css");
$p->appendCssUrl("view/css/overlay.css");
$p->appendCssUrl("view/css/overlay_img.css");

echo $p->toHTML();