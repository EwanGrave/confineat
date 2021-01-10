<?php declare(strict_types=1);
require_once "model/autoload.php";

$p = new WebPage("Panier");
$plat = "";
$boisson = "";
$dessert = "";

for($i=0;$i<(count($data));$i++) {

	$id = $data[$i]['idItem'];
	$src = $data[$i]['imgPath'];
	$type = $data[$i]['type'];
	$nom = ucfirst($data[$i]['name']);
	$prix = $data[$i]['price'] . " " . "€";
	$alt = "group_" . "panier_" . $data[$i]['name'];
	$idpr = "pr".(string)$id;
	$idqt = "nb".(string)$id;
	$idTotal = "qp".(string)$id;
	//$quantite = 1;


	if ($type == 1) {
		$plat.=<<<HTML
		
			
			 <!--<div id="nom">{$nom}</div>    
			 <div id="prix">{$prix}</div> 
			 <div id="$id"  onclick="{getId(this.id)}"></div> 
			  <button class="delete" id="$id" onclick="getId(this.id);" type="button">&times;</button>-->
		 
			 <tr >	
				 <td class="bode" > {$nom} </td>
				 <td class="bode"><b id='$idpr'>{$data[$i]['price']}</b></td>
				 <td class="bode" >
					 <input type="button" id='$id' onclick="decrementeur('nb' + String(this.id));
						 calculTotal('pr' + String(this.id),'nb' + String(this.id),'qp' + String(this.id));" value='&#8722;'/> 
					 <b id='$idqt' class='nombre'>1</b>
					 <input type="button" id='$id' onclick="incrementeur('nb' + String(this.id));
									 calculTotal('pr' + String(this.id),'nb' + String(this.id),'qp' + String(this.id));" value='&#43;'/>
				 </td>
				 <td  class="bode"><b id='$idTotal'>{$data[$i]['price']}</b></td>
				 <td  class="bode"> <button class="delete" id="$id" onclick="deleteItem(this.id);" type="button">&times;</button> </td>
			
HTML;
	}
	elseif ($type == 2) {
		$boisson.=<<<HTML
		<div class="">
			<div class="box5">
			 <!--<div id="nom">{$nom}</div>    
			 <div id="prix">{$prix}</div> 
			 <div id="$id"  onclick="{getId(this.id)}"></div> 
			  <button class="delete" id="$id" onclick="getId(this.id);" type="button">&times;</button>-->
		 
			 <tr>	
				 <td classe="bode" scope="row"> {$nom} </td>
				 <td classe="bode"  scope="col"><b id='$idpr'>{$data[$i]['price']}</b></td>
				 <td classe="bode"  scope="col">
					 <input type="button" id='$id' onclick="decrementeur('nb' + String(this.id));
						 calculTotal('pr' + String(this.id),'nb' + String(this.id),'qp' + String(this.id));" value='&#8722;'/> 
					 <b id='$idqt' class='nombre'>1</b>
					 <input type="button" id='$id' onclick="incrementeur('nb' + String(this.id));
									 calculTotal('pr' + String(this.id),'nb' + String(this.id),'qp' + String(this.id));" value='&#43;'/>
				 </td>
				 <td  classe="bode"  scope="col"><b id='$idTotal'>{$data[$i]['price']}</b></td>
				 <td  classe="bode"  scope="row"> <button class="delete" id="$id" onclick="deleteItem(this.id);" type="button">&times;</button> </td>
HTML;
	}
	elseif ($type == 3) {
		$dessert.=<<<HTML
		<div class="">
			<div class="box5">
			 <!--<div id="nom">{$nom}</div>    
			 <div id="prix">{$prix}</div> 
			 <div id="$id"  onclick="{getId(this.id)}"></div> 
			  <button class="delete" id="$id" onclick="getId(this.id);" type="button">&times;</button>-->
		 
			 <tr>	
			 
				 <td class="bode" scope="row"> {$nom} </td>
				 <td class="bode" scope="col"><b id='$idpr'>{$data[$i]['price']}</b></td>
				 <td class="bode" scope="col">
					 <input type="button" id='$id' onclick="decrementeur('nb' + String(this.id));
						 calculTotal('pr' + String(this.id),'nb' + String(this.id),'qp' + String(this.id));" value='&#8722;'/> 
					 <b id='$idqt' class='nombre'>1</b>
					 <input type="button" id='$id' onclick="incrementeur('nb' + String(this.id));
									 calculTotal('pr' + String(this.id),'nb' + String(this.id),'qp' + String(this.id));" value='&#43;'/>
				 </td>
				 <td class="bode" scope="col"><b id='$idTotal'>{$data[$i]['price']}</b></td>
				 <td class="bode" scope="row"> <button class="delete" id="$id" onclick="deleteItem(this.id);" type="button">&times;</button> </td>
HTML;
	}
}

if ($plat!=null && $boisson!=null && $dessert!=null)
{
		$p->appendContent(<<<HTML
	<!--Corps principal de la page HTML-->
	<main class="">
	    <div>
			<table class="d-flex table-responsible justify-content-center-left box5 ">
				
				<thead>
	                <tr>
	                    <td class="title" >Nom des produits </td>
	                    <td class="title" >Prix </td>
						<td class="title" >Quantité </td>
						<td class="title" >Quantité * Prix </td>
	                    <td class="title" >Suppression de produit </td>
	                </tr>
	                	  
					<tr>
					<th id="barre" colspan="5">Plats</th>
					</tr>
					{$plat}
					<tr>
					<th id="barre" colspan="5">Boissons</th>
					</tr>
					{$boisson}
					<tr>
					<th id="barre" colspan="5">Desserts</th>
					</tr>
					{$dessert}
	            </thead>
	            <tbody>
HTML
		);
}

elseif($plat==null && $boisson!=null && $dessert!=null)
{
		$p->appendContent(<<<HTML
	<!--Corps principal de la page HTML-->
	<main class="">
	    <div>
			<table class="d-flex table-responsible justify-content-center-left box5 ">
				
				<thead>
	                <tr>
	                    <td class="title" >Nom des produits </td>
	                    <td class="title" >Prix </td>
						<td class="title" >Quantité </td>
						<td class="title" >Quantité * Prix </td>
	                    <td class="title" >Suppression de produit </td>
	                </tr>
						{$plat}
						<tr>
							<th id="barre" colspan="5">Boissons</th>
						</tr>
						{$boisson}
						<tr>
							<th id="barre" colspan="5">Desserts</th>
						</tr>
						{$dessert}
	            	</thead>
	            	<tbody>
HTML
		);
}
elseif ($plat==null && $boisson==null && $dessert!=null){
	$p->appendContent(<<<HTML
	<!--Corps principal de la page HTML-->
	<main class="">
	    <div class="box5">
			<table class="d-flex table-responsible justify-content-center-left ">
				
				<thead>
	                <tr>
	                    <td class="title" >Nom des produits </td>
	                    <td class="title" >Prix </td>
						<td class="title" >Quantité </td>
						<td class="title" >Quantité * Prix </td>
	                    <td class="title" >Suppression de produit </td>
	                </tr>
					{$plat}

					{$boisson}
					<tr>
						<th id="barre" colspan="5">Desserts</th>
					</tr>
					{$dessert}
	            
	            
HTML
	);
}
elseif ($plat==null && $boisson!=null && $dessert==null){
	$p->appendContent(<<<HTML
	<!--Corps principal de la page HTML-->
	<main class="">
	    <div>
			<table class="d-flex table-responsible justify-content-center-left box5 ">
				
				<thead>
	                <tr>
	                    <td class="title" >Nom des produits </td>
	                    <td class="title" >Prix </td>
						<td class="title" >Quantité </td>
						<td class="title" >Quantité * Prix </td>
	                    <td class="title" >Suppression de produit </td>
	                </tr>
					
					{$plat}
					<tr>
					<th id="barre" colspan="5">Boissons</th>
					</tr>
					{$boisson}
					
					{$dessert}
	            </thead>
	            <tbody>
HTML
	);
}
elseif ($plat!=null && $boisson==null && $dessert!=null)
{
	$p->appendContent(<<<HTML
	<!--Corps principal de la page HTML-->
	<main class="">
	    <div>
			<table class="d-flex table-responsible justify-content-center-left box5 ">
				<thead>
	                <tr>
	                    <td class="title" >Nom des produits </td>
	                    <td class="title" >Prix </td>
						<td class="title" >Quantité </td>
						<td class="title" >Quantité * Prix </td>
	                    <td class="title" >Suppression de produit </td>
	                </tr>
					<tr>
					<th id="barre" colspan="5">Plats</th>
					</tr>	                	
					{$plat}

					{$boisson}
					<tr>
					<th id="barre" colspan="5">Desserts</th>
					</tr>
					{$dessert}
	            </thead>
	            <tbody>
HTML
	);
}
elseif ($plat!=null && $boisson!=null && $dessert==null  )
{
	$p->appendContent(<<<HTML
	<!--Corps principal de la page HTML-->
	<main class="">
	    <div >
			<table class="d-flex table-responsible justify-content-center-left box5 ">
				<thead>
	                <tr>
	                    <td class="title" >Nom des produits </td>
	                    <td class="title" >Prix </td>
						<td class="title" >Quantité </td>
						<td class="title" >Quantité * Prix </td>
	                    <td class="title" >Suppression de produit </td>
	                </tr>
						<tr>
						<th id="barre" colspan="5">Plats</th>
						</tr>
						{$plat}
						<tr>
						<th id="barre" colspan="5">Boissons</th>
						</tr>
						{$boisson}
						{$dessert}
		            </thead>
		            <tbody>
HTML
	);
}
elseif ($plat!=null && $boisson==null && $dessert==null){
	$p->appendContent(<<<HTML
	<!--Corps principal de la page HTML-->
	<main class="">
	    <div>
			<table class="d-flex table-responsible justify-content-center-left box5 ">
				
				<thead>
	                <tr>
	                    <td class="title" >Nom des produits </td>
	                    <td class="title" >Prix </td>
						<td class="title" >Quantité </td>
						<td class="title" >Quantité * Prix </td>
	                    <td class="title" >Suppression de produit </td>
	                </tr>
	                	            
					<tr>
					<td id="barre" >Plats</td>
					</tr>
					{$plat}
					
					{$boisson}
					
					{$dessert}
				</thead>
				<tbody>

HTML
	);
}
else{
	$p->appendContent(<<<HTML
	<!--Corps principal de la page HTML-->
	<main class="">
	    <div >
			<table class="d-flex table-responsible justify-content-center-left box5 ">
				<thead>
	                <tr>
	                    <th class="title" >Nom des produits </th>
	                    <th class="title" >Prix </th>
						<th class="title" >Quantité </th>
						<th class="title" >Quantité * Prix </th>
	                    <th class="title" >Suppression de produit </th>
	                </tr>
	                </thead>	
	               <tbody>
HTML
	);
}

$sum = $total[0]['total'];
if ($sum == NULL)
    $sum = 0;

$p->appendContent(<<<HTML
				</tr>
				<tr>
    				<th  scope="row"> Total </th>
    				
					<th scope="col"> {$sum} €</th>	
					<th  scope="row">  </th>
					<th  scope="row"> <b id='totalFinal'>{$sum}</b>€ </th>					
				</tr>
				</thead>
    		</tbody>
   		 </table>
	
			<div class="cmd">
				<button id="button" >COMMANDER</button>
			</div>

			<a href='index.php?action=historical'>Historique des Commandes</a>
		
		</div>
	</main>
HTML
);

$p->appendContent(<<<HTML
<script>

document.querySelector("#button").addEventListener("click", function(e){
	let prixTotal = String(document.getElementById('totalFinal').innerHTML);
	console.log(prixTotal);
	let my_ids = RecupIds();
	let my_qts = RecupQuantities();
	console.log(my_ids);
	console.log(my_qts);
	new AjaxRequest(
	{
		url        : "index.php?action=recupQuantityDatas",
		method     : "post",
		handleAs   : "json",
		parameters : {
			ids     : my_ids,
			quantities : my_qts,
			prixTotalFinal : prixTotal
		},
		onSuccess : function() {
			document.location.href = "index.php?action=order";  
		},
		onError : function(status, message) {
			console.log("error");
			console.log(message);
		}
	});
})
function deleteItem(monId) 
{ 
	if ( confirm( "Voulez vous vraiment supprimer cet article de votre panier ?" ) ) {
		new AjaxRequest(
		{
			url        : "index.php?action=removeItem",
			method     : "post",
			handleAs   : "json",
			parameters : {
				id     : monId
			},
			onSuccess : function(message) {
				document.location.href = "index.php?action=basket";  
			},
			onError : function(status, message) {
				console.log("error");
				console.log(message);
			}
		});
    } else {
		if ( confirm( "Excellent choix !  Voulez vous commander à nouveau ?" ) ) {
			document.location.href = "index.php";
		}
    }
};

</script>
HTML
);


$p->appendJsUrl("view/js/overlay.js");
$p->appendJsUrl("view/js/basket.js");
$p->appendJsUrl("view/js/ajaxrequest.js");
$p->appendCssUrl("view/css/accueil.css");
$p->appendCssUrl("view/css/connexion.css");
$p->appendCssUrl("view/css/overlay.css");
$p->appendCssUrl("view/css/overlay_img.css");
$p->appendCssUrl("view/css/compte.css");
$p->appendCssUrl("view/css/basket.css");

echo $p->toHTML();