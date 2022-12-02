<?php
/**
 * Created by PhpStorm.
 * Eleve: Poizon
 * Date: 26/08/2015
 * Time: 16:49
 */

namespace Projet\Database;


use Projet\Model\Table;

class Hospitalisation extends Table{

    protected static $table = 'hospitalisation';

    public static function save($idsalle,$idpatient,$date_in,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET idsalle = :idsalle,idpatient = :idpatient,date_in = :date_in';
        $baseParam = [':idpatient' => $idpatient,':idsalle' => $idsalle,':date_in' => $date_in];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }
    
    public static function setDateOut($date_out,$id){
        $sql = 'UPDATE '.self::getTable().' SET date_out = :date_out WHERE id = :id ';
        $param = [':date_out'=>($date_out),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setEtat($etat,$id){
        $sql = 'UPDATE '.self::getTable().' SET etat = :etat WHERE id = :id';
        $param = [':etat'=>($etat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }


    public static function countBySearchType($idsalle = null,$idpatient = null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($idsalle)){
            $tidsalle = ' AND idsalle = :idsalle';
            $tab[':idsalle'] = $idsalle;
        }else{
            $tidsalle = '';
        }
        if(isset($idpatient)){
            $tidpatient = ' AND idpatient = :idpatient';
            $tab[':idpatient'] = $idpatient;
        }else{
            $tidpatient = '';
        }
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

        return self::query($count.$where.$tidpatient.$tidsalle.$tDebut.$tFin,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$idsalle = null,$idpatient = null,$debut=null,$fin=null){
        $limit = ' ORDER BY created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($idsalle)){
            $tidsalle = ' AND idsalle = :idsalle';
            $tab[':idsalle'] = $idsalle;
        }else{
            $tidsalle = '';
        }
        if(isset($idpatient)){
            $tidpatient = ' AND idpatient = :idpatient';
            $tab[':idpatient'] = $idpatient;
        }else{
            $tidpatient = '';
        }
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

        return self::query(self::selectString().$where.$tDebut.$tFin.$tidpatient.$tidsalle.$limit,$tab);
    }

}