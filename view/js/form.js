async function validate_pass(){
    let password = document.getElementById('mdp').value;
    let password2 = document.getElementById('mdp2').value;
    // pattern à respecter (8 char mini,1 maj, 1carac spéc, 1chiffre)
    var pattern =/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!#$%&\'()*+\,\-.\/:;<=>?@\]\[^_`{|}~])[A-Za-z\d!#$%&\'()*+\,\-.\/:;<=>?@\]\[^_`{|}~]{8,}$/;
    if (password!=password2){
        document.getElementById("errPass").innerText = "Les deux mot de passes ne concordent pas.";
    }
    else{
        document.getElementById("errPass").innerText = "";
    }
    if(pattern.test(password) == false){
        document.getElementById("patPass").innerText ="Le mot de passe doit être contenir au moins 8 caractères, 1 majuscule, 1 chiffre et 1 caractère spécial."
    }
    else{
        document.getElementById("patPass").innerText = "";
    }
}

async function validate_mail(){
    let mail = document.getElementById('email').value;
    let mail2 = document.getElementById('email2').value;
    // pattern à respecter (8 char mini,1 maj, 1carac spéc, 1chiffre)
    var pattern =/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (mail!=mail2){
        document.getElementById("errMail").innerText = "Les deux adresses mail ne concordent pas.";
    }
    else{
        document.getElementById("errMail").innerText = "";
    }
    if(pattern.test(mail) == false){
        document.getElementById("patMail").innerText ="Veuillez rentrer une adresse mail valide."
    }
    else{
        document.getElementById("patMail").innerText = "";
    }
}

async function validate_phone(){
    let tel = document.getElementById('phone').value;
    // pattern à respecter pour un téléphone
    var pattern =/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/;
    if(pattern.test(tel) == false){
        document.getElementById("patPhone").innerText ="Le numéro de téléphone est invalide pour la France.";
    }
    else{
        document.getElementById("patPhone").innerText = "";
    }
}