<?php

ini_set('display_errors', 1);
ini_set('memory_limit', '-1');
date_default_timezone_set("Africa/Douala");
define('ROOT',__DIR__);
define('LANG',__DIR__.'/lang');
define('DEBUG_MODE',1);
define('ROOT_SITE','http://clinique.log/public/');
define('ROOT_URL','http://clinique.log/');
define('PATH_FILE',realpath(dirname(__FILE__)));
define('MYSQL_DATETIME_FORMAT','Y-m-d H:i:s');
define('MYSQL_DATE_FORMAT','Y-m-d');
define('DATE_FORMAT','d-m-Y');
define('VALUE_OF_POINT',100);
define('DATE_COURANTE',date(MYSQL_DATETIME_FORMAT));
function var_die($expression){
	echo '<pre>';
	var_dump($expression);
	echo '</pre>';
	die();
}
function thousand($value){
    return number_format($value,0,'.',',');
}
function thousands($value){
    return number_format($value,0,',',' ');
}
function float_value($value){
    return strpos($value,'.') !== false?number_format($value,2,',',' '):thousand($value);
}
function is_ajax(){
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
function getChemin($name){
    return ROOT_SITE.'articles/'.$name;
}
require 'Core/Autoloader.php';
require 'vendor/autoload.php';
$routes = require 'routes.php';
\Projet\Autoloader::register();
\Projet\Model\Router::call($routes);
