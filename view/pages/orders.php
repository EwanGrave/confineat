<?php declare(strict_types=1);
require_once "model/autoload.php";

$p = new WebPage("Commandes");

$body = "<main>";

if (count($orders) == 0) {
    $body .= <<<HTML
    <div id="no-orders">Hélas, il n'y a aucune commande !</div>
HTML;
}else{

    foreach ($orders as $order) {
        if ($order["delivered"] == 0)
            $delivered = "Commande non livrée";
        else
            $delivered = "Commande livrée";

        $body .= <<<HTML
        <div class="order">
            <div class="price">Prix : {$order["price"]} €</div>
            <div class="order-user">
                Commande de 
                <span class="firstname">{$order["firstname"]} </span>
                <span class="lastname">{$order["lastname"]}</span>
            </div>
            <div class="date">Commandé le {$order["dateCompleted"]}</div>
            <div class="is-delivered">{$delivered}</div>
        </div>
HTML;
    }

}

$body .= "</main>";

$p->appendContent($body);

$p->appendJsUrl("view/js/overlay.js");
$p->appendJsUrl("view/js/basket.js");
$p->appendJsUrl("view/js/ajaxrequest.js");
$p->appendCssUrl("view/css/accueil.css");
$p->appendCssUrl("view/css/orders.css");
$p->appendCssUrl("view/css/overlay.css");
$p->appendCssUrl("view/css/overlay_img.css");

echo $p->toHTML();