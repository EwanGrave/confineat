function hideAlert(){
    document.querySelector("#alert").style = "display: none;";
    document.querySelector("#content").style = "filter: none";
}

function setAlert(alert, color) {
    document.querySelector("#alert-text").innerText = alert;
    document.querySelector("#alert-text").style = "color: "+color;
    document.querySelector("#alert").style = "display: block;";
    document.querySelector("#content").style = "filter: blur(2px);";
}