<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 7/4/2015
 * Time: 2:22 AM
 */

namespace Projet\Model;


class Session {

	static $instance;
	/*
	 * Constructeur de l'objet
	 */
	public function __construct(){
		session_start();
	}

	/*
	 * retourne l'instance de Session en cours
	 */
	static function getInstance(){
		if(!self::$instance){
			self::$instance = new Session();
		}
		return self::$instance;
	}

	public static function getSaveUrl($defaulUrl){
		return isset($_SESSION['url'])?App::url(self::getInstance()->read('url')):$defaulUrl;
	}

	public function setFlash($key, $message){
		$_SESSION['flash'][$key] = $message;
	}

	public function hasFlashes(){
		return isset($_SESSION['flash']);
	}

	public function getFlashes(){
		$flash = $_SESSION['flash'];
		unset($_SESSION['flash']);
		return $flash;
	}

	/**
	 * Ecrire une cle dans la variable globale SESSION
	 * @param $key
	 * @param $value
	 */
	public function write($key, $value){
		$_SESSION[$key] = $value;
	}

	public function read($key){
		return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
	}

	public function delete($key){
		unset($_SESSION[$key]);
	}

}