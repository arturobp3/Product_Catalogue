<?php

require_once('MySQL.php');
require_once('MongoDB.php');

/**
 * Configuración del soporte de UTF-8, localización (idioma y país) y zona horaria
 */
session_start();
ini_set('default_charset', 'UTF-8');
setlocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_get();

/*--------------------------------------------------------------------------------------------*/

/**
 * Parámetros de conexión a la BD MySQL
 */
define('BD_HOST', 'localhost');
define('BD_NAME', 'product_catalog');
define('BD_USER', 'root');
define('BD_PASS', '');


// Creamos la instancia de MySQL
$appMySQL = MySQL::getInstanceMySQL();

//Inicializamos MySQL
$appMySQL->initMySQL(array('host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS));

//Registramos la función shutdownMySQL como aquella que cierra la conexión con la bbdd
register_shutdown_function(array($appMySQL, 'shutdownMySQL'));

/*--------------------------------------------------------------------------------------------*/

/**
 * Parámetros de conexión a la BD MongoDB
 */
define('BD_HOST_MDB', 'mongodb://localhost:27017');


// Creamos la instancia de MongoDB
$appMongoDB = MongoDB::getInstanceMongoDB();

//Inicializamos MongoDB
$appMongoDB->initMongoDB(array('host'=>BD_HOST_MDB));

//Registramos la función shutdownMongoDB como aquella que cierra la conexión con la bbdd
//register_shutdown_function(array($appMongoDB, 'shutdownMongoDB'));



