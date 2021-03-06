<?php

/**
 * Creative Framework
 * @version 1.0.0
 * @author Brayan Rincon
 */

/**
* Establece la zona horaria predeterminada 
* usada por todas las funciones de fecha / hora en un script
*/
date_default_timezone_set(TIMEZONE);


/**
* Lenguaje por defecto de la Aplicación
*/
setlocale(LC_ALL, DEFAULT_LANG);


//define('PATH_ROOT', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

require_once PATH_FRAMEWORK . 'Defines.php';
require_once PATH_FRAMEWORK . 'Eviroment.php';
//require_once PATH_FRAMEWORK . 'Autoload.php';
require_once PATH_FRAMEWORK . 'LogsHandler.php';
require_once PATH_FRAMEWORK . 'ErrorHandler.php';
require_once PATH_FRAMEWORK . 'Creative.php';
require_once PATH_FRAMEWORK . 'Functions.php';

abstract class Initialize 
{
	public static function execute()
	{
		Creative::add( 'Conexant' );
		Creative::add( 'Metadata' );
		Creative::add( 'Components' );
		Creative::add( 'Hash' );
		//Creative::add( 'Session' );
		
		App::initialize();
		Lang::set_locale( App::get('locale') );

		Session::initialize();

		Auth::initialize();
		Registry::initialize();
		Acl::initialize();	
		
	}
}

Initialize::execute();