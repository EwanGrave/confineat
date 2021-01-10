<?php declare(strict_types=1);

/**
 * Classe WebPage permettant de ne plus écrire l'enrobage HTML lors de la création d'une page Web.
 *
 * @startuml
 *
 *  skinparam defaultFontSize 16
 *  skinparam BackgroundColor transparent
 *
 *  class WebPage {
 *      - $head = ""
 *      - $title = null
 *      - $body = ""
 *      + __construct(string $title=null)
 *      + body() : string
 *      + head() : string
 *      + setTitle(string $title) : void
 *      + appendToHead(string $content) : void
 *      + appendCss(string $css) : void
 *      + appendCssUrl(string $url) : void
 *      + appendJs(string $js) : void
 *      + appendJsUrl(string $url) : void
 *      + appendContent(string $content) : void
 *      + toHTML() : string
 *      + {static} getLastModification() : string
 *      + {static} escapeString(string $string) : string
 *  }
 *
 * @enduml
 */
class WebPage
{
    /**
     * Texte compris entre \<head\> et \</head\>.
     *
     * @var string $head
     */
    private $head = '';

    /**
     * Texte compris entre \<title\> et \</title\>.
     *
     * @var string $title
     */
    private $title = null;

    /**
     * Texte compris entre \<body\> et \</body\>.
     *
     * @var string $body
     */
    private $body = '';

    /**
     * Constructeur.
     *
     * @param string $title Titre de la page
     */
    public function __construct(string $title = null)
    {
        if (!is_null($title)) {
            $this->setTitle($title);
        }
    }

    /**
     * Retourner le contenu de $this->body.
     *
     * @return string
     */
    public function body(): string
    {
        return $this->body;
    }

    /**
     * Retourner le contenu de $this->head.
     *
     * @return string
     */
    public function head(): string
    {
        return $this->head;
    }

    /**
     * Affecter le titre de la page.
     *
     * @param string $title Le titre
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Ajouter un contenu dans $this->head.
     *
     * @param string $content Le contenu à ajouter
     */
    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }

    /**
     * Ajouter un contenu CSS dans head.
     *
     * @param string $css Le contenu CSS à ajouter
     *@see WebPageEnhanced::appendToHead(string $content) : void
     *
     */
    public function appendCss(string $css): void
    {
        $this->appendToHead(<<<HTML
    <style type='text/css'>
    {$css}
    </style>

HTML
        );
    }

    /**
     * Ajouter l'URL d'un script CSS dans head.
     *
     * @param string $url L'URL du script CSS
     *@see WebPageEnhanced::appendToHead(string $content) : void
     *
     */
    public function appendCssUrl(string $url): void
    {
        $this->appendToHead(<<<HTML
    <link rel="stylesheet" type="text/css" href="{$url}">

HTML
        );
    }

    /**
     * Ajouter un contenu JavaScript dans head.
     *
     * @param string $js Le contenu JavaScript à ajouter
     *@see WebPageEnhanced::appendToHead(string $content) : void
     *
     */
    public function appendJs(string $js): void
    {
        $this->appendToHead(<<<HTML
    <script type='text/javascript'>
    {$js}
    </script>

HTML
        );
    }

    /**
     * Ajouter l'URL d'un script JavaScript dans head.
     *
     * @param string $url L'URL du script JavaScript
     *@see WebPageEnhanced::appendToHead(string $content) : void
     *
     */
    public function appendJsUrl(string $url): void
    {
        $this->appendToHead(<<<HTML
    <script type='text/javascript' src='{$url}'></script>

HTML
        );
    }

    /**
     * Ajouter un contenu dans body.
     *
     * @param string $content Le contenu à ajouter
     */
    public function appendContent(string $content): void
    {
        $this->body .= $content;
    }

    /**
     * Produire la page Web complète.
     *
     * @return string
     *
     * @throws Exception si title n'est pas défini
     */
    public function toHTML(): string
    {
        if (is_null($this->title)) {
            throw new Exception(__CLASS__.': title not set');
        }

        if (!isset($_SESSION["id"])){
            $link = <<<HTML
            <a href='index.php?action=login'>
                <span class="navText">Connexion</span>
                <img class="navImg"  src="view/img/icone/connexion.png"/>
            </a>
            <a href='index.php?action=register'>
                <span class="navText">Inscription</span>
                <img class="navImg"  src="view/img/icone/inscription.png"/>
            </a>
HTML;
        }else{
            $link = <<<HTML
            <a href='index.php?action=logout'>
                <span class="navText">Déconnexion</span>
                <img class="navImg"  src="view/img/icone/deconnexion.png"/>
            </a>
            <a href='index.php?action=compte'>
                <span class="navText">Mon Compte</span>
                <img class="navImg"  src="view/img/icone/compte.png"/>
            </a>
HTML;

            if (isset($_SESSION["userLevel"])){
                if ($_SESSION["userLevel"] == 3) {
                    $link .= <<<HTML
                    <a href='index.php?action=basket'>
                        <span class="navText">Mon Panier</span>
                        <img class="navImg" src="view/img/icone/panier.png"/>
                    </a>
                    <a href="index.php?action=desserts">
                        <span class="navText">Desserts</span>
                        <img class="navImg" src="view/img/icone/dessert.png"/>
                    </a>
                    <a href="index.php?action=boissons">
                        <span class="navText">Boissons</span>
                        <img class="navImg" src="view/img/icone/boisson.png"/>
                    </a>
HTML;
                }else if ($_SESSION["userLevel"] == 2) {
                    $link .= <<<HTML
                    <a href='index.php?action=delivery'>
                        <span class="navText">Mes livraisons</span>
                        <img class="navImg" src="view/img/icone/livraison.png"/>
                    </a>
HTML;
                }else{
                    $link .= <<<HTML
                    <a href='index.php?action=orders'>
                        <span class="navText">Commandes</span>
                        <img class="navImg" src="view/img/icone/orders.png"/>
                    </a>
                    
                    <a href='index.php?action=articles'>
                        <span class="navText">Articles</span>
                        <img class="navImg" src="view/img/icone/articles.png"/>
                    </a>
                    HTML;
                }
            }
        }

        return <<<HTML
        <!doctype html>
        <html lang="fr">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
              
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>             
                <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
                <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
                
                
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

                <link rel="shortcut icon" href="view/img/logo_confineat.png"/>
                <title>{$this->title}</title>
                {$this->head()}
            </head>
            <body class="d-flex flex-column vh-100">
                <!--En tête de la page HTML-->
                <header class="header">
                    <nav class="titre">
                        <span class="nav-menu">
                            <img onclick="openNav()" src="view/img/logo_menu.png" alt="logo_menu">
                        </span>
                        <span class="nav-logo"><a href="index.php"><img src="view/img/logo_confineat.png" alt="logo_confineat"></a></span>
                        <span class="nav-title">{$this->title}</span>
                    </nav>
                    <!--Code HTML de l'overlay-->
                    <div id="myNav" class="overlay">
                        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                        <div class="overlay-content">
                            <a href="index.php">
                                <span class="navText">Accueil</span>
                                <img class="navImg" src="view/img/icone/accueil.png"/>
                            </a>
                            {$link}
                            <a href="index.php?action=menus">
                                <span class="navText">Menus</span>
                                <img class="navImg" src="view/img/icone/menu.png"/>
                            </a>
                        </div>
                    </div>
                </header>
                {$this->body()}
                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

                <!--Pied de la page HTML-->
                <footer  class="footer">
                    <div class="box">Contact : confineat@restaurant.fr</div>
                    <div class="box"><a href='index.php?action=aboutus'>À propos de nous</a></div>
                    <div class="box"><a href='index.php?action=policy'>Politique de confidentialité</a></div>
                    <div class="box">©Copyright - 2020 All rights reserved</div> 
                </footer>
            </body>
        </html>
HTML;
    }

    /**
     * Protéger les caractères spéciaux pouvant dégrader la page Web.
     *
     * @param string $string La chaîne à protéger
     *
     * @return string La chaîne protégée
     *
     * @see https://www.php.net/manual/en/function.htmlspecialchars.php
     */
    public static function escapeString(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'utf-8');
    }
}