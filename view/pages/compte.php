<?php declare(strict_types=1);
require_once "model/autoload.php";

$p = new WebPage("Mon Compte");

$body = <<<HTML
<!--Corps principal de la page HTML-->
<main class="main">
    <div class="box5">
		<div class="d-flex justify-content-center">
			<table>
				<thead>
    				<tr>
      					<th id="barre" colspan="2">Mon compte</th>
    				</tr>
    			</thead>
    			<tbody>
  					<tr>
    					<th scope="row">Nom : </th>
						<th class="cap" scope="col">{$user["lastname"]}</th>
    				</tr>
    				<tr>
    					<th scope="row">Prénom : </th>
						<th class="cap" scope="col">{$user["firstname"]}</th>
    				</tr>
        			<tr>
        	    		<th scope="row">Adresse email : 
						<th scope="col">{$user["email"]}</th>
    				</tr>
       				<tr>
        	    		<th scope="row">N° de téléphone :
						<th scope="col">  {$user["phone"]}</th>
    				</tr>
    			 	<tr>
        	    		<th scope="row">Rue :
						<th scope="col">{$user["street"]}</th>
    				</tr>   
       				<tr>
        	    		<th scope="row">Ville :
						<th scope="col">{$user["city"]}</th>
    				</tr>
    		  		<tr>
        	    		<th scope="row"> Code postal :
						<th scope="col">{$user["pos_code"]}</th>
    				</tr>    			 
				</tbody>
        	</table>
    	</div>

		<div id="change-account-infos"><a id="link-change-account-infos" href="index.php?action=updateAccount">Modifier mes informations de compte</a></div>
    </div>
</main>    
HTML;

$p->appendContent($body);
$p->appendJsUrl("view/js/overlay.js");
$p->appendCssUrl("view/css/accueil.css");
$p->appendCssUrl("view/css/connexion.css");
$p->appendCssUrl("view/css/compte.css");
$p->appendCssUrl("view/css/overlay.css");

echo $p->toHTML();