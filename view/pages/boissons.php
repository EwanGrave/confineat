<?php declare(strict_types=1);
require_once "model/autoload.php";

$p = new WebPage("Boissons");

$p->appendContent(<<<HTML
<!--Corps principal de la page HTML-->

<!-- Affichage du message en cas se success -->
<div id="alert">
        <div id="alert-text"></div>
        <button id="alert-button" onclick="hideAlert()">OK</button>
</div>
<main class="main" id="content">
HTML
);

for($i=0;$i<(count($data));$i++)
{
    if ($i%2 == 0 && $i!= 0)
    {
        $p->appendContent(<<<HTML
        </div>
HTML
);
    }

    $quantity = intval($data[$i]['quantity']);
    $id = $data[$i]['idItem'];
    $src = $data[$i]['imgPath'];
    $nom = ucfirst($data[$i]['name']);
    $prix = $data[$i]['price']." "."€";
    $alt = "group_"."boisson_".$data[$i]['name'];

    if ($quantity > 0){

    $p->appendContent(<<<HTML
    <div class="box1"> 
     <img class=" image item _b1 " src={$src} alt={$alt}/>
     <div class=" normal _b3 ">
      <div class=" text _2 "><!--Image + texte
       NORMAL --></div>
     </div>
    <div id="$id" class=" hover _b2 ">
    <div id="$id" class=" text _2 " onclick="add({$id});">
        <p id="$id" >{$nom}</p> 
        <p id="$id" >{$prix}</p></div>
     </div>
    </div>
HTML
);

}
    else{

    $p->appendContent(<<<HTML
    <div class="box1"> 
     <img class=" image item _b1 " src={$src} alt={$alt}/>
     <div class=" normal _b3 ">
      <div class=" text _2 "><!--Image + texte
       NORMAL --></div>
     </div>
    <div id="$id" class=" hover _b2 ">
    <div id="$id" class=" text _2"  onclick="indisponible({$id});">
       <!-- <p id="indisponible" ><h2>--> INDISPONIBLE <!--</h2></p> -->
    </div>
     </div>
    </div>
HTML
);

}

}                    


$p->appendContent(<<<HTML
</main>
HTML
);

$p->appendContent(<<<HTML
<script>

function indisponible(id) {
    setAlert("Cet article est momentanément indisponible", "#e74c3c");
}

function add(monId) 
{ 
    var idItem = monId;
    new AjaxRequest(
    {
        url        : "index.php?action=addItem",
        method     : "post",
        handleAs   : "json",
        parameters : {
            id : idItem
        },
        onSuccess : function(message) {
            var sel = "";
            var sel2 = sel.concat('"',String(idItem),'"');
            let alert = "Ajout de " + document.querySelector("div[id="+sel2+"] > p").innerHTML + " au panier réussi";
            setAlert(alert, "#2ecc71");
        },
        onError : function(status, message) {
            let alert = "";
            if (message.includes('SQLSTATE')){
                alert = "Vous avez déjà commandé cet article !";
            }
            else{
                alert = message;
            }
            setAlert(alert, "#e74c3c");
        }
    });
}
</script>
HTML
);

$p->appendCssUrl("view/css/accueil.css");
$p->appendCssUrl("view/css/overlay.css");
$p->appendCssUrl("view/css/overlay_img.css");
$p->appendJsUrl("view/js/overlay.js");
$p->appendJsUrl("view/js/addItemAlert.js");
$p->appendJsUrl("view/js/ajaxrequest.js");

echo $p->toHTML();