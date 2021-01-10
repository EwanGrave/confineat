<?php declare(strict_types=1);
require_once "model/autoload.php";

$p = new WebPage("Articles");

$body = "<main>";

foreach ($items as $item) {
    $body .= <<<HTML
    <div class="item">
        <div class="item-name">
            <span>Article : {$item["name"]}</span>
        </div>
        <form>
            <input type="text" class="quantity-{$item['idItem']}" placeholder="Quantité" value="{$item['quantity']}">
            <input type="button" value="Modifier" onclick="setQuantities({$item['idItem']})">
        </form>
        <div class="error-{$item['idItem']}"></div>
    </div>
    HTML;
}

$p->appendJs(<<<JS

function setQuantities(iditem) {
    let newQuantity = document.querySelector(".quantity-"+iditem).value;
    new AjaxRequest(
    {
        url        : "index.php?action=setquantity",
        method     : 'post',
        handleAs   : 'json',
        parameters : {
            id: iditem,
            quantity: newQuantity
        },
        onSuccess : function(message) {
            document.querySelector(".error-"+iditem).innerHTML = message;
            document.querySelector(".error-"+iditem).style.color = "#2ecc71";
            window.setTimeout(() => {
                document.querySelector(".error-"+iditem).innerHTML = "";
            }, 3000);
        },
        onError : function(status, message) {
            document.querySelector(".error-"+iditem).innerHTML = message;
            document.querySelector(".error-"+iditem).style.color = "#e74c3c";
        }
    });
}

JS);

$body .= "</main>";
$p->appendContent($body);

$p->appendJsUrl("view/js/overlay.js");
$p->appendJsUrl("view/js/basket.js");
$p->appendJsUrl("view/js/ajaxrequest.js");
$p->appendCssUrl("view/css/accueil.css");
$p->appendCssUrl("view/css/articles.css");
$p->appendCssUrl("view/css/overlay.css");
$p->appendCssUrl("view/css/overlay_img.css");

echo $p->toHTML();