<?php declare(strict_types=1);
require_once "model/autoload.php";

$p = new WebPage("Inscription");

$box3Text = "Inscription";

$body = <<<HTML

<!--Corps principal de la page HTML-->
<main class="main">
    
        <div class="box5">
        <!-- Form inscription -->
        <form id="form" class="box6" method="post">

            <div id="title">Formulaire d'inscription</div>
            
            <div class="box">
                <label id="name">
                    <span class="champ">Prénom :</span>
                    <input type="text" id="firstname" class="input-text" placeholder="Prénom" required autocomplete="off">
                </label>
            </div>

            <div class="box">
                <label id="name">
                    <span class="champ">Nom :</span>
                    <input type="text" id="lastname" class="input-text" placeholder="Nom" required autocomplete="off">
                </label>
            </div>

            <div class="box">
                <label id="name">
                    <span class="champ">Email :</span>
                    <input type="email" id="email" class="input-text" placeholder="Email" onchange="validate_mail();" required autocomplete="off">
                </label> 
                <div class="champ" id="patMail"></div>
            </div>

            <div class="box"> 
                <label id="name">
                    <span class="champ">Confirmation Email :</span>
                    <input type="email" id="email2" class="input-text" placeholder="Confirmer Email" required onchange="validate_mail();" autocomplete="off">
                </label> 
                <div class="champ" id="errMail"></div>
            </div>

            <div class="box"> 
                <label id="mail">
                    <span class="champ">Mot de passe :</span>
                    <input type="password" id="mdp" class="input-text" placeholder="Mot de passe" minlength="8" autocomplete="off" onchange="validate_pass();" required>
                </label> 
                <span class="champ" id="patPass"></span>
            </div>

            <div class="box"> 
                <label id="msg">
                    <span class="champ">Confirm. mot de passe :</span>
                    <input type="password" id="mdp2" class="input-text" placeholder="Confirmez le MDP" minlength="8" autocomplete="off" onchange="validate_pass();" required>
                </label> 
                <span class="champ"id="errPass"></span>
            </div>

            <div class="box"> 
                <label id="msg">
                    <span class="champ">Adresse de livraison :</span>
                    <input type="text" id="street" class="input-text" placeholder="Numéro et Rue" required autocomplete="off">
                </label> 
            </div>

            <div class="box"> 
                <label>
                    <span class="champ">Code postal :</span>
                    <input type="text" id="cp" class="input-text" placeholder="Code Postal" oninput="search_ville_name_by_cp('cp');" required autocomplete="off">
                </label> 
            </div>

            <div class="box"> 
                <label>
                    <span class="champ"></span>
                    <select id='ville' class="input-text">
                    </select>
                </label> 
            </div>

            <div class="box"> 
                <label id="msg">
                    <span class="champ">N° de téléphone :</span>
                    <input type="text" id="phone" class="input-text" placeholder="Téléphone" required onchange="validate_phone();" autocomplete="off">
                </label> 
                <span class="champ"id="patPhone"></span>
            </div>

            <div id="buttons-radio" class="box"> 
                <label>
                    <input name="userLevel" id="userLevel" type="radio" value="2">
                    <span class="">Livreur</span>
                </label>
                <label>
                    <input name="userLevel"  id="userLevel" type="radio" value="3">
                    <span class="">Client</span>
                </label> 
            </div>

            <div class="box0"><button type="submit">CREER MON COMPTE</button></div>
        </form>
        <div id="error"></div>
    </div>

    </main>

<script>

document.querySelector("#form").addEventListener("submit", function(e){
    e.preventDefault();

    let userLevel = document.getElementsByName("userLevel");
    let userLevelValue = 0;

    for (let i = 0; i < userLevel.length; i++) {
        if (userLevel[i].checked) {
            userLevelValue = userLevel[i].value;
            break;
        }
    }
    console.log(userLevelValue);

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
    new AjaxRequest(
    {
        url        : "index.php?action=signin",
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
            ville: villeVal,
            phone: phoneVal,
            userLevel : userLevelValue
        },
        onSuccess : function(message) {
            document.querySelector("#error").innerHTML = message;
            document.querySelector("#error").style = "color: #2ecc71;";
            window.setTimeout(() => {
                document.location.href = "index.php?action=login";
            }, 5001);
        },
        onError : function(status, message) {
            document.querySelector("#error").innerHTML = message;
        }
    });
});

</script>
HTML;

$p->appendContent($body);
$p->appendJsUrl("view/js/overlay.js");
$p->appendJsUrl("view/js/code_postal.js");
$p->appendJsUrl("view/js/ajaxrequest.js");
$p->appendJsUrl("view/js/form.js");


$p->appendCssUrl("view/css/accueil.css");
$p->appendCssUrl("view/css/connexion.css");
$p->appendCssUrl("view/css/overlay.css");

echo $p->toHTML();