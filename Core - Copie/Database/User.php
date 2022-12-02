<?php
/**
 * Created by PhpStorm.
 * User: Ndjeunou
 * Date: 23/01/2017
 * Time: 10:15
 */

namespace Projet\Database;


use Projet\Model\Table;

class User extends Table{

    protected static $table = 'user';

    public static function save($nom,$prenom,$login,$password){
        $sql = 'INSERT INTO '.self::getTable().' SET password = :pass, nom = :nom, prenom = :prenom, login = :login';
        $param = [':nom'=>$nom ,':prenom'=>$prenom,':login'=>$login,':pass'=>$password];
        return self::query($sql,$param,true,true);
    }

    public static function setUpdated($date,$id){
        $sql = 'UPDATE '.self::getTable().' SET last_login = :updated WHERE id = :id ';
        $param = [':updated'=>($date),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setPhoto($photo,$id){
        $sql = 'UPDATE '.self::getTable().' SET photo = :photo WHERE id = :id ';
        $param = [':photo'=>($photo),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($search=null,$sInscription=null,$eInscription=null,$sLogin=null,$eLogin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE roles = :roles';
        $tab = [];
        if(isset($search)){
            $tSearch = ' AND (nom LIKE :search OR login LIKE :search OR prenom LIKE :search)';
            $tab[':search'] = '%'.($search).'%';
        }else{
            $tSearch = '';
        }
        if(isset($sInscription)){
            $tSInscription = ' AND DATE(created_at) >= :inscrip';
            $tab[':inscrip'] = ($sInscription);
        }else{
            $tSInscription = '';
        }
        if(isset($eInscription)){
            $tEInscription = ' AND DATE(created_at) <= :inscription';
            $tab[':inscription'] = ($eInscription);
        }else{
            $tEInscription = '';
        }
        if(isset($sLogin)){
            $tSlogin = ' AND DATE(last_login) >= :lastLogin';
            $tab[':lastLogin'] = '%'.($sLogin);
        }else{
            $tSlogin = '';
        }
        if(isset($eLogin)){
            $tElogin = ' AND DATE(last_login) <= :last';
            $tab[':last'] = '%'.($eLogin);
        }else{
            $tElogin = '';
        }
        return self::query($count.$where.$tSearch.$tSInscription.$tEInscription.$tSlogin.$tElogin,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$search=null,$sInscription=null,$eInscription=null,$sLogin=null,$eLogin=null,$etat=null,$sexe=null){
        $limit = ' ORDER BY nom ASC, prenom ASC, last_login DESC,created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE roles = :roles';
        $tab = [];
        if(isset($search)){
            $tSearch = ' AND (nom LIKE :search OR login LIKE :search OR prenom LIKE :search)';
            $tab[':search'] = '%'.($search).'%';
        }else{
            $tSearch = '';
        }
        if(isset($sInscription)){
            $tSInscription = ' AND DATE(created_at) >= :inscrip';
            $tab[':inscrip'] = ($sInscription);
        }else{
            $tSInscription = '';
        }
        if(isset($eInscription)){
            $tEInscription = ' AND DATE(created_at) <= :inscription';
            $tab[':inscription'] = ($eInscription);
        }else{
            $tEInscription = '';
        }
        if(isset($sLogin)){
            $tSlogin = ' AND DATE(last_login) >= :lastLogin';
            $tab[':lastLogin'] = '%'.($sLogin);
        }else{
            $tSlogin = '';
        }
        if(isset($eLogin)){
            $tElogin = ' AND DATE(last_login) <= :last';
            $tab[':last'] = '%'.($eLogin);
        }else{
            $tElogin = '';
        }
        return self::query(self::selectString().$where.$tSearch.$tSInscription.$tEInscription.$tSlogin.$tElogin.$limit,$tab);
    }

}