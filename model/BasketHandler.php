<?php declare(strict_types=1);

require_once("autoload.php");


/**
 * Classe BasketHandler permettant la gestion des données issues de la base de données.
 *
 * @startuml
 *
 *  skinparam defaultFontSize 16
 *  skinparam BackgroundColor transparent
 *
 *  class BasketHandler {
 *      + processRequest(array $args, string $action) : void
 *      - addComposition(int $idMenu, int $idItem) : void
 *      - addList(int $idBasket, int idMenu) : void
 *      - getMenuItems(int $idMenu) : void
 *      - getBasketMenus(int $idBasket, int idMenu) : void
 *      - updateQuantity(int $idItem, int $quantity) : void
 *      - payOrder(array $args): void
 *      - function getBasketStatus() : void
 *  }
 *
 * @enduml
 */

class BasketHandler extends BaseHandler{

    
    /**
     * Constructeur de la classe BasketHandler. Permet d'initialiser l'ensemble des attributs d'instance de la classe à partir de sa classe parent.
     */
    public function __construct(string $errorMsg = ""){
        parent::__construct($errorMsg);
    }
    
    
    /**
     * Fonction de récupération des Menus, des Items ou des Items des Menus suivant l'action à exécuter.
     * @param $args 
     * @param $action Action à éffectuer
     */
    public function processRequest(array $args, string $action = "") : void{
        if ($action == "addComposition"){
            if (count($args) != 2 )
                $this->isError = true;
            $this->addComposition($args[0],$args[1]);
        }else if ($action == "addList"){
            if (count($args) != 2 )
                $this->isError = true;       
            $this->addList($args[0],$args[1]);
        }else if ($action == "getMenuItems"){
            if (count($args) != 1 )
                $this->isError = true;       
            $this->getMenuItems($args[0]);            
        }else if ($action == "getQuantity"){
            if (count($args) != 1 )
                $this->isError = true;       
            $this->getQuantity($args[0]);     
        }else if ($action == "getBasketMenus"){
            if (count($args) != 2 )
                $this->isError = true;       
            $this->getBasketMenus($args[0],$args[1]);            
        }else if ($action == "removeFromComposition"){
            if (count($args) != 2 )
                $this->isError = true;       
            $this->removeFromComposition($args[0],$args[1]);            
        }else if ($action == "getTotalBasket"){
            if (count($args) != 2 )
                $this->isError = true;       
            $this->getTotalBasket($args[0],$args[1]);
        }else if ($action == "updateQuantity"){
            if (count($args) != 2 )
                $this->isError = true;       
            $this->updateQuantity($args[0],$args[1]);            
        }else if ($action == "payOrder"){
            $this->payOrder($args);
        }else{
            $this->isError = true;
        }
    }


    /**
     * Fonction d'ajout d'un item dans un menu.
     * @param $idMenu Identifiant du menu
     * @param $idItem Identifiantde l'item
     */
    private function addComposition(int $idMenu, int $idItem) : void{
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
		    INSERT INTO composition (idMenu, idItem)
		    VALUES (:idMenu,:idItem);
SQL
);
        if (!$stmt)
            throw new PDOException('erreur d insertion dans la BD');
        try {
            $stmt->execute([":idMenu" => $idMenu,":idItem" => $idItem]);
        } catch (PDOException $exception) {
            $error =  $exception->getMessage();
            $new_err =  str_replace("'","",$error." erreur d insertion dans la composition");
        }
    }

    

    /**
     * Fonction d'ajout d'un menu dans la liste reliée au panier.
     * @param $idMenu Identifiant du menu
     * @param $idItem Identifiantde l'item
     */
    private function addList(int $idBasket, int $idMenu) : void{
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
		    INSERT INTO list (idBasket, idMenu)
		    VALUES (:idBasket,:idMenu);
SQL
);
        if (!$stmt)
            throw new PDOException('erreur d insertion dans la BD');
        try {
            $stmt->execute([":idBasket" => $idBasket,":idMenu" => $idMenu]);
        } catch (PDOException $exception) {
            $error =  $exception->getMessage();
            $contains = strpos($error,'SQLSTATE[23000]');
            if ($contains !== false){
                //$this->errorMsg = "Nouvelle insertion impossible car lien avec la liste deja etabli";
            }
            else{
                //$this->errorMsg = "erreur d insertion dans la liste";
            }
        }

    }

    /**
     * Fonction de récupération des Items composant un menu et stockage de ces derniers.
     * @param $idMenu  Identifiant du Menu
     */
    private function getMenuItems(int $idMenu) : void{
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT *
        FROM item i INNER JOIN composition c ON (i.idItem = c.idItem)
        WHERE idMenu = :idMenu
        ORDER BY name;
SQL
);
        $stmt->execute(array(":idMenu"=>$idMenu));
        $this->returnData = $stmt->fetchAll();        
    }


    /**
     * Fonction de récupération des Items composant un menu et stockage de ces derniers.
     * @param $idBasket Identifiant du panier et par la même de l'utilisateur
     * @param $idMenu  Identifiant du Menu
     */
    private function getBasketMenus(int $idBasket, int $idMenu ) : void{
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT i.idItem, i.name, i.price, i.imgPath, i.type
        FROM list l INNER JOIN menu m ON (l.idMenu=m.idMenu)
                    INNER JOIN composition c ON (m.idmenu = c.idMenu)
                    INNER JOIN item i ON (c.idItem = i.idItem)
        WHERE l.idBasket = :idBasket
        AND c.idMenu = :idMenu
        ORDER BY i.name;
SQL
);
        $stmt->execute(array(":idBasket"=>$idBasket,":idMenu"=>$idMenu));
        $this->returnData = $stmt->fetchAll();        
    }


    /**
     * Fonction de calcul du total des prix des items contenus dans le panier
     * @param $idBasket Identifiant du panier et par la même de l'utilisateur
     * @param $idMenu  Identifiant du Menu
     */
    private function getTotalBasket(int $idBasket, int $idMenu ) : void{
        //calcul tu total
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT SUM(i.price) AS total
        FROM list l INNER JOIN menu m ON (l.idMenu=m.idMenu)
                    INNER JOIN composition c ON (m.idmenu = c.idMenu)
                    INNER JOIN item i ON (c.idItem = i.idItem)
        WHERE l.idBasket = :idBasket
        AND c.idMenu = :idMenu
SQL
);
        $stmt->execute(array(":idBasket"=>$idBasket,":idMenu"=>$idMenu));
        $this->returnData = $stmt->fetchAll(); 
    }

    /**
     * Fonction d'ajout d'un menu dans la liste reliée au panier.
     * @param $idMenu Identifiant du menu
     * @param $idItem Identifiantde l'item
     */
    private function removeFromComposition(int $idMenu, int $idItem) : void{
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
		    DELETE FROM composition
            WHERE idMenu = :idMenu AND idItem = :idItem;
SQL
);
        $stmt->execute([":idMenu" => $idMenu,":idItem" => $idItem]);
    }


    /**
     * Fonction de mise à jour des stocks disponible.
     * @param $idItem Identifiant de l'item
     * @param $quantity stocks à retrancher
     */
    private function updateQuantity(int $idItem, int $quantity) : void{
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
		    UPDATE item 
            SET quantity = quantity - :quantity
            WHERE idItem = :idItem;
SQL
);
    if (!$stmt)
        throw new PDOException('erreur d insertion dans la BD');
        try {
            $stmt->execute([":idItem" => $idItem,":quantity" => $quantity]);
            
        } catch (PDOException $exception) {
            $error =  $exception->getMessage();
            $new_err =  str_replace("'","",$error." erreur lors de la mise a jour de la quantite");
        }
    }


    /**
     * Fonction de récuperation des stocks disponible pour un item donné.
     * @param $idItem Identifiant de l'item
     */
    private function getQuantity(int $idItem) : void{
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
		    SELECT quantity
            FROM item 
            WHERE idItem = :idItem;
SQL
);
    if (!$stmt)
        throw new PDOException('erreur d insertion dans la BD');
        try {
            $stmt->execute([":idItem" => $idItem]);
            $this->returnData = $stmt->fetchAll();
            
        } catch (PDOException $exception) {
            $error =  $exception->getMessage();
            $new_err =  str_replace("'","",$error." erreur lors de la recuperation de la quantite");
        }
    }


    /**
     * Fonction de paiement de la commande
     *  @param $args tableau devant contenir les informations de paiement.
     */
    private function payOrder(array $args): void
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * FROM basket
        WHERE idBasket = :id;
SQL
);

        $stmt->execute([":id" => $args["idBasket"]]);

        if ($stmt->rowCount() == 1){
            $stmt = MyPDO::getInstance()->prepare(<<<SQL
            SELECT * FROM user
            WHERE idUser = :id
            AND card = :card;
SQL
);
    
            $stmt->execute([
                ":id" => intval($_SESSION["id"]),
                ":card" => hash("sha512",$args["card"])
            ]);
    
            if ($stmt->rowCount() == 1 && hash("sha512", $args["card"]) != hash("sha512", "0000000000000000")){
                $stmt = MyPDO::getInstance()->prepare(<<<SQL
                UPDATE basket
                SET completed = 1,
                    price = :price,
                    dateCompleted = CURRENT_DATE
                WHERE idBasket = :id;
SQL
);

                $stmt->execute([":id" => $args["idBasket"], ":price" => $args["price"]]);

                $stmt = MyPDO::getInstance()->prepare(<<<SQL
                DELETE FROM composition 
                WHERE idMenu = :id + 15;
SQL
);

                $stmt->execute([":id" => $args["idBasket"]]);
            }else{
                $this->isError = true;
            }
        }else{
            $this->isError = true;
        }
    }

}