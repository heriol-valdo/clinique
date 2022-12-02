<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 26/08/2015
 * Time: 16:49
 */

namespace Projet\Database;


use Projet\Model\Table;

class Historique extends Table{
    
    protected static $table = 'historique';

    public static function save($idArticle,$avant,$apres,$nbre,$type){
        $sql = 'INSERT INTO '.self::getTable().' SET idArticle = :idArticle, avant = :avant, apres = :apres, nbre = :nbre, type = :types';
        $param = [':idArticle'=>($idArticle),':avant'=>($avant),':nbre'=>($nbre) ,':apres'=>($apres),':types'=>($type)];
        return self::query($sql,$param,true,true);
    }

    public static function setPrix($prix,$total,$id){
        $sql = 'UPDATE '.self::getTable().' SET prix = :prix,total = :total WHERE id = :id';
        $param = [':prix'=>($prix),':total'=>($total),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setRaison($raison,$id){
        $sql = 'UPDATE '.self::getTable().' SET raison = :raison WHERE id = :id';
        $param = [':raison'=>($raison),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setAdmin($idAdmin,$libAdmin,$id){
        $sql = 'UPDATE '.self::getTable().' SET idAdmin = :idAdmin,libAdmin = :libAdmin WHERE id = :id';
        $param = [':idAdmin'=>($idAdmin),':libAdmin'=>($libAdmin),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($idArticle = null,$idMarchand = null,$type = null,$debut=null,$fin=null){
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
        if(isset($idArticle)){
            $tidArticle = ' AND idArticle = :idArticle';
            $tab[':idArticle'] = $idArticle;
        }else{
            $tidArticle = '';
        }
        if(isset($idMarchand)){
            $tidMarchand = ' AND idMarchand = :idMarchand';
            $tab[':idMarchand'] = $idMarchand;
        }else{
            $tidMarchand = '';
        }
        if(isset($type)){
            $ttype = ' AND type = :type';
            $tab[':type'] = $type;
        }else{
            $ttype = '';
        }
        return self::query($count.$where.$tDebut.$tFin.$tidMarchand.$ttype.$tidArticle,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$idArticle = null, $idMarchand = null,$type = null,$debut=null,$fin=null){
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
        if(isset($idArticle)){
            $tidArticle = ' AND idArticle = :idArticle';
            $tab[':idArticle'] = $idArticle;
        }else{
            $tidArticle = '';
        }
        if(isset($idMarchand)){
            $tidMarchand = ' AND idMarchand = :idMarchand';
            $tab[':idMarchand'] = $idMarchand;
        }else{
            $tidMarchand = '';
        }
        if(isset($type)){
            $ttype = ' AND type = :type';
            $tab[':type'] = $type;
        }else{
            $ttype = '';
        }
        return self::query(self::selectString().$where.$tDebut.$ttype.$tFin.$tidMarchand.$tidArticle.$limit,$tab);
    }


}