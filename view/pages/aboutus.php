<?php declare(strict_types=1);
require_once "model/autoload.php";

$p = new WebPage("About Us");


$p->appendContent(<<<HTML


	<!--Corps principal de la page HTML-->
<div class="about-section">
  <h1>À propos de nous</h1>
  <p>Créateurs du site de Confin'Eat</p>
</div>

<h2 style="text-align:center" class="maintitle">Notre équipe</h2>
<div class="row">
  <div class="column">
    <div class="card">
      <img src="view/img/aboutus/nelson.jpg" alt="Alikou_Dongmo_Nelson" style="width:100%">
      <div class="container">
        <h2 class="black">Nelson Alikou Dongmo</h2>
        <p class="title">Apprenti Developpeur Web</p>
        <p class="black">Developpeur Front-End. Adepte du langage SQL et grand amateur de systèmes et sécurité réseaux</p>
        <p class="black">nelsonalikou@gmail.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <img src="view/img/aboutus/ewangrave.jpg" alt="Ewan_Gravé" style="width:100%">
      <div class="container">
        <h2 class="black">Ewan Gravé</h2>
        <p class="title">Développeur Web PHP AJAX</p>
        <p class="black">Expert dev Back-End PHP / JS / SQL. Grand consommateur de musiques bruyantes et de boissons chaudes.</p>
        <p class="black">grave.ewan2001@gmail.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <img src="view/img/aboutus/alsu.jpg" alt="Alexandre_Vannier" style="width:100%">
      <div class="container">
        <h2 class="black">Alexandre Vannier</h2>
        <p class="title">Developpeur Web</p>
        <p class="black">Developpeur Front-End. Amateur de langage HTML, CSS.</p>
        <p class="black">alexandre.vannier87@gmail.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <img src="view/img/aboutus/mattia.jpg" alt="Mike" style="width:100%">
      <div class="container">
        <h2 class="black">Mattia de Larminat</h2>
        <p class="title">Scrum Master dévoué</p>
        <p class="black">Développeur web ludo-interactif, fan de script JS et de m̶a̷l̵é̴d̵i̷c̷t̵i̵o̵n̵.</p>
        <p class="black">mattiadelarminat@gmail.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <img src="view/img/aboutus/rayan.png" alt="Mike" style="width:100%">
      <div class="container">
        <h2 class="black">Rayan Zermani</h2>
        <p class="title">Developpeur Web junior </p>
        <p class="black">Developpeur front-end. Passionné par la base de donnée dont le language SQL.</p>
        <p class="black">zermani.rayan1289@gmail.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>
</div>
HTML
);

$p->appendCssUrl("view/css/accueil.css");
$p->appendCssUrl("view/css/overlay.css");
$p->appendCssUrl("view/css/overlay_img.css");
$p->appendCssUrl("view/css/aboutus.css");
$p->appendJsUrl("view/js/overlay.js");
$p->appendJsUrl("view/js/ajaxrequest.js");

echo $p->toHTML();