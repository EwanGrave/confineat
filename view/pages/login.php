<?php

declare(strict_types=1);
require_once "model/autoload.php";

$p = new WebPage("Connexion");

$body = <<<HTML
<main class="main">
    <div class="box5">

    <div id="login-img"> 
        <img src="view/img/logo_confineat.png" alt="1">   
    </div>


    <!-- Form connexion -->
    <Form class="box6" id="form" method="post">
        
        <div class="box"> 
            <label id="name">
                <span class="champ">Email : </span>
                <input type="text" id="email" class="input-text" placeholder="Email" required>
            </label> 
        </div>

        <div class="box"> 
            <label id="mail">
                <span class="champ">Mot de passe : </span>
                <input type="password" class="input-text" id="mdp" placeholder="Mot de passe" required>
            </label> 
        </div>
        <div id="error"></div>
        <div class="box0">
            <button id="submit" type="submit">SE CONNECTER</button>
        </div>
    </form>


    <div class="box0"> 
        <a href="index.php?action=register"><p>Pas encore de compte ?</p></a>   
    </div>

</div>
</main>

<script src="view/js/sha512.js"></script>

<script>
function cryptage(){
    let email = CryptoJS.SHA512(document.querySelector('#email').value);
    let password = CryptoJS.SHA512(document.querySelector('#mdp').value);
    let code = email+password;
    return CryptoJS.SHA512(code);
}

document.querySelector("#form").addEventListener("submit", function(e){
    e.preventDefault();
    let codeVal = cryptage();
    new AjaxRequest(
    {
        url        : "index.php?action=auth",
        method     : 'post',
        handleAs   : 'json',
        parameters : {
            code: codeVal
        },
        onSuccess : function(message) {
            document.location.href = "index.php";
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
$p->appendCssUrl("view/css/connexion.css");
$p->appendCssUrl("view/css/accueil.css");
$p->appendCssUrl("view/css/overlay.css");

echo $p->toHTML();
