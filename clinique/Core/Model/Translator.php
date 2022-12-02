<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 19/09/2016
 * Time: 11:51
 */

namespace Projet\Model;



class Translator{

    public $path = LANG;
    public $availableLang = ['fr','en'];
    public $default = 'fr';
    public $current;

    public function __construct(){
        $sesion = Session::getInstance();
        $this->current = empty($_SESSION["lang"]) ? $this->detectLang() : $_SESSION["lang"];
        $this->setSession($this->current);
    }

    public function get($key){
        /*if(is_null($this->dictionnary->get($key))){
            return $key;
        }
        return $this->dictionnary->get($key);*/
    }
    /**
     * @return string
     */
    public function getDefault(){
        return $this->default;
    }

    public function getSession(){
        return $_SESSION['lang'];
    }
    public function setSession($lang){
       $_SESSION['lang']= $lang;
    }
    public function setLang($lang){
        if(!in_array($lang,$this->availableLang)){
            $this->setSession($lang);
            //return $this->dictionnary->setLanguage($this->default);
        }
        $this->setSession($lang);
        //return $this->dictionnary->setLanguage($lang);
    }
    private function detectLang(){
        $current = '';
        $languages = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
        foreach($languages as $lang) {
            $current = substr($lang,0,2);
            if(in_array($current, $this->availableLang)) {
                break;
            }else{
                $current = $this->default;
            }
        }
        return $current;
    }


}