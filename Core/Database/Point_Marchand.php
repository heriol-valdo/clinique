<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 26/08/2015
 * Time: 16:49
 */

namespace Projet\Database;


use Projet\Model\Table;

class Point_Marchand extends Table{

    protected static $table = 'point_marchand';

    public static function save($idUser,$idMarchand,$points){
        $sql = 'INSERT INTO '.self::getTable().' SET idUser = :idUser,idMarchand = :idMarchand,points = :points';
        $param = [':idUser'=>($idUser),':idMarchand'=>($idMarchand),':points'=>($points) ];
        return self::query($sql,$param,true,true);
    }

    public static function get($idMarchand,$idUser){
        $sql = 'SELECT SUM(points) AS nbre FROM '.self::getTable().' WHERE idUser = :idUser AND idMarchand = :idMarchand';
        $param = [':idUser'=>($idUser),':idMarchand'=>($idMarchand)];
        return self::query($sql,$param,true);
    }

    public static function gets($idMarchand,$idUser){
        $sql = self::selectString().' WHERE idUser = :idUser AND idMarchand = :idMarchand';
        $param = [':idUser'=>($idUser),':idMarchand'=>($idMarchand)];
        return self::query($sql,$param,true);
    }

    public static function countBySearchType($idUser = null,$idMarchand = null,$debut=null,$fin=null){
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
        if(isset($idMarchand)){
            $tidMarchand = ' AND idMarchand = :idMarchand';
            $tab[':idMarchand'] = $idMarchand;
        }else{
            $tidMarchand = '';
        }
        return self::query($count.$where.$tDebut.$tFin.$tidMarchand.$tidUser,$tab,true);
    }

    public static function setPoints($points,$id){
        $sql = 'UPDATE '.self::getTable().' SET points = :points WHERE id = :id ';
        $param = [':points'=>($points),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$idUser = null, $idMarchand = null,$debut=null,$fin=null){
        $limit = ' ORDER BY point_marchand.created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' LEFT JOIN marchand ON marchand.id = point_marchand.idMarchand LEFT JOIN user ON user.id = point_marchand.idUser WHERE 1 = 1';
        $tab = [];
        if(isset($debut)){
            $tDebut = ' AND DATE(point_marchand.created_at) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(point_marchand.created_at) <= :fin';
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
        if(isset($idMarchand)){
            $tidMarchand = ' AND point_marchand.idMarchand = :idMarchand';
            $tab[':idMarchand'] = $idMarchand;
        }else{
            $tidMarchand = '';
        }
        return self::query('SELECT point_marchand.*, user.nom AS nomUser, user.prenom AS prenomUser,user.photo AS photoUser,
        marchand.nom AS nomMarchand, marchand.photo AS photoMarchand FROM '.self::getTable().$where.$tDebut.$tidMarchand.$tFin.$tidUser.$limit,$tab);
    }


}