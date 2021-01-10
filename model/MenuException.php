<?php

/**
 * Classe MenuException permettant la gestion des erreurs provenant des Menus.
 *
 * @startuml
 *
 *  skinparam defaultFontSize 16
 *  skinparam BackgroundColor transparent
 *
 *  class MenuException {
 *      + __construct(string $message = "Erreur de session", int $code = 0, Throwable $previous = null)
 *  }
 *
 * @enduml
 */
class MenuException extends Exception
{
    /**
     * Constructeur de la classe MenuException. permettant la gestion des erreurs issues de la ssion de l'utilisateur.
     * @param $message Message d'erreur
     * @param $code Code d'erreur
     * @param $previous 
     */
    public function __construct(string $message = "Erreur d' Item", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}