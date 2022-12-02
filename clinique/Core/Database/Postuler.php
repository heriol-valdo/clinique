<?php
/**
 * Created by PhpStorm.
 * Eleve: Poizon
 * Date: 26/08/2015
 * Time: 16:49
 */

namespace Projet\Database;


use Projet\Model\Table;

class Postuler extends Table{

    protected static $table = 'postuler';

    public static function save($idUser,$idAnnonce,$libAnnonce,$libUser,$libAuteur,$libNumero,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET libUser = :libUser,libNumero = :libNumero,libAnnonce = :libAnnonce,idUser = :idUser,
        libAuteur = :libAuteur,idAnnonce = :idAnnonce';
        $baseParam = [':libUser' => $libUser,':libNumero' => $libNumero,':libAnnonce' => $libAnnonce,':idUser' => $idUser,
            ':libAuteur' => $libAuteur,':idAnnonce' => $idAnnonce];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function exist($idAnnonce,$idUser){
        $sql = self::selectString().' WHERE idAnnonce = :idAnnonce AND idUser = :idUser';
        $param = [':idUser' => $idUser,':idAnnonce' => $idAnnonce];
        return self::query($sql,$param,true);
    }

    public static function countBySearchType($idUser = null,$idAnnonce = null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(id) AS Total FROM '.self::getTable();
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
        if(isset($idUser)){
            $tidUser = ' AND idUser = :idUser';
            $tab[':idUser'] = $idUser;
        }else{
            $tidUser = '';
        }
        if(isset($idAnnonce)){
            $tidAnnonce = ' AND idAnnonce = :idAnnonce';
            $tab[':idAnnonce'] = $idAnnonce;
        }else{
            $tidAnnonce = '';
        }
        return self::query($count.$where.$tDebut.$tFin.$tidAnnonce.$tidUser,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$idUser = null, $idAnnonce = null,$debut=null,$fin=null){
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
        if(isset($idUser)){
            $tidUser = ' AND idUser = :idUser';
            $tab[':idUser'] = $idUser;
        }else{
            $tidUser = '';
        }
        if(isset($idAnnonce)){
            $tidAnnonce = ' AND idAnnonce = :idAnnonce';
            $tab[':idAnnonce'] = $idAnnonce;
        }else{
            $tidAnnonce = '';
        }
        return self::query(self::selectString().$where.$tDebut.$tFin.$tidAnnonce.$tidUser.$limit,$tab);
    }
}