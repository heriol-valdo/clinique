<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 26/08/2015
 * Time: 16:49
 */

namespace Projet\Database;


use Projet\Model\Table;

class Historique_Point extends Table{

    protected static $table = 'historique_point';

    public static function save($idPoint,$idUser,$idMarchand,$avant,$apres,$nbre,$type,$raison){
        $sql = 'INSERT INTO '.self::getTable().' SET idUser = :idUser,idMarchand = :idMarchand,avant = :avant, apres = :apres, raison = :raison, nbre = :nbre, idPoint = :idPoint, type = :types';
        $param = [':idUser'=>($idUser),':idMarchand'=>($idMarchand),':avant'=>($avant),':raison'=>($raison) ,':nbre'=>($nbre) ,':apres'=>($apres),':types'=>($type),':idPoint'=>($idPoint)];
        return self::query($sql,$param,true,true);
    }

    public static function get($type,$idPoint,$idUser){
        $sql = 'SELECT SUM(nbre) AS nbre FROM '.self::getTable().' WHERE idUser = :idUser AND idPoint = :idPoint AND type = :types';
        $param = [':idUser'=>($idUser),':idPoint'=>($idPoint),':types'=>($type)];
        return self::query($sql,$param,true);
    }

    public static function gets($idPoint,$idUser){
        $sql = 'SELECT ((select sum(nbre) as entree from histo where type=1) - (select sum(nbre) as sortie from histo where type=2)) AS nbre FROM '.self::getTable().' WHERE idUser = :idUser AND idPoint = :idPoint';
        $param = [':idUser'=>($idUser),':idPoint'=>($idPoint)];
        return self::query($sql,$param,true);
    }

    public static function countBySearchType($idPoint = null,$idUser = null,$idMarchand = null,$type = null,$debut=null,$fin=null){
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
        if(isset($idUser)){
            $tidUser = ' AND idUser = :idUser';
            $tab[':idUser'] = $idUser;
        }else{
            $tidUser = '';
        }
        if(isset($idPoint)){
            $tidPoint = ' AND idPoint = :idPoint';
            $tab[':idPoint'] = $idPoint;
        }else{
            $tidPoint = '';
        }
        if(isset($type)){
            $ttype = ' AND type = :type';
            $tab[':type'] = $type;
        }else{
            $ttype = '';
        }
        if(isset($idMarchand)){
            $tidMarchand = ' AND idMarchand = :idMarchand';
            $tab[':idMarchand'] = $idMarchand;
        }else{
            $tidMarchand = '';
        }
        return self::query($count.$where.$tDebut.$tFin.$tidPoint.$tidMarchand.$ttype.$tidUser,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$idPoint = null,$idUser = null, $idMarchand = null,$type = null,$debut=null,$fin=null){
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
        if(isset($idPoint)){
            $tidPoint = ' AND idPoint = :idPoint';
            $tab[':idPoint'] = $idPoint;
        }else{
            $tidPoint = '';
        }
        if(isset($type)){
            $ttype = ' AND type = :type';
            $tab[':type'] = $type;
        }else{
            $ttype = '';
        }
        if(isset($idMarchand)){
            $tidMarchand = ' AND idMarchand = :idMarchand';
            $tab[':idMarchand'] = $idMarchand;
        }else{
            $tidMarchand = '';
        }
        return self::query(self::selectString().$where.$tDebut.$ttype.$tidMarchand.$tFin.$tidPoint.$tidUser.$limit,$tab);
    }


}