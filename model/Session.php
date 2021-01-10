<?php
declare(strict_types=1);

require_once('autoload.php');

class Session
{
	
	/**
	 * Fonction de démarrage de session.
	 */
	public function start()
	{
		if(session_status() === PHP_SESSION_ACTIVE);

		elseif (session_status() !== PHP_SESSION_ACTIVE){
			session_start();
		}

		elseif (headers_sent() === FALSE){
			throw new SessionException("SessionException");	
		}

		elseif (session_status() === PHP_SESSION_NONE){
			throw new SessionException("SessionException");	
		}
	}
}