<?php
/**
 * Created by PhpStorm.
 * User: le marcelo
 * Date: 28/02/2017
 * Time: 12:32
 */

namespace Projet\Database;


use Projet\Model\Table;

class Carte extends Table{

    protected static $table = 'carte';

    public static function save($nom,$code,$pourcentage,$minimum,$commission,$prix,$details,$id=null){
        $baseParam = [':code' => $code,':nom' => ucfirst($nom),':details' => $details,':prix' => $prix,':minimum' => $minimum,':commission' => $commission,':pourcentage' => $pourcentage];
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET code = :code,nom = :nom,details = :details, prix = :prix,minimum = :minimum, commission = :commission, pourcentage = :pourcentage';
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql,$baseParam,true,true);
    }

    public static function setImage($photo,$id){
        $sql = 'UPDATE '.self::getTable().' SET image = :photo WHERE id = :id';
        $param = [':photo'=>($photo),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function byCode($code){
        $sql = self::selectString() . ' WHERE code = :code';
        $param = [':code' => $code];
        return self::query($sql, $param,true);
    }

    public static function byNom($nom,$code){
        $sql = self::selectString() . ' WHERE nom = :nom AND code = :code';
        $param = [':code' => $code,':nom' => $nom];
        return self::query($sql, $param,true);
    }

    public static function countBySearchType($debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($debut)){
            $tDebut = ' AND DATE(created_at) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(created_at) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }

        return self::query($count.$where.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$debut=null,$fin=null){
        $limit = ' ORDER BY created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($debut)){
            $tDebut = ' AND DATE(created_at) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(created_at) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        return self::query(self::selectString().$where.$tFin.$tDebut.$limit,$tab);
    }

}