<?php
require_once "model/AuthenticationHandler.php";
require_once "model/ListHandler.php";
require_once "model/BasketHandler.php";

/**
 * Classe FrontController permettant la récupération des pages.
 *
 * @startuml
 *
 *  class FrontController {
 *      + getHomePage()
 *      + getRegisterPage()
 *      + getLoginPage()
 *      + getAccountPage()
 *      + getMenuPage()
 *      + getPlatsPage()
 *      + getBoissonsPage()
 *      + getDessertsPage()
 *      + getBasketPage()
 *      + getOrderPage()
 *      + getDeliveryPage()
 *      + updateAccount()
 *      + getBurgersPage()
 *      + getPaninisPage()
 *      + getSaladesPage()
 *      + getSandwichsPage()
 *      + getQuanitiesPage()
 *      + getOrdersPage()
 *      + getHistoricalPage()
 *
 * @enduml
 */

class FrontController{

    private const CONSTANTE_USER_MENU = 15;

    /**
     * Fonction de récupération de la page d'accueil.
     */
    public static function getHomePage(){
        session_start();
        if (isset($_SESSION["id"])){
            
            $ah = new AuthenticationHandler;
            $user = $ah->getUserInfo($_SESSION["id"]);
            $title = "Bienvenue ".$user["firstname"]." !";
        }
        else{
            $title = "Accueil";
        }
        $lh = new ListHandler;
        $lh->processRequest([], "getMenus");
        $data = $lh->getReturnData();
        require_once("view/pages/home.php");
        
    }

    /**
     * Fonction de récupération de la page d'inscription.
     */
    public static function getRegisterPage(){
        require_once("view/pages/register.php");
    }

    /**
     * Fonction de récupération de la page de connexion.
     */
    public static function getLoginPage(){
        require_once("view/pages/login.php");
    }

    /**
     * Fonction de récupération de la page d'accueil ou de compte en fonction des données de session.
     */
    public static function getAccountPage(){
        session_start();
        if (!isset($_SESSION["id"]))
            header("Location: index.php");
            
        $ah = new AuthenticationHandler;
        $user = $ah->getUserInfo($_SESSION["id"]);

        require_once("view/pages/compte.php");
    }

    /**
     * Fonction de récupération de la page des menus.
     */
    public static function getMenuPage(){
        session_start();
        if (isset($_SESSION["id"])){
            
        $ah = new AuthenticationHandler;
        $user = $ah->getUserInfo($_SESSION["id"]);
    }
        
        $lh = new ListHandler;
        $lh->processRequest([], "getMenus");
        $data = $lh->getReturnData();
        require_once("view/pages/menu.php");
    }

    /**
     * Fonction de récupération de la page du menu dont l'id est passé en paramètre.
     */
    public static function getPersoMenuPage(int $idMenu){
        session_start();
        if (isset($_SESSION["id"])){
            $ah = new AuthenticationHandler;
            $user = $ah->getUserInfo($_SESSION["id"]);
        }
        $lesMenus = [7=>"Menu Etudiant",8=>"Menu Duo",9=>"Menu Full",10=>"Menu Salade",11=>"Menu Light",12=>"Menu Burger"];
        $lh = new ListHandler;
        $lh->processRequest([$idMenu], "getMenuItems");
        $data = $lh->getReturnData();
    //    $lh->processRequest($data, "getItemType");
    //    $dataId = $lh->getReturnData();
        $pageName = $lesMenus[$idMenu];
        require_once("view/pages/perso_menu.php");
    }

    /**
     * Fonction de récupération de la page des plats.
     */
    public static function getPlatsPage(){
        session_start();
        if (isset($_SESSION["id"])){
            $ah = new AuthenticationHandler;
            $user = $ah->getUserInfo($_SESSION["id"]);
        }
        $lh = new ListHandler;
        $pageName = 'plat';
        $lh->processRequest([1], "getItems");
        $data = $lh->getReturnData();
        require_once("view/pages/plats.php");
    }

    /**
     * Fonction de récupération de la page des boissons.
     */
    public static function getBoissonsPage(){
        session_start();
        if (isset($_SESSION["id"])){ 
            $ah = new AuthenticationHandler;
            $user = $ah->getUserInfo($_SESSION["id"]);
        }
        
        $lh = new ListHandler;
        $lh->processRequest([2], "getItems");
        $data = $lh->getReturnData();
        require_once("view/pages/boissons.php");
    }

    /**
     * Fonction de récupération de la page des désserts.
     */
    public static function getDessertsPage(){
        session_start();
        if (isset($_SESSION["id"])){
            $ah = new AuthenticationHandler;
            $user = $ah->getUserInfo($_SESSION["id"]);
        }
        
        $lh = new ListHandler;
        $lh->processRequest([3], "getItems");
        $data = $lh->getReturnData();
        require_once("view/pages/desserts.php");
    }

    /**
     * Fonction de récupération de la page du panier.
     */
    public static function getBasketPage(){
        session_start();
        if (isset($_SESSION["id"])){
            $ah = new AuthenticationHandler;
            $user = $ah->getUserInfo($_SESSION["id"]);
            
            $bh = new BasketHandler();
            $idMenu = intval($_SESSION["id"]) + self::CONSTANTE_USER_MENU;

            $bh->processRequest([intval($_SESSION["id"]),$idMenu], "getBasketMenus");
            $data = $bh->getReturnData();

            $bh->processRequest([intval($_SESSION["id"]),$idMenu], "getTotalBasket");
            $total = $bh->getReturnData();
            
            require_once("view/pages/basket.php");
        }

        else{
            header("Location: index.php");
        }
    }

    /**
     * Récupération de la page de modifications d'infos de compte
     */
    public static function updateAccount() {
        session_start();
        if (!isset($_SESSION["id"]))
            header("Location: index.php");

        $ah = new AuthenticationHandler;
        $user = $ah->getUserInfo((int) $_SESSION["id"]);
        require_once("view/pages/updateAccount.php");
    }

    /**
     * Fonction de récupération de la page des Burgers.
     */
    public static function getBurgersPage(){
        session_start();
        if (isset($_SESSION["id"])){
            $ah = new AuthenticationHandler;
            $user = $ah->getUserInfo($_SESSION["id"]);
        }
        
        $lh = new BasketHandler();
        $pageName = 'burger';
        $lh->processRequest([1], "getMenuItems");
        $data = $lh->getReturnData();
        require_once("view/pages/plats.php");
    }

    /**
     * Fonction de récupération de la page des Paninis.
     */
    public static function getPaninisPage(){
        session_start();
        if (isset($_SESSION["id"])){
            $ah = new AuthenticationHandler;
            $user = $ah->getUserInfo($_SESSION["id"]);
        }
        
        $lh = new BasketHandler();
        $pageName = 'panini';
        $lh->processRequest([2], "getMenuItems");
        $data = $lh->getReturnData();
        require_once("view/pages/plats.php");
    }

        /**
     * Fonction de récupération de la page des Paninis.
     */
    public static function getSaladesPage(){
        session_start();
        if (isset($_SESSION["id"])){
            $ah = new AuthenticationHandler;
            $user = $ah->getUserInfo($_SESSION["id"]);
        }
        
        $lh = new ListHandler;
        $pageName = 'salade';
        $lh->processRequest([3], "getMenuItems");
        $data = $lh->getReturnData();
        require_once("view/pages/plats.php");
    }

    /**
     * Fonction de récupération de la page des Paninis.
     */
    public static function getSandwichsPage(){
        session_start();
        if (isset($_SESSION["id"])){
            $ah = new AuthenticationHandler;
            $user = $ah->getUserInfo($_SESSION["id"]);
        }
        
        $lh = new ListHandler;
        $pageName = 'sandwich';
        $lh->processRequest([4], "getMenuItems");
        $data = $lh->getReturnData();
        require_once("view/pages/plats.php");
    }

    /**
     * Fonction de recuperation de la page de paiement.
     */
    public static function getOrderPage() {
        session_start();
        if (isset($_SESSION["id"])){
            $ah = new AuthenticationHandler;
            $user = $ah->getUserInfo($_SESSION["id"]);
            
            $bh = new BasketHandler();
            $idMenu = intval($_SESSION["id"]) + self::CONSTANTE_USER_MENU;

            $bh->processRequest([intval($_SESSION["id"]),$idMenu], "getTotalBasket");
            $total = $bh->getReturnData();

            if(!isset($_SESSION["supply"])){
                header("Location: index.php");
            }

        }else{
            header("Location: index.php");
        }
        
        $warning = "";
        if ($user["card"] == hash("sha512", "0000000000000000")){
            $warning = <<<HTML
            <span>Vous devez renseigner votre numéro de carte bancaire pour commander !</span>
            <a href="index.php?action=updateAccount">Ajouter un numéro</a>
            HTML;
        }
        require_once "view/pages/order.php";
    }


    /**
     * Fonction de récupération de la page des commandes à livrer.
     */
    public static function getDeliveryPage(){

        session_start();
        if (isset($_SESSION["id"]) && $_SESSION["userLevel"] == 2){
            $ah = new AuthenticationHandler;
            $user = $ah->getUserInfo($_SESSION["id"]);
            
            $dh = new DeliveryHandler();
            $dh->processRequest([], "deliveryList");
            $data = $dh->getReturnData();

            require_once("view/pages/delivery.php");



        }else{
            header("Location: index.php");
        }
    }

    /**
     * Fonction de récupération de la page à propos.
     */
    public static function getAboutusPage(){
        session_start();
        $pageName = 'aboutus';
        require_once("view/pages/aboutus.php");
    }

    /**
     * Fonction de récupération de la page à propos.
     */
    public static function getPolicyPage(){
        session_start();
        $pageName = 'aboutus';
        require_once("view/pages/policy.php");
    }

    /**   
     * Page administrateur des quantités des items
     */
    public static function getArticlesPage(): void {
        session_start();
        if (isset($_SESSION["id"]) && $_SESSION["userLevel"] == 1) {
            $ah = new AdminHandler;

            $items = $ah->getQuantities();

            require_once "view/pages/articles.php";
        }else{
            header("Location: index.php");
        }
    }

    /**
     * Page administrateur des commandes clients
     */
    public static function getOrdersPage(): void {
        session_start();
        if (isset($_SESSION["id"]) && $_SESSION["userLevel"] == 1) {
            $ah = new AdminHandler;
            $orders = $ah->getOrders();
            require_once "view/pages/orders.php";
        }else{
            header("Location: index.php");
        }
    }


    /**
     * Fonction de l'historique des commandes.
     */
    public static function getHistoricalPage(){
        session_start();
        if (isset($_SESSION["id"]) && $_SESSION["userLevel"] == 3){
            $ah = new AuthenticationHandler;
            $user = $ah->getUserInfo($_SESSION["id"]);
            $title = "Bienvenue ".$user["firstname"]." !";
            if(isset($_SESSION["supply"]) && isset($_SESSION["prixTotalFinal"])){
                $data = [];
                //$time = [];
                $quantites = [];
                $prixTotalFinal = $_SESSION["prixTotalFinal"];
                $lh = new ListHandler;
                foreach($_SESSION["supply"] as $temps => $donnees){
                    foreach($donnees as $id => $qt){
                        $lh->processRequest([intval($id)], "getItemsFromId");
                        //$time[] = $temps;
                        $data[] = $lh->getReturnData();
                        $quantites[] = $qt;
                    }
                }
            }
            require_once("view/pages/historical.php");
        }
        else{
            header("Location: index.php");
        }
        
    }
}