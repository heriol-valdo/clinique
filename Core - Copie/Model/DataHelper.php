<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 03/03/2017
 * Time: 17:01
 */

namespace Projet\Model;


class DataHelper{

    public static function post($key, $default = null){
        if(isset($_POST[$key]) && !empty($_POST[$key])){
            return $_POST[$key];
        }
        return $default;
    }
    public static function get($key, $default = null){
        if(isset($_GET[$key]) && !empty($_GET[$key])){
            return $_GET[$key];
        }
        return $default;
    }

}