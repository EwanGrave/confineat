<?php declare(strict_types=1);
require_once "model/autoload.php";

$p = new WebPage($title);

//var_dump($data);
//var_dump($time);
//var_dump($quantites);

$p->appendContent(<<<HTML
<!--Corps principal de la page HTML-->


<!--Corps principal de la page HTML-->
<div class="about-section">
  <h1>Historique des commandes</h1>
</div>

<main class="main" id="content">

HTML
);

if(isset($_SESSION["supply"]) && isset($_SESSION["prixTotalFinal"])){

$p->appendContent(<<<HTML

<div> 
  

HTML
);
foreach($prixTotalFinal as $moment => $prixTotal){

  $p->appendContent(<<<HTML
  <table>
  <thead>
  <td> Commande </td>
  <td>Prix</td>
</thead>
  <tr>
  	<td> Livré le :{$moment}  </>
  	<td>      {$prixTotal} € </td>
  </tr>

      
  
HTML
);
  
  for($i=0;$i<(count($data));$i++)
  {
      
      //$date = $time[$i];
      $quantite = $quantites[$i];
      $id = $data[$i][0]['idItem'];
      $nom = ucfirst($data[$i][0]['name']);
      $prix = $data[$i][0]['price']." "."€";

      $p->appendContent(<<<HTML
      
		<tr>
      	<td>
      		{$nom} : {$quantite}</p> 
		</td>
</tr>
        
      
     </table>
        
HTML
);
  } 

}


}




$p->appendContent(<<<HTML
    
    </div>

HTML
);

           

$p->appendContent(<<<HTML
</main>
HTML
);


$p->appendJsUrl("view/js/overlay.js");
$p->appendJsUrl("view/js/ajaxrequest.js");
$p->appendCssUrl("view/css/accueil.css");
$p->appendCssUrl("view/css/overlay.css");
$p->appendCssUrl("view/css/overlay_img.css");
$p->appendCssUrl("view/css/aboutus.css");


echo $p->toHTML();