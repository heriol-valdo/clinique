<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 29/06/2015
 * Time: 14:36
 */

namespace Projet;

class Autoloader {
    /**
     * Enregistre notre autoloader
     */
    static function register(){
        spl_autoload_register(array(
                __CLASS__,
                'autoload')
        );
    }

    /**
     * Inclue le fichier correspondant à notre classe
     * @param $class string Le nom de la classe à charger
     */
    static function autoload($class){
        if (strpos($class, __NAMESPACE__ . '\\') === 0){
            $class = str_replace(__NAMESPACE__ . '\\', '', $class);
            $class = str_replace('\\', '/', $class);
            require __DIR__.'/' . $class . '.php';
        }
    }
}