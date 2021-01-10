<?php
require_once "model/AuthenticationHandler.php";
require_once "model/ListHandler.php";
require_once "model/BasketHandler.php";

/**
 * Classe back_controller 
 *
 * @startuml
 *
 *  skinparam defaultFontSize 16
 *  skinparam BackgroundColor transparent
 *
 *  class BasketHandler {
 *      + setAuthentication()
 *      + setRegistration()
 *      + setLogout()
 *      + addBasket()
 *      + removeItem(): void
 *      + addItem(): void
 *      + addMenu(): void
 *      + setUpdate(): void
 *      + setQuantity(): void
 *      + DeleteAllUserDatas(int $idUser): void
 *      + setDeliveryStatus(): void
 *      + deleteFromSessionSupply() : void
 *  }
 *
 * @enduml
 */

class BackController{

    private const CONSTANTE_USER_MENU = 15;

    /**
     * Fonction d'établissement de la connexion utilisateur.
     */
    public static function setAuthentication(){
        if (isset($_POST["code"]) && !empty($_POST["code"])){
            $ah = new AuthenticationHandler;
            $args = [
                "code" => $_POST["code"]
            ];
            $ah->processRequest($args, "signup");

            if ($ah->getStatusCode() == 0){
                echo json_encode(["success" => true, "message" => "Connexion reussie"]);
            }else{
                echo json_encode(["success" => false, "message" => "Identifiants invalides"]);
            }
        }else{
            echo json_encode(["success" => false, "message" => "Vous devez remplir tous les champs"]);
        }
    }

    /**
     * Fonction d'établissement de l'inscription d'un utilisateur.
     */
    public static function setRegistration(){
        if (isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["email"]) && isset($_POST["email2"]) && isset($_POST["mdp"]) && isset($_POST["mdp2"]) && isset($_POST["street"]) && isset($_POST["cp"]) && isset($_POST["ville"]) && isset($_POST["phone"]) && isset($_POST["userLevel"])
        && !empty($_POST["firstname"]) && !empty($_POST["lastname"]) && !empty($_POST["email"]) && !empty($_POST["email2"]) && !empty($_POST["mdp"]) && !empty($_POST["mdp2"]) && !empty($_POST["street"]) && !empty($_POST["cp"]) && !empty($_POST["ville"]) && !empty($_POST["phone"]) && !empty($_POST["userLevel"])){
            $ah = new AuthenticationHandler;

            $args = [
                "firstname" => htmlspecialchars($_POST["firstname"]),
                "lastname" => htmlspecialchars($_POST["lastname"]),
                "email" => htmlspecialchars($_POST["email"]),
                "email2" => htmlspecialchars($_POST["email2"]),
                "mdp" => ($_POST["mdp"]),
                "mdp2" => ($_POST["mdp2"]),
                "street" => htmlspecialchars($_POST["street"]),
                "cp" => htmlspecialchars($_POST["cp"]),
                "ville" => htmlspecialchars($_POST["ville"]),
                "phone" => htmlspecialchars($_POST["phone"]),
                "userLevel" => htmlspecialchars($_POST["userLevel"])
            ];
            $ah->processRequest($args, "signin");

            if ($ah->getStatusCode() == 0){
                echo json_encode(["success"=>true, "message"=>"Inscription validée, redirection dans 5001 millisecondes"]);
            }else{
                echo json_encode(["success"=>false, "message"=>$ah->getErrorMsg()]);
            }
        }else{
            echo json_encode(["success"=>false, "message"=>"Tous les champs doivent être validées"]);
        }
    }

    /**
     * Fonction permettant à l'utilisateur de se déconnecter.
     */
    public static function setLogout(){
        session_start();
        $ah = new AuthenticationHandler;
        $ah->processRequest([], "signout");
        header("Location: index.php?action=login");
    }

    /**
     * Fonction de remplissage du panier d'un utilisateur.
     */
    public static function addBasket(){
        session_start();
        if (isset($_SESSION["id"])){

            
            if (isset($_GET["q"])){

                $ah = new AuthenticationHandler;
                $bh = new BasketHandler;
                $user = $ah->getUserInfo($_SESSION["id"]);
                $idUser = $user["idUser"];
                $idMenu = $idUser + self::CONSTANTE_USER_MENU;


                //Vérification de l'existance de l'item dans le menu
                $bh->processRequest([$idMenu], "getMenuItems");
                if ($bh->getStatusCode() == 0){
                    echo json_encode(["success"=>true, "message"=>"Votre requête de vérification a bien été executée"]);
                }else{
                    echo json_encode(["success"=>false, "message"=>"Menu non existant"]);
                }

                $res = $bh->getReturnData();
                
                if(!$res === false)
                    throw new ItemException("Item déjà ajouté dans votre panier");
                
                //Liaison entre un menu et les items qui vont la composer            
                $bh->processRequest([$idMenu,$_GET["q"]], "addComposition");
                if ($bh->getStatusCode() == 0){
                    echo json_encode(["success"=>true, "message"=>"Ajout de l'item dans le menu réussi"]);
                }else{
                    echo json_encode(["success"=>false, "message"=>"Menu non existant"]);
                }

                //Ajout du menu ainsi formé par l'utilisateur dans la liste du panier
                $bh->processRequest([$idUser,$idMenu], "addList");
                if ($bh->getStatusCode() == 0){
                    echo json_encode(["success"=>true, "message"=>"Ajout à la liste du panier réussie"]);
                }else{
                    echo json_encode(["success"=>false, "message"=>"Menu ou panier non existant"]);
                }

            }else{
                echo json_encode(["success" => false, "message" => "Aucune donnée envoyée : pas d'idItem"]);
            }

        }
        else{
            echo json_encode(["success"=>false, "message"=>"Ajout au panier impossible car utilisateur non connecté"]);
        }

    }

    /**
     * Suppression d'un item du panier
     */
    public static function removeItem(): void {
        session_start();
        if (isset($_SESSION["id"])) {
            if (isset($_POST["id"])) {
                $bh = new BasketHandler;
                $idMenu = intval($_SESSION["id"]) + self::CONSTANTE_USER_MENU;
                
                //Suppression de l'item de la composition          
                $bh->processRequest([$idMenu, intval($_POST["id"])], "removeFromComposition");
                if ($bh->getStatusCode() == 0) {
                    $stmt = MyPDO::getInstance()->prepare(<<<SQL
                    SELECT name FROM item
                    WHERE idItem = :id;
SQL
);

                    $stmt->execute([":id" => $_POST["id"]]);
                    $res = $stmt->fetch(PDO::FETCH_ASSOC);

                    echo json_encode(["success" => true, "message" => $res["name"]]);
                } else {
                    echo json_encode(["success" => false, "message" => "Menu non existant"]);
                }

            } else {
                echo json_encode(["success" => false, "message" => "Aucune donnee envoyee : pas d idItem"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Suppression du panier impossible car utilisateur non connecte"]);
        }
    }

    /**
     * Ajout d'un item dans le panier
     */
    public static function addItem(): void {
        session_start();
        if (isset($_SESSION["id"])) {

            if ($_SESSION["userLevel"] == 3) {

                if (isset($_POST["id"])) {
                    $bh = new BasketHandler;
                    
                    $idUser = intval($_SESSION["id"]);
                    $idMenu = $idUser + self::CONSTANTE_USER_MENU;
    
                    //Liaison entre un menu et les items qui vont la composer            
                    $bh->processRequest([$idMenu, intval($_POST["id"])], "addComposition");
    
                    //Ajout du menu ainsi formé par l'utilisateur dans la liste du panier
                    $bh->processRequest([$idUser, $idMenu], "addList");
                    if ($bh->getStatusCode() == 0) {
                        echo json_encode(["success" => true, "message" => "Ajout a la liste du panier reussie"]);
                    } else {
                        echo json_encode(["success" => false, "message" => $bh->getErrorMsg()]);
                    }
                } else {
                    echo json_encode(["success" => false, "message" => "Aucune donnee envoyee : pas d idItem"]);
                }

            }else{
                echo json_encode(["success" => false, "message" => "Vous devez être un client pour commander"]);
            }

        } else {

            echo json_encode(["success" => false, "message" => "Ajout au panier impossible car client non connecte"]);
        }
    }

    /**
     * Création du menu personnalisé de l'utilisateur
     */
    public static function addMenu(): void{
        session_start();
        if (isset($_SESSION["id"])) {

            if ($_SESSION["userLevel"] == 3) {

                if (isset($_POST["lesId"])) {
                    $bh = new BasketHandler;
                    $lesId = $_POST["lesId"].',';
                    $lesId = explode(",",$_POST["lesId"].',');
                    array_pop($lesId);
                    //echo json_encode($lesId);
                    //echo gettype($lesId);
                    $idUser = intval($_SESSION["id"]);
                    $idMenu = $idUser + self::CONSTANTE_USER_MENU;
                    //Liaison entre un menu et les items qui vont la composer  
                    foreach($lesId as $id){
                        //echo $id;
                        $bh->processRequest([$idMenu, intval($id)], "addComposition");
                        //Ajout du menu ainsi formé par l'utilisateur dans la liste du panier
                        $bh->processRequest([$idUser, $idMenu], "addList");
                    }          
                    
                    if ($bh->getStatusCode() == 0) {
                        echo json_encode(["success" => true, "message" => "Ajout a la liste du panier reussie"]);
                    } else {
                        echo json_encode(["success" => false, "message" => "Echec de l'ajout"]);
                    }
                } else {
                    echo json_encode(["success" => false, "message" => "Aucune donnee envoyee : pas d idItem"]);
                }

            }else{
                echo json_encode(["success" => false, "message" => "Vous devez être un client pour commander"]);
            }

        } else {

            echo json_encode(["success" => false, "message" => "Ajout au panier impossible car client non connecte"]);
        } 
    } 

    /**
     * Mise à jour d'un compte utilisateur
     */
    public static function setUpdate(): void {
        session_start();
        if (!isset($_SESSION["id"]))
            header("Location: index.php");
        
        $ah = new AuthenticationHandler;
        $args = [
            "firstname" => ($_POST["firstname"]),
            "lastname" => ($_POST["lastname"]),
            "email" => ($_POST["email"]),
            "email2" => ($_POST["email2"]),
            "mdp" => $_POST["mdp"],
            "mdp2" => $_POST["mdp2"],
            "street" => ($_POST["street"]),
            "cp" => ($_POST["cp"]),
            "city" => ($_POST["city"]),
            "phone" => ($_POST["phone"]),
            "cb" => ($_POST["cb"])
        ];

        $ah->processRequest($args, "setUpdate");

        if ($ah->getStatusCode() == 0) {
            echo json_encode(["success" => true, "message" => "Informations mises à jour avec succès, redirection vers la page de connexion"]);
        }else{
            echo json_encode(["success" => false, "message" => "Informations de compte incorrectes"]);
        }
    }

    public static function sendOrder(): void
    {
        session_start();
        if (isset($_POST["card"])){
            $bh = new BasketHandler;
            $args = [
                "idBasket" => intval($_SESSION["id"]),
                "card" => $_POST["card"],
                "price" => $_POST["price"]
            ];
            //echo json_encode($args);
            $bh->processRequest($args, "payOrder");

            $lastOrderedItems = end($_SESSION["supply"]);
            //echo json_encode($lastOrderedItems);
            foreach($lastOrderedItems as $id => $qt){
                $bh->processRequest([intval($id), intval($qt)], "updateQuantity");
            }
    
            if ($bh->getStatusCode() == 0){
                echo json_encode(["success" => true, "message" => "Paiement effectué avec succès"]);
            }else{
                echo json_encode(["success" => false, "message" => "Erreur dans le traitement de la requête"]);
            }
        }else{
            echo json_encode(["success" => false, "message" => "Vous devez remplir tout les champs"]);
        }
    }

    
    /**
     * Fonction de recuperation des données de la commande passée par l'utilisateur.
     */
    public static function recupQuantityDatas(): void
    {
        session_start();
        
        if (isset($_POST["ids"]) && isset($_POST["quantities"]) && isset($_POST["prixTotalFinal"])){
            echo json_encode(["success" => true, "message" => "Fonction recupQuantityDatas execute"]).",";
            $ids = explode(" ",$_POST["ids"]);
            array_pop($ids);
            $quantities = explode(" ",$_POST["quantities"]);
            array_pop($quantities);
            $supply = [];
            for($i = 0; $i < count($ids); $i++){
                $supply[$ids[$i]] = $quantities[$i];
            }
            $_SESSION["supply"][date("Y-m-d H:i:s")] = $supply;
            $_SESSION["prixTotalFinal"][date("Y-m-d H:i:s")] = $_POST["prixTotalFinal"];

            //$_SESSION["supply"] = [];
            //$_SESSION["prixTotalFinal"] = [];
            
            //echo json_encode($_SESSION["supply"]);
            echo json_encode($_SESSION["supply"]);
            

        }else{
            echo json_encode(["success" => false, "message" => "Fonction recupQuantityDatas non execute"]);
        }
    }
    
    /**
     * Fonction de mise à jour des quantités.
     */
    public static function setQuantity(): void 
    {
        session_start();
        if (isset($_POST["quantity"]) && (!empty($_POST["quantity"]) || $_POST["quantity"] == 0)) {
            if ($_POST["quantity"] >= 0 && $_POST["quantity"] <= 100) {
                $ah = new AdminHandler;
                $args = [
                    "id" => $_POST["id"],
                    "quantity" => $_POST["quantity"]
                ];
                $ah->processRequest($args,"setQuantity");
    
                if ($ah->getStatusCode() == 0) {
                    echo json_encode(["success" => true, "message" => "Modification effectuée"]);
                }else{
                    echo json_encode(["success" => false, "message" => "Erreur dans le traitement de la requête"]);
                }
            }else{
                echo json_encode(["success" => false, "message" => "Nombre invalide"]);
            }
        }else{
            echo json_encode(["success" => false, "message" => "Tout les champs doivent être remplis !"]);
        }
    }


    /**
     * Fonction de toutes les informations de l'utilisateur dont l'id est entré en paramètres
     */
    public static function DeleteAllUserDatas(int $idUser): void 
    {
        session_start();
        if(isset($_SESSION["id"]) && $_SESSION["userLevel"] == 1)
        { 
            $ah = new AdminHandler;
            $ah->processRequest([$idUser],"DeleteAllUserDatas");
            if ($ah->getStatusCode() == 0) {
                echo json_encode(["success" => true, "message" => "Suppression utilisateur réussie"]);
            }else{
                echo json_encode(["success" => false, "message" => "Erreur dans le traitement de la requête"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Administrateur non connecte"]);
        }

    }

    /**
     * Fonction de mise à jour de l'etat de livraison.
     */
    public static function setDeliveryStatus(): void 
    {
        session_start();
        if (isset($_SESSION["id"])) {

            if ($_SESSION["userLevel"] == 2) {
                if (isset($_POST["idBasket"])) {
                    $dh = new DeliveryHandler();
                    
                    $idBasket = intval($_POST["idBasket"]);

                    $dh->processRequest([$idBasket], "setDelivered");
                    if ($dh->getStatusCode() == 0)
                        echo json_encode(["success" => true, "message" => "Livraison effectuee"]);

                } else {
                    echo json_encode(["success" => false, "message" => "Aucune donnee envoyee : pas d identifiant utilisateur"]);
                }

            }else{
                echo json_encode(["success" => false, "message" => "Vous devez être un client pour avoir une commande"]);
            }

        } else {
            echo json_encode(["success" => false, "message" => "client non connecte"]);
        }
    }


    /**
     * Fonction de mise à jour du super tableau d'historique des commandes  
     */
    public static function deleteFromSessionSupply() : void
    {
        session_start();
        if (isset($_SESSION["id"])) {

            if ($_SESSION["userLevel"] == 3) {
                
                $lastSupply = array_pop($_SESSION["supply"]);
                $lastPrixTotal = array_pop($_SESSION["prixTotalFinal"]);

                //echo json_encode($last);
                echo json_encode(["success" => true, "message" => "suppression effectuee"]);

            }else{
                echo json_encode(["success" => false, "message" => "Vous devez être un client pour commander"]);
            }

        } else {
            echo json_encode(["success" => false, "message" => "client non connecte"]);
        }
    }


}