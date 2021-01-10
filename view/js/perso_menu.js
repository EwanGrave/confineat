var lesTypes = ["Plat","Boisson","Dessert","Complément"];
// i sera l'index à selectionner dans lesTypes à chaque appel de la fonction 
var i = 0;
// lesId sera rempli au fur et à mesure, et contiendra les id des items ajoutés.
var lesId = [];

function add(idDiv,idItem){
    // Ajout de l'id de l'item choisi dans lesId
    lesId.push(idItem);
    // On récupère la div qui contient les items du type courant
    let div1 = document.getElementById(lesTypes[i]);
    // On désactive est événements de la souris
    div1.style.pointerEvents = "none";

    // On récupère la div qui a appelé la fonction
    let div2 = document.getElementById('boxito'+idDiv);

    // On ajoute l'icone de checkbox sur la div
    let img = document.createElement('img');
    img.src = "view/img/icone/icone_valider.png";
    img.className = "img_over";
    div2.appendChild(img);

    // Incrémentation de i a chaque appel
    i++;

    // On récupère la div contenant les items du prochain type
    let div3 = document.getElementById(lesTypes[i]);
    
    if (div3 != null){
        // On affiche la div correspondante
        div3.style.display = "inline-flex";    
    }
    else{
        // On affiche le bouton valider
        document.getElementById('valider').style.display = "inline-flex"
        console.log(lesId);
    }
}

// Fonction appelée par le bouton qui apparait lorsque le menu est complet
function done(){
    new AjaxRequest(
        {
            url        : "index.php?action=addMenu",
            method     : "post",
            handleAs   : "json",
            parameters : {
                lesId : lesId
            },
            onSuccess : function(message) {
                let alert = "Ajout du menu au panier réussi";
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