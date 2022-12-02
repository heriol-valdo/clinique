<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 22/05/2017
 * Time: 11:07
 */

namespace Projet\Database;


use Projet\Model\Table;

class Image extends Table{

    protected static $table = 'image';

    public static function saveA($path,$idArticle){
        $sql = 'INSERT INTO '.self::getTable().' SET path = :path,idArticle = :idArticle';
        $param = [':path'=>$path,':idArticle'=>$idArticle];

        return self::query($sql,$param,true,true);
    }

    public static function saveP($path,$idAnnonce){
        $sql = 'INSERT INTO '.self::getTable().' SET path = :path,idAnnonce = :idAnnonce';
        $param = [':path'=>$path,':idAnnonce'=>$idAnnonce];

        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($idArticle=null,$idAnnonce=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($idArticle)){
            $tidArticle = ' AND idArticle = :idArticle';
            $tab[':idArticle'] = $idArticle;
        }else{
            $tidArticle = '';
        }
        if(isset($idAnnonce)){
            $tidAnnonce = ' AND idAnnonce = :idAnnonce';
            $tab[':idAnnonce'] = $idAnnonce;
        }else{
            $tidAnnonce = '';
        }
        return self::query($count.$where.$tidArticle.$tidAnnonce,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$idArticle=null,$idAnnonce=null){
        $limit = ' ORDER BY created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($idArticle)){
            $tidArticle = ' AND idArticle = :idArticle';
            $tab[':idArticle'] = $idArticle;
        }else{
            $tidArticle = '';
        }
        if(isset($idAnnonce)){
            $tidAnnonce = ' AND idAnnonce = :idAnnonce';
            $tab[':idAnnonce'] = $idAnnonce;
        }else{
            $tidAnnonce = '';
        }
        return self::query(self::selectString().$where.$tidArticle.$tidAnnonce.$limit,$tab);
    }

}