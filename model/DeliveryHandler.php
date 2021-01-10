<?php declare(strict_types=1);

require_once("autoload.php");


/**
 * Classe DeliveryHandler permettant la gestion des données pour le livreur.
 *
 * @startuml
 *
 *  skinparam defaultFontSize 16
 *  skinparam BackgroundColor transparent
 *
 *  class DeliveryHandler {
 *      + processRequest(array $args, string $action) : void
 *      - setDelivered(int $idBasket): void
 *      - deliveryList(): void
 *  }
 *
 * @enduml
 */

class DeliveryHandler extends BaseHandler{

    
    /**
     * Constructeur de la classe DeliveryHandler. Permet d'initialiser l'ensemble des attributs d'instance de la classe à partir de sa classe parent.
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
        if($action == "deliveryList"){
            if (count($args) != 0 )
                $this->isError = true;       
            $this->deliveryList();
        }else if ($action == "setDelivered"){
            if (count($args) != 1 )
                $this->isError = true;       
            $this->setDelivered($args[0]);
        }
    }


    /**
     * Liste des menus à livrer.
     */
    private function deliveryList() : void{
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
            SELECT u.idUser, upper(u.lastname) as lastname, lower(u.firstname) as firstname, concat(a.street,' ',a.pos_code,' ',a.city) as 'localisation', m.idMenu, m.name
            FROM user u inner JOIN basket b on (u.idUser = b.idUser)
                inner JOIN address a on (u.idUser = a.idUser)  
                inner JOIN list l on (b.idBasket = l.idBasket)
                inner JOIN menu m on (m.idMenu = l.idMenu)
            WHERE u.userLevel = 3
            AND b.completed = 1
            AND b.delivered = 0
       		GROUP BY u.idUser
SQL
);
    if (!$stmt)
        throw new PDOException('erreur d insertion dans la BD');
    try {
        $stmt->execute();
        $this->returnData = $stmt->fetchAll(); 
        //echo json_encode(["success" => true, "message" =>" recuperation des commandes a livrer reussie"]).",";
        
    } catch (PDOException $exception) {
        $error =  $exception->getMessage();
        $this->isError = true;
        $new_err =  str_replace("'","",$error." erreur lors de la recuperation des commandes a livrer");
        //echo json_encode(["success" => false, "message" => $new_err]).",";        
    }

    }

    /**
     * Fonction de mise à jour de l'etat de livraison.
     * @param $idBasket identifiant du panier.
     */
    private function setDelivered(int $idBasket) : void{
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        UPDATE basket
        SET delivered = 1
        WHERE idBasket = :idBasket;
SQL
);
        $stmt->execute([":idBasket" => $idBasket]);
    }

 
}