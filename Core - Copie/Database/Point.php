<?php
/**
 * Created by PhpStorm.
 * User: Ndjeunou
 * Date: 23/01/2017
 * Time: 10:15
 */

namespace Projet\Database;


use Projet\Model\Table;

class Point extends Table{

    protected static $table = 'point';

    public static function save($nom,$ville,$adresse,$numero,$email,$latitude,$longitude,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET latitude = :latitude,nom = :nom,
        adresse = :adresse,email = :email,longitude = :longitude,ville = :ville,numero = :numero';
        $baseParam = [':latitude' => $latitude,':nom' => $nom,':email' => $email,
            ':adresse' => $adresse,':longitude' => $longitude,':ville' => $ville,':numero' => $numero];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function setLocal($idPays,$libPays,$idRegion,$libRegion,$id){
        $sql = 'UPDATE '.self::getTable().' SET libRegion = :libRegion,idRegion = :idRegion,libPays = :libPays,idPays = :idPays WHERE id = :id ';
        $param = [':libRegion'=>($libRegion),':idRegion'=>($idRegion),':libPays'=>($libPays),':idPays'=>($idPays),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setLocalisation($latitude,$longitude,$id){
        $sql = 'UPDATE '.self::getTable().' SET longitude = :longitude,latitude = :latitude WHERE id = :id ';
        $param = [':latitude' => $latitude,':longitude' => $longitude,':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($search=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tSearch = ' AND (nom LIKE :search OR ville LIKE :search OR quartier LIKE :search OR adresse LIKE :search)';
            $tab[':search'] = '%'.($search).'%';
        }else{
            $tSearch = '';
        }
        return self::query($count.$where.$tSearch,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$search=null){
        $limit = ' ORDER BY nom ASC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tSearch = ' AND (nom LIKE :search OR ville LIKE :search OR quartier LIKE :search OR adresse LIKE :search)';
            $tab[':search'] = '%'.($search).'%';
        }else{
            $tSearch = '';
        }
        return self::query(self::selectString().$where.$tSearch.$limit,$tab);
    }

}