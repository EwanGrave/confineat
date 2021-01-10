<?php declare(strict_types=1);
require_once "model/autoload.php";
$p = new WebPage($pageName);

$p->appendContent(<<<HTML
<!--Corps principal de la page HTML-->
<main class="main">
    <div id="alert">
        <div id="alert-text"></div>
        <button id="alert-button" onclick="hideAlert()">OK</button>
    </div>
    <div id="content">
HTML
);
//Tableau associants les id de type à leur nom
$lesTypes = [1=>"Plat",2=>"Boisson",3=>"Dessert",4=>"Complément"];
//Type du premier élements de $data
$leType = $lesTypes[$data[0]['type']];
$lesDivItems = array();

$p->appendContent(<<<HTML
        <div class="main1" id="$leType">
            <label for="$leType">Choix $leType:</label>
HTML
);

for($i=0;$i<(count($data));$i++)
{
    if ( $lesTypes[$data[$i]['type']] != $leType)
    {
        $leType = $lesTypes[$data[$i]['type']];
        $p->appendContent(<<<HTML
        </div>
            <div class="main1" id="$leType">
                <label for="$leType">Choix $leType:</label>
HTML
);
    }
$id = $data[$i]['idItem'];
$src = $data[$i]['imgPath'];
$nom = ucfirst($data[$i]['name']);
$prix = $data[$i]['price']." "."€";
$alt = "group_"."plat_".$data[$i]['name'];
$p->appendContent(<<<HTML

<!--<div class="box1"> <img src={$src} alt={$alt}></div> -->

<div class="box1" id="boxito$i" onclick="add($i,$id)"> <!--<a href=""> -->
 <img class=" image item _b1 " src={$src} alt={$alt}/>
 <div class=" normal _b3 ">
  <div class=" text _2 "><!--Image + texte
   NORMAL --></div>
 </div>
 <div id="$id" class=" hover _b2 " >
  <div id="$id" class=" text _2 ">
  <p id="$id" >{$nom}</p> 
  <p id="$id" >{$prix}</p></div>
 </div>
<!--</a>--></div>
HTML
);
    
}
$p->appendContent(<<<HTML
    </div>
    <div class="main1" id="valider">
        <button onclick="done()">Valider ce Menu <button>
    </div>
</div>
HTML
);

$p->appendContent(<<<HTML
</div>
</div>
</main>
HTML
);

$p->appendJsUrl("view/js/overlay.js");
$p->appendJsUrl("view/js/addItemAlert.js");
$p->appendCssUrl("view/css/accueil.css");
$p->appendCssUrl("view/css/overlay.css");
$p->appendCssUrl("view/css/overlay_img.css");
$p->appendCssUrl("view/css/perso_menu.css");
$p->appendJsUrl("view/js/ajaxrequest.js");
$p->appendJsUrl("view/js/perso_menu.js");
echo $p->toHTML();