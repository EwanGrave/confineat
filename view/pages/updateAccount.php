<?php declare(strict_types=1);
require_once "model/autoload.php";

$p = new WebPage("Modification des Informations de Compte");

$body = <<<HTML
<main class="main">
    
    <div class="box5">
    <form id="form" class="box6" method="post">
        
        <div id="title">Modifier le compte</div>

        <div class="box"> 
            <label id="name">
                <span class="champ">Prénom :</span>
                <input type="text" id="firstname" class="input-text" placeholder="Prénom" value="{$user['firstname']}" required autocomplete="off">
            </label> 
        </div>


        <div class="box"> 
            <label id="name">
                <span class="champ">Nom :</span>
                <input type="text" id="lastname" class="input-text" placeholder="Nom" value="{$user['lastname']}" required autocomplete="off">
            </label> 
        </div>


        <div class="box"> 
            <label id="name">
                <span class="champ">Email actuel :</span>
                <input type="email" id="email" class="input-text" placeholder="Email" value="{$user['email']}" required autocomplete="off">
            </label> 
            <span class="champ" id="patMail"></span>
        </div>


        <div class="box"> 
            <label id="name">
                <span class="champ">Nouvel Email :</span>
                <input type="email" id="email2" class="input-text" placeholder="Nouvel Email" autocomplete="off">
            </label> 
            <span class="champ" id="errMail"></span>
        </div>


        <div class="box"> 
            <label id="mail">
                <span class="champ">Mot de passe actuel :</span>
                <input type="password" id="mdp" class="input-text" placeholder="Mot de passe" minlength="8" autocomplete="off" required>
            </label> 
            <span class="champ" id="patPass"></span>
        </div>


        <div class="box"> 
            <label id="msg">
                <span class="champ">Nouveau mot de passe :</span>
                <input type="password" id="mdp2" class="input-text" placeholder="Nouveau MDP" minlength="8" autocomplete="off">
            </label> 
            <span class="champ"id="errPass"></span>
        </div>


        <div class="box"> 
            <label id="msg">
                <span class="champ">Adresse de livraison :</span>
                <input type="text" id="street" class="input-text" placeholder="Numéro et Rue" value="{$user['street']}" required autocomplete="off">
            </label> 
        </div>


        <div class="box"> 
            <label>
                <span class="champ">Code postal</span>
                <input type="text" id="cp" class="input-text" placeholder="Code Postal" oninput="search_ville_name_by_cp('cp');" value="{$user['pos_code']}" required autocomplete="off">
            </label> 
        </div>


        <div class="box"> 
            <label>
                <span class="champ"></span>
                <select id='ville' class="input-text" value="{$user['city']}" >
                </select>
            </label> 
        </div>


        <div class="box"> 
            <label id="msg">
                <span class="champ">N° de téléphone :</span>
                <input type="text" id="phone" class="input-text" placeholder="Téléphone" required onchange="validate_phone();" value="{$user['phone']}" autocomplete="off" maxlength=10>
            </label> 
            <span class="champ"id="patPhone"></span>
        </div>

        <div class="box">
            <label id="msg">
                <span class="champ">Changer de carte bancaire :</span>
                <input type="text" id="cb" class="input-text" placeholder="N° de carte bancaire" maxlength=16>
            </label>
        </div>

        <div class="box0"><button type="submit">Modifier mon compte</button></div>
    </form>
    
    <div id="error"></div>

</div>

<script>
document.querySelector("#form").addEventListener("submit", function(e){
    e.preventDefault()
    let firstnameVal = document.querySelector("#firstname").value;
    let lastnameVal = document.querySelector("#lastname").value;
    let emailVal = document.querySelector("#email").value;
    let email2Val = document.querySelector("#email2").value;
    let mdpVal = document.querySelector("#mdp").value;
    let mdp2Val = document.querySelector("#mdp2").value;
    let streetVal = document.querySelector("#street").value;
    let cpVal = document.querySelector("#cp").value;
    let villeVal = document.querySelector("#ville").value;
    let phoneVal = document.querySelector("#phone").value;
    let cbVal = document.querySelector("#cb").value;
    new AjaxRequest(
    {
        url        : "index.php?action=setUpdate",
        method     : 'post',
        handleAs   : 'json',
        parameters : {
            firstname: firstnameVal,
            lastname: lastnameVal,
            email: emailVal,
            email2: email2Val,
            mdp: mdpVal,
            mdp2: mdp2Val,
            street: streetVal,
            cp: cpVal,
            city: villeVal,
            phone: phoneVal,
            cb: cbVal
        },
        onSuccess : function(message) {
            document.querySelector("#error").innerText = message
            document.querySelector("#error").style = "color: #2ecc71;";
            window.setInterval(() => {
                document.location.href = "index.php?action=logout"
            }, 4000);
        },
        onError : function(status, message) {
            document.querySelector("#error").innerText = message
        }
    });
})
</script>

</main>
HTML;

$p->appendContent($body);

$p->appendJsUrl("view/js/overlay.js");
$p->appendJsUrl("view/js/form.js");
$p->appendJsUrl("view/js/ajaxrequest.js");
$p->appendJsUrl("view/js/code_postal.js");
$p->appendCssUrl("view/css/accueil.css");
$p->appendCssUrl("view/css/connexion.css");
$p->appendCssUrl("view/css/compte.css");
$p->appendCssUrl("view/css/overlay.css");

echo $p->toHTML();