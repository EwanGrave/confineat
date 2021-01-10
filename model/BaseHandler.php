<?php declare(strict_types=1);


/**
 * Classe BaseHandler abstraite permettant la gestion des données issues de la base de données.
 *
 * @startuml
 *
 *  skinparam defaultFontSize 16
 *  skinparam BackgroundColor transparent
 *
 *  class BaseHandler {
 *      # $isError
 *      # $errorMsg
 *      # $returnData
 *      + __construct()
 *      + {abstract}processRequest(array $args, string $action) : void
 *      + getStatusCode() : int
 *      + getReturnData() : array
 *      + getErrorMsg() : string
 *  }
 *
 * @enduml
 */
abstract class BaseHandler{
    protected bool $isError;
    protected string $errorMsg;
    protected array $returnData;

    protected const CONSTANTE_USER_MENU = 15;


    /**
     * Constructeur de la classe BaseHandler. Permet d'initialiser l'ensemble des attributs d'instance de la classe.
     */
    public function __construct(string $errorMsg = ""){
        $this->isError = false;
        $this->returnData = [];
        $this->errorMsg = $errorMsg;
    }

    /**
     * Prototype de la fonction de récupération des Menus ou des Items
     */
    abstract public function processRequest(array $args, string $action = "") : void;
    

    /**
     * Fonction de récupération du code d'erreur
     * @return int 
     */
    public function getStatusCode() : int{
        return $this->isError ? 1 : 0;
    }

    /**
     * Accesseur au tableau contenant les données à retourner.
     */
    public function getReturnData() {
        return $this->returnData;
    }


    
    /**
     * Accesseur au message d'erreur.
     * @return string
     */
    public function getErrorMsg() : string{
        return $this->errorMsg;
    }
}