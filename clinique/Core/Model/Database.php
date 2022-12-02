<?php
/**
 * Created by PhpStorm.
 * Eleve: Poizon
 * Date: 29/06/2015
 * Time: 14:45
 */

namespace Projet\Model;

use \PDO;
/*
 * Classe permettant la connexion a la base de données PDO
 */

class Database {

    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct($db_name='afrikfid', $db_user ='root', $db_pass='',$db_host='localhost') {
	    try{
		    $pdo = new PDO('mysql:dbname='.$db_name.';host='.$db_host,$db_user,$db_pass);
		    $pdo->exec("SET CHARACTER SET utf8");
		    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		    $this->pdo = $pdo;

	    }catch (\PDOException $e){
            App::error_db($e->getMessage());
	    }
    }

    public function getPDO(){
        return $this->pdo;
    }

	/**
	 * Function pour effectuer une requete simple dans la base de donnes
	 * @param $statement
	 * @param $class
	 * @param bool $one
	 * @param bool $isOther
	 * @return array|int|mixed
	 */
    public function query($statement, $class, $one = false, $isOther = false){
        $req = $this->pdo->query($statement);
        $req->setFetchMode(PDO::FETCH_CLASS,$class);
        if($isOther) {
            return $req->rowCount();
        }else{
            if($one){
                $datas = $req->fetch();
            }else{
                $datas = $req->fetchAll();
            }
            return $datas;
        }
    }

	/**
	 * Fonction pour effectuer une requete prepare
	 * @param $statement
	 * @param $values
	 * @param $class
	 * @param bool $one
	 * @param bool $isOhter
	 * @return array|int|mixed
	 */

    public function prepare($statement, $values,$class, $one = false, $isOhter = false){
        $req = $this->pdo->prepare($statement);
        $req->execute($values);
        $req->setFetchMode(PDO::FETCH_CLASS,$class);
        /*
         * Ajout pour les rêquetes de types : UPDATE, DELETE, INSERT
         */
        if($isOhter){
            return $req->rowCount();
        }else{
            if($one){
                $datas = $req->fetch();
            }else{
                $datas = $req->fetchAll();

            }
            return $datas;
        }

    }

	public function lastInsertId(){
		return $this->pdo->lastInsertId();
	}
}