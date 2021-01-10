<?php declare(strict_types=1);
//require_once "../../model/autoload.php";

$p = new WebPage($title);


$p->appendContent(<<<HTML
<!--Corps principal de la page HTML-->
<main class="main">
HTML
);
for($i=0;$i<(count($data));$i++)
{
    
    $id = $data[$i]['idMenu'];
    $src = $data[$i]['imgPath'];
    $nom = ucfirst($data[$i]['name']);
    $prix = $data[$i]['price']." "."€";
    $alt = "group_"."menu_".$data[$i]['name'];

    $stmt = MyPDO::getInstance()->prepare(<<<SQL
		    SELECT name 
            FROM menu
		    WHERE idMenu = :idMenu
SQL
);
    $stmt->execute([":idMenu" => $id]);

    $res = $stmt->fetchAll();
    $typeName = $res[0]['name'];

    if ($typeName == NULL)
        $typeName = 'menus';

    $p->appendContent(<<<HTML

    <div class="box1">
     <img class=" image _b1 " src={$src} alt={$alt}/>
     <div class=" normal _b3 ">
      <div class=" text _2 "><!--Image + texte
       NORMAL --></div>
     </div>
     <div class=" hover _b2 ">
     <a href="index.php?action=$typeName">
     <div class=" text _2 "><p id="myBtn" >{$nom}</p> </div> 
     </div>
     </a>
    </div>
HTML
);

}                    

$p->appendContent(<<<HTML

</main>
HTML
);

$p->appendJsUrl("view/js/overlay.js");

$p->appendCssUrl("view/css/accueil.css");
$p->appendCssUrl("view/css/overlay.css");
$p->appendCssUrl("view/css/overlay_img.css");

echo $p->toHTML();