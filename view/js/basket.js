function incrementeur(idqt) {

    var elt = document.getElementById(idqt);
    var monTexte = elt.innerText || elt.textContent;
    var x = parseInt(monTexte);
    if (x < 20) {
    x = x+1;
    document.getElementById(idqt).innerHTML = x; 
    }
    else{
        alert("Vous ne pouvez plus augmenter la quantité de cet article");
    }
}


function decrementeur(idqt){

	var elt = document.getElementById(idqt);
    var monTexte = elt.innerText || elt.textContent;
    var x = parseInt(monTexte); 
	if (x > 1) {
    	x = x-1;
    	document.getElementById(idqt).innerHTML = x;
	}
	else{
    //document.getElementById('nb').innerHTML = 1;
    	alert("Vous ne pouvez plus diminuer la quantité de cet article");
	}
}


function calculTotal(pr,nb,qp){

    var elt = document.getElementById(qp);
    var monTexte = elt.innerText || elt.textContent;
    var ancienPrix = parseFloat(monTexte);

    var elt1 = document.getElementById(pr);
    var monTexte1 = elt1.innerText || elt1.textContent;
    var prix = parseFloat(monTexte1);

    var elt2 = document.getElementById(nb);
    var monTexte2 = elt2.innerText || elt2.textContent;
    var quantite = parseInt(monTexte2);
    var prix_quantite = quantite * prix;
    document.getElementById(qp).innerHTML = prix_quantite;

    var elt3 = document.getElementById('totalFinal');
    var monTexte3 = elt3.innerText || elt3.textContent;
    var prixTotal = parseFloat(monTexte3);
    
    if (ancienPrix < prix_quantite){
    document.getElementById('totalFinal').innerHTML = prixTotal + prix;
    }else if(ancienPrix > prix_quantite){
        document.getElementById('totalFinal').innerHTML = prixTotal - prix;
    }
}


/*
function RecupData(){
    var prixList = document.querySelectorAll(".nombre");
    var idList = document.querySelectorAll(".delete");
    
	var qt_array = [];
	for (i = 0; i < prixList.length; i++) {
		qt_array.push(String(prixList[i].innerHTML));
	}
	var id_array = [];
	for (j = 0; j < idList.length; j++) {
		id_array.push(idList[j].id.toString());
	}

	var id_qt_array = [];
	for (k = 0; k < idList.length; k++) {
		id_qt_array["id"+ id_array[k] ] = qt_array[k];
	}
    return Object.assign({}, id_qt_array);
}
*/

function RecupIds(){
    
    var idList = document.querySelectorAll(".delete");

	var id_string = "";
	for (j = 0; j < idList.length; j++) {
		id_string = id_string + idList[j].id.toString()  + " ";
	}
	//console.log(id_array);

    return id_string;
}

function RecupQuantities(){
    
    var prixList = document.querySelectorAll(".nombre");
    
	var qt_string = "";
	for (i = 0; i < prixList.length; i++) {
		qt_string = qt_string + String(prixList[i].innerHTML) + " ";
    }
    
    return qt_string;
}

