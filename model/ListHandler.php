<?php declare(strict_types=1);

require_once("autoload.php");


/**
 * Classe ListHandler permettant la gestion des données issues de la base de données.
 *
 * @startuml
 *
 *  skinparam defaultFontSize 16
 *  skinparam BackgroundColor transparent
 *
 *  class ListHandler {
 *      + processRequest(array $args, string $action) : void
 *      - getMenus() : void
 *      - getMenuItems(int $id) : void
 *      - getItems(int $type) : void
 *      - getItemsFromTypeAndName(int $type, string $name) : void
 *      - getItemsFromId(int $idItem) : void
 *  }
 *
 * @enduml
 */

class ListHandler extends BaseHandler{

    
    /**
     * Constructeur de la classe ListHandler. Permet d'initialiser l'ensemble des attributs d'instance de la classe à partir de sa classe parent.
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
        if ($action == "getMenus"){
            $this->getMenus();
        }else if ($action == "getMenuItems"){
            if (count($args) != 1 )
                $this->isError = true;       
            $this->getMenuItems($args[0]);
            /*foreach($args as $arg)
            {
                $this->getMenuItems($arg);
            }*/
        }else if ($action == "getItems"){
            foreach($args as $arg)
            {
                $this->getItems($arg);
            }

        }else if ($action == "getItemsFromTypeAndName"){
            if (count($args) != 2 )
                $this->isError = true;
            $this->getItemsFromTypeAndName($args[0],$args[1]);
        }else if ($action == "getItemsFromId"){
            if (count($args) != 1)
                $this->isError = true;
            $this->getItemsFromId($args[0]);
        }else{
            $this->isError = true;
        }
    }


    /**
     * Fonction de récupération des Menus et stockage de ces derniers.
     */
    private function getMenus() : void{
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * FROM menu
        WHERE idMenu < 16;
SQL
);
        $stmt->execute();

        $this->returnData = $stmt->fetchAll();
    }

    
    /**
     * Fonction de récupération des Items composant un menu et stockage de ces derniers.
     * @param $id  Identifiant du
     */
    private function getMenuItems(int $id) : void{
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT *
        FROM item i INNER JOIN composition c ON (i.idItem = c.idItem)
        WHERE idMenu = :id
        ORDER BY type;
SQL
);

        $stmt->execute(array(":id"=>$id));
        

        $this->returnData = $stmt->fetchAll();        
    }


    /**
     * Fonction de récupération des Items selon leur type et stockage de ces derniers.
     * @param $id  Type de l'item
     */
    private function getItems(int $type){
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * FROM item
        WHERE type = :type
        ORDER BY idItem;
SQL
);

        $stmt->execute(array(":type"=>$type));

        $this->returnData = $stmt->fetchAll();
    }


    /**
     * Fonction de récupération des Items selon leur type et stockage de ces derniers.
     * @param $type  Type de l'item
     * @param $name une partie du nom de l'item
     */
    private function getItemsFromTypeAndName(int $type, string $name){
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * FROM item
        WHERE type = :type
        AND name LIKE :name
        ORDER BY idItem;
SQL
);

        $stmt->execute(array(":type"=>$type,":name"=>'%'.$name.'%'));

        $this->returnData = $stmt->fetchAll();
    }


    /**
     * Fonction de récupération des Items selon leur type et stockage de ces derniers.
     * @param $name  Type de l'item
     */
    private function getItemsFromId(int $idItem) : void{
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * FROM item
        WHERE idItem = :idItem
SQL
);

        $stmt->execute(array(":idItem"=>$idItem));

        $this->returnData = $stmt->fetchAll();
    }
}