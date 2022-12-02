<?php
/**
 * Created by PhpStorm.
 * Eleve: Poizon
 * Date: 26/08/2015
 * Time: 16:49
 */

namespace Projet\Database;


use Projet\Model\Table;

class Fournisseur extends Table{

    protected static $table = 'fournisseur';

    public static function save($nom,$pays,$adresse,$numero,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET nom = :nom,pays = :pays,adresse = :adresse,numero = :numero';
        $baseParam = [':nom' => $nom,':pays' => $pays,':adresse' => $adresse,':numero' => $numero];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function setPhoto($photo,$id){
        $sql = 'UPDATE '.self::getTable().' SET photo = :photo WHERE id = :id';
        $param = [':photo'=>($photo),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setNbre($nbre,$id){
        $sql = 'UPDATE '.self::getTable().' SET nbre = :nbre WHERE id = :id';
        $param = [':nbre'=>($nbre),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($search = null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tSearch = ' AND (nom LIKE :search OR ville LIKE :search)';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tSearch = '';
        }
        return self::query($count.$where.$tSearch,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$search = null){
        $limit = ' ORDER BY nom ASC, created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tSearch = ' AND (nom LIKE :search OR ville LIKE :search)';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tSearch = '';
        }
        return self::query(self::selectString().$where.$tSearch.$limit,$tab);
    }

}