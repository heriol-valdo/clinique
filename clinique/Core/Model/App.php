<?php
/**
 * Created by PhpStorm.
 * Eleve: Poizon
 * Date: 29/06/2015
 * Time: 15:11
 */

namespace Projet\Model;
use Projet\Auth\DBAuth;

class App {

    private static $db;
    private static $auth;
    private static $scripts = [];
    private static $styles = [];
    private static $title = 'PLUMERS';
    private static $userss = ' | PLUMERS';
    private static $naviation = 'Accueil';
    private static $breadcumb = '';
    const DB_NAME = 'plumers';
    const DB_USER = 'root';
    const DB_PASS = '';
    /*const DB_NAME = 'plumespace_plumers';
    const DB_USER = 'plumespace';
    const DB_PASS = 'Renoplus0@0';*/
    const DB_HOST = 'localhost';

    public static function error_db($error){
        $_SESSION['error_db'] = $error;
        self::redirect(self::url('error_db'));
    }

    public static function getBreadcumb(){
        return self::$breadcumb;
    }

    public static function setBreadcumb($bread){
        $home = "<li><a href='".App::url('home')."'><i class='icon-home2 position-left'></i> Accueil</a></li>";
        self::$breadcumb = $home.$bread;
    }

    public static function getDb() {
        if(self::$db === null){
            self::$db = new Database(self::DB_NAME,self::DB_USER,self::DB_PASS,self::DB_HOST);
        }
        return self::$db;
    }

    public static function getDBAuth(){
        if(self::$auth === null){
            self::$auth = new DBAuth(Session::getInstance());
        }
        return self::$auth;
    }

    public static function deleteSession(){
        unset($_SESSION);
    }

    public static function interdit(){
        self::redirect(self::url(''));
    }

    public static function unauthorize(){
        self::redirect(self::url('unauthorize'));
    }

    public static function notopen(){
        self::redirect(self::url('admin/access/cashier/open_box'));
    }

    public static function error(){
        self::redirect(self::url('error'));
    }

    /**
     * @return mixed
     */
    public static function getScripts() {
        return self::$scripts;
    }

    public static function addScript($script, $isSource = false, $isDefault = false){
        if ($isSource){
            if($isDefault){
                self::$scripts['default'][] = '<script src="'.ROOT_SITE.$script.'" type="text/javascript"></script>'."\r\n";
            }else{
                $root = (strpos($script,"http") !== false)?"":ROOT_SITE;
                self::$scripts['source'][] = '<script src="'.$root.$script.'" type="text/javascript"></script>'."\r\n";
            }
        }else{
            self::$scripts['script'][] = '<script type="text/javascript">$(document).ready(function(){'.$script.'});</script>'."\r\n";
        }
    }

    /**
     * @return array
     */
    public static function getStyles(){
        return self::$styles;
    }

    public static function addStyle($style, $isSource = false, $isDefault = false){
        if($isSource){
            if($isDefault){
                self::$styles['default'][] = '<link href="'.ROOT_SITE.$style.'" rel="stylesheet" type="text/css" media="all">'."\r\n";
            }else{
                $root = (strpos($style,"http") !== false)?"":ROOT_SITE;
                self::$styles['source'][] = '<link href="'.$root.$style.'" rel="stylesheet" type="text/css" media="all">'."\r\n";
            }
        }else{
            self::$styles['script'][] = '<style type="text/css">'.$style.'</style>'."\r\n";
        }
    }
    
    /**
     * @return mixed
     */
    public static function getTitle() {
        return self::$title.self::$userss;
    }

    /**
     * @param mixed $title
     */
    public static function setTitle($title) {
        self::$title = $title;
    }

    /**
     * @return mixed
     */
    public static function getNavigation() {
        return self::$naviation;
    }

    /**
     * @param mixed $title
     */
    public static function setNavigation($nav) {
        self::$naviation = $nav;
    }

    /*
     * fonction qui redirge vers la page passée en paramètre
     */
    public static function redirect($page){
        header("location: $page");
        exit();
    }
    /*
     * fonction qui retourne la salutation
     */
    public static function salutation(){
        $date = date('H');
        if (($date <=23 && $date > 21)||$date==0){
            $message = "Bonne nuit";
        }elseif ($date == 12){
            $message = "Bon midi";
        }elseif ($date > 12 && $date < 17){
            $message = "Bonne après midi";
        }elseif ($date >= 17 && $date <= 21){
            $message = "Bonsoir";
        }else{
            $message = "Bonjour";
        }
        return $message;
    }
    /*
     * fonction qui ajoute index.php à une url
     */
    public static function url($url){
        return ROOT_URL.$url;
    }

} 