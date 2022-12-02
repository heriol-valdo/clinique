<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 26/08/2015
 * Time: 16:49
 */

namespace Projet\Database;


use Projet\Model\Table;

class Histo extends Table{
    
    protected static $table = 'histo';

    public static function save($idFournisseur,$idArticle,$libArticle,$avant,$apres,$nbre,$type){
        $sql = 'INSERT INTO '.self::getTable().' SET idArticle = :idArticle,libArticle = :libArticle,avant = :avant, apres = :apres, nbre = :nbre, idFournisseur = :idFournisseur, type = :types';
        $param = [':idArticle'=>($idArticle),':libArticle'=>($libArticle),':avant'=>($avant),':nbre'=>($nbre) ,':apres'=>($apres),':types'=>($type),':idFournisseur'=>($idFournisseur)];
        return self::query($sql,$param,true,true);
    }

    public static function get($type,$idFournisseur,$idArticle){
        $sql = 'SELECT SUM(nbre) AS nbre FROM '.self::getTable().' WHERE idArticle = :idArticle AND idFournisseur = :idFournisseur AND type = :types';
        $param = [':idArticle'=>($idArticle),':idFournisseur'=>($idFournisseur),':types'=>($type)];
        return self::query($sql,$param,true);
    }

    public static function gets($idFournisseur,$idArticle){
        $sql = 'SELECT ((select sum(nbre) as entree from histo where type=1) - (select sum(nbre) as sortie from histo where type=2)) AS nbre FROM '.self::getTable().' WHERE idArticle = :idArticle AND idFournisseur = :idFournisseur';
        $param = [':idArticle'=>($idArticle),':idFournisseur'=>($idFournisseur)];
        return self::query($sql,$param,true);
    }

    public static function countBySearchType($idFournisseur = null,$idArticle = null,$type = null,$debut=null,$fin=null){
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
        if(isset($idFournisseur)){
            $tidFournisseur = ' AND idFournisseur = :idFournisseur';
            $tab[':idFournisseur'] = $idFournisseur;
        }else{
            $tidFournisseur = '';
        }
        if(isset($type)){
            $ttype = ' AND type = :type';
            $tab[':type'] = $type;
        }else{
            $ttype = '';
        }
        return self::query($count.$where.$tDebut.$tFin.$tidFournisseur.$ttype.$tidArticle,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$idFournisseur = null,$idArticle = null, $type = null,$debut=null,$fin=null){
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
        if(isset($idFournisseur)){
            $tidFournisseur = ' AND idFournisseur = :idFournisseur';
            $tab[':idFournisseur'] = $idFournisseur;
        }else{
            $tidFournisseur = '';
        }
        if(isset($type)){
            $ttype = ' AND type = :type';
            $tab[':type'] = $type;
        }else{
            $ttype = '';
        }
        return self::query(self::selectString().$where.$tDebut.$ttype.$tFin.$tidFournisseur.$tidArticle.$limit,$tab);
    }


}