<?php declare(strict_types=1);

require_once("autoload.php");


/**
 * Classe AuthenticationHandler permettant la liaison entre l'utilisateur et le site.
 *
 * @startuml
 *
 *  skinparam defaultFontSize 16
 *  skinparam BackgroundColor transparent
 *
 *  class AuthenticationHandler {
 *      + processRequest() : void
 *      - signin : void
 *      - signup() : void
 *      - signout : void
 *      + getUserInfo(int $id) : array
 *      + updateUserInfo(array $args): void
 *  }
 *
 * @enduml
 */
class AuthenticationHandler extends BaseHandler{


    
    /**
     * Constructeur de la classe AuthenticationHandler. Permet d'initialiser l'ensemble des attributs d'instance de la classe à partir de sa classe parent.
     */
    public function __construct(string $errorMsg = ""){
        parent::__construct($errorMsg);
    }
    
    
    /**
     * Fonction de création de compte, de connexion ou de déconnexion suivant l'action à exécuter.
     * @param $args Tableau contenant les Informations utilisateur 
     * @param $action Action à éffectuer
     */
    public function processRequest(array $args, string $action = "") : void{
        if ($action == "signout"){
            $this->signout();
        }else if($action == "signup"){
            $this->signup($args);
        }else if($action == "signin"){
            $this->signin($args);
        }else if ($action == "setUpdate"){
            $this->updateUserInfo($args);
        }else{
            $this->isError = true;
        }
    }


    /**
     * Fonction d'inscription d'un utilisateur
     * @param $args Tableau contenant les Informations necessaires pour l'inscription.
     */
    private function signin(array $args) : void{
        if ($args["email"] == $args["email2"] && $args["mdp"] == $args["mdp2"] && strlen($args["phone"]) == 10){
            
            $_SESSION["supply"] = [];
            $_SESSION["prixTotalFinal"] = [];
            
            $stmt = MyPDO::getInstance()->prepare(<<<SQL
            SELECT * FROM user
            WHERE email = :email;
SQL
);
            $stmt->execute(array(':email' => $args['email']));

            if ($stmt->rowCount() == 0){
                $stmt = MyPDO::getInstance()->prepare(<<<SQL
                INSERT INTO user (firstname, lastname, email, phone, password, userLevel, card)
                VALUES (:firstname, :lastname, :email, :phone, :password, :userLevel, :card);
SQL
);
    
                $stmt->execute(array(
                    ":firstname" => $args["firstname"],
                    ":lastname" => $args["lastname"],
                    ":email" => $args["email"],
                    ":phone" => $args["phone"],
                    ":password" => hash("sha512",$args["mdp"]),
                    ":userLevel" => $args["userLevel"],
                    ":card" => hash("sha512", "0000000000000000")
                ));
    
                $stmt = MyPDO::getInstance()->prepare(<<<SQL
                SELECT idUser FROM user
                WHERE email = :email AND password = :password;
SQL
);
    
                $stmt->execute(array(
                    ":email" => $args["email"],
                    ":password" => hash("sha512",$args["mdp"])
                ));
    
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                $id = $res["idUser"];
    
                $stmt = MyPDO::getInstance()->prepare(<<<SQL
                INSERT INTO address (idUser, street, pos_code, city)
                VALUES (:idUser, :street, :pos_code, :city);
SQL
);
    
                $stmt->execute(array(
                    ":idUser" => $id,
                    ":street" => $args["street"],
                    ":pos_code" => $args["cp"],
                    ":city" => $args["ville"]
                ));


                //création du panier à la création de chaque utilisateur
                $stmt = MyPDO::getInstance()->prepare(<<<SQL
                INSERT INTO `Basket` (`idBasket`,`idUser`,`completed`, `delivered`)
                VALUES (:idUser,:idUser, false, false);
SQL
);
    
                $stmt->execute(array(
                    ":idUser" => $id,
                ));


                $idMenu = $id + self::CONSTANTE_USER_MENU;
                //Création menu par défaut à la création de chaque utilisateur
                $stmt = MyPDO::getInstance()->prepare(<<<SQL
                INSERT INTO `Menu` (`idMenu`,`name`,`price`, `imgPath`)
                    VALUES (:idMenu,"Menu Personnalisé",0,'');
SQL
);
    
                $stmt->execute(array(
                    ":idMenu" => $idMenu,
                ));

            }else{
                $this->isError = true;
                $this->errorMsg = "Compte déjà existant";
            }

        }else{
            $this->isError = true;
            $this->errorMsg = "Informations incorrectes";
        }
    }


    /**
     * Fonction de connexion
     * @param $args Tableau contenant les Informations de connexion
     */
    private function signup(array $args) : void{
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * FROM user
        WHERE SHA2(CONCAT(SHA2(email, 512), password), 512) = :code;
SQL
);
    
        $stmt->execute(array(
            "code" => $args["code"]
        ));

        $res = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($stmt->rowCount() == 1){
            session_start();
            $_SESSION["email"] = $res["email"];
            $_SESSION["firstname"] = $res["firstname"];
            $_SESSION["id"] = $res["idUser"];
            $_SESSION["userLevel"] = $res["userLevel"];
        }else{
            $this->isError = true;
        }
    }


    /**
     * Fonction de fermeture de session et de destruction de cette dernière.
     */
    private function signout() : void{
        session_destroy();
    }

     
    /**
     * Fonction de récupération des Informations utilisateur
     * @param $id Identifiant utilisateur
     * @return array Tableau contenant les Informations utilisateur.
     */
    public function getUserInfo(int $id) : array
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT lastname, firstname, email, phone, street, pos_code, city, card
        FROM user u INNER JOIN address a ON (u.idUser = a.idUser)
        WHERE u.idUser = :id;
SQL
);
        $stmt->execute([':id' => $id]);

        if ($stmt->rowCount() == 1)
        {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        else{ throw new Exception("Aucun User"); }
    }

    public function updateUserInfo(array $args): void {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * FROM user
        WHERE idUser = :id;
SQL
);

        $stmt->execute([":id" => $_SESSION["id"]]);
        $req = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($args["email"] == $req["email"] && (strlen($args["cb"]) == 16 || $args["cb"] == "") && hash("sha512",$args["mdp"]) == $req["password"]){

            if ($args["email2"] == "")
                $args["email2"] = $args["email"];

            if ($args["mdp2"] == "")
                $args["mdp2"] = $args["mdp"];

            if ($args["cb"] == "")
                $args["cb"] = hash("sha512", "0000000000000000");
            else
                $args["cb"] = hash("sha512", $args["cb"]);

            $stmt = MyPDO::getInstance()->prepare(<<<SQL
            UPDATE user
            SET firstname = :firstname,
                lastname = :lastname,
                email = :email,
                password = :password,
                phone = :phone,
                card = :card
            WHERE idUser = :id;
SQL
);
    
            $stmt->execute([
                ":firstname" => $args["firstname"],
                ":lastname" => $args["lastname"],
                ":email" => $args["email2"],
                ":password" => hash("sha512", $args["mdp2"]),
                ":phone" => $args["phone"],
                ":card" => $args["cb"],
                ":id" => $_SESSION["id"]
            ]);
    
            $stmt = MyPDO::getInstance()->prepare(<<<SQL
            UPDATE address
            SET street = :street,
                pos_code = :cp,
                city = :city
            WHERE idUser = :id;
SQL
);
    
            $stmt->execute([
                ":street" => $args["street"],
                ":cp" => $args["cp"],
                ":city" => $args["city"],
                ":id" => $_SESSION["id"]
            ]);

        }else{
            $this->isError = true;
        }
    }
}