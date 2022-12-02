<?php
/**
 * Created by PhpStorm.
 * User: Ndjeunou
 * Date: 27/02/2017
 * Time: 12:26
 */

namespace Projet\Database;


use Projet\Model\Table;

class Tranche extends Table{

    protected static $table = 'tranche';

    public static function save($debut,$fin,$cout,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET debut = :debut, fin = :fin, cout = :cout';
        $baseParam = [':debut'=>$debut,':cout'=>$cout,':fin'=>$fin];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }
    
    public static function get($price){
        $sql = self::selectString().' WHERE debut <= :price AND fin >= :price';
        $param = [':price'=>$price];
        return self::query($sql,$param,true);
    }

    public static function isExist($debut,$fin){
        $sql = self::selectString().' WHERE (fin >= :debut OR fin >= :fin)';
        $param = [':debut'=>$debut,':fin'=>$fin];
        return self::query($sql,$param,true);
    }

    public static function countBySearch($debut=null,$fin=null,$cout=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($cout)){
            $tcout = ' AND cout = :cout';
            $tab[':cout'] = $cout;
        }else{
            $tcout = '';
        }
        if(isset($debut)){
            $tdebut = ' AND debut = :debut';
            $tab[':debut'] = $debut;
        }else{
            $tdebut = '';
        }
        if(isset($fin)){
            $tfin = ' AND fin = :fin';
            $tab[':fin'] = $fin;
        }else{
            $tfin = '';
        }
        return self::query($count.$where.$tdebut.$tfin.$tcout,$tab,true);
    }

    public static function search($nbreParPage=null,$pageCourante=null,$debut=null,$fin=null,$cout=null){
        $limit = ' ORDER BY debut ASC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($cout)){
            $tcout = ' AND cout = :cout';
            $tab[':cout'] = $cout;
        }else{
            $tcout = '';
        }
        if(isset($debut)){
            $tdebut = ' AND debut = :debut';
            $tab[':debut'] = $debut;
        }else{
            $tdebut = '';
        }
        if(isset($fin)){
            $tfin = ' AND fin = :fin';
            $tab[':fin'] = $fin;
        }else{
            $tfin = '';
        }
        return self::query(self::selectString().$where.$tdebut.$tfin.$tcout.$limit,$tab);
    }

}