<?php declare(strict_types=1);

require_once("autoload.php");

/**
 * Classe AdminHandler permettant la gestion des actions liées à un administrateur
 *
 *  class AdminHandler {
 *      + processRequest(array $args, string $action) : void
 *      + getQuantities() : array
 *      + getOrders() : array
 *      - setQuantity(int $id, int $quantity) : void
 *      - DeleteAllUserDatas(int $idUser) : void
 *  }
 */

class AdminHandler extends BaseHandler {
	/**
	 * Méthode héritée qui traite l'action d'un admin
	 * @param array $args
	 * @param string $action
	 */
    /*public function processRequest(array $args, string $action = "") : void
    {
        $this->setQuantity((int)$args["id"], (int)$args["quantity"]);
    }*/
    public function processRequest(array $args, string $action = "") : void{
        if($action == "setQuantity"){
            $this->setQuantity((int)$args["id"], (int)$args["quantity"]);
        }else if ($action == "DeleteAllUserDatas"){
            if (count($args) != 1 )
                $this->isError = true;
            $this->DeleteAllUserDatas($args[0]);
        }
    }

	/**
     * Donne les quantités des items sous forme de tableau
	 * @return array
	 */
    public function getQuantities(): array {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT name, imgPath, quantity, idItem
        FROM item
        ORDER BY 1;
SQL
);

        $stmt->execute([]);

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll();
        }else{
            $this->isError = true;
            return [];
        }
    }

	/**
	 * Donne les menus sous forme de tableaux
	 * @return array
	 */
    public function getOrders(): array {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT delivered, firstname, lastname, email, price, dateCompleted
        FROM basket b INNER JOIN user u ON (b.idUser = u.idUser)
        WHERE completed = 1
        ORDER BY dateCompleted;
SQL
);

        $stmt->execute([]);

        return $stmt->fetchAll();
    }

	/**
     * Change la quantité d'un item
	 * @param int $id : identifiant de l'item
	 * @param int $quantity : la valeur donnée pour changer sa quantité
	 */
    private function setQuantity(int $id, int $quantity) {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * FROM item
        WHERE idItem = :id;
SQL
);

        $stmt->execute([":id" => $id]);

        if ($stmt->rowCount() == 1) {
            $stmt = MyPDO::getInstance()->prepare(<<<SQL
            UPDATE item
            SET quantity = :q
            WHERE idItem = :id;
SQL
);

            $stmt->execute([
                ":q" => $quantity,
                ":id" => $id
            ]);
        }else{
            $this->isError = true;
        }
    }


    /**
     * Fonction de suppression de l'ensemble des données utilisateur de la base de données
     */
    private function DeleteAllUserDatas(int $idUser) : void
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        DELETE FROM address
        WHERE idUser = :idUser;
SQL
);
        $stmt->execute([":idUser" => $idUser]);
        
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        DELETE FROM list
        WHERE idBasket = :idUser;
SQL
);
        $stmt->execute([":idUser" => $idUser]);


        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        DELETE FROM Basket
        WHERE idUser = :idUser;
SQL
);
        $stmt->execute([":idUser" => $idUser]);

        
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        DELETE FROM user
        WHERE idUser = :idUser;
SQL
);

        $stmt->execute([":idUser" => $idUser]);
    }
}