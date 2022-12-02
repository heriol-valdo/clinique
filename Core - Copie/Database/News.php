<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 23/09/2015
 * Time: 12:03
 */

namespace Projet\Database;


use Projet\Model\Table;

class News extends Table{

    protected static $table = 'news';

    //liste des patients avec user
    public static function all(){
        $sql = self::selectString() . ' ORDER BY date DESC';
        return self::query($sql,null);
    }
    public static function allLimit(){
        $sql = self::selectString() . ' ORDER BY date DESC LIMIT 6';
        return self::query($sql,null);
    }

    public static function save($titre,$contenu,$image,$id=null){
        $sql = "";
        $param = [];
        if(isset($id)){
            $sql = 'UPDATE '.self::getTable().' SET titre = :titre, contenu = :contenu, image = :image WHERE id = :id';
            $param = [':titre'=>($titre),':contenu'=>$contenu,':image'=>htmlentities($image),':id'=>htmlentities($id)];
        }else{
            $sql = 'INSERT INTO  '.self::getTable().' SET titre = :titre, contenu = :contenu, image = :image';
            $param = [':titre'=>($titre),':contenu'=>$contenu,':image'=>htmlentities($image)];
        }
        return self::query($sql,$param,true,true);
    }

    public static function setVues($nbre,$id){
        $sql = 'UPDATE  '.self::getTable().' SET vues = :nbre WHERE id = :id';
        $param = [':nbre'=>$nbre,':id'=>$id];
        return self::query($sql,$param,true,true);
    }

    public static function setImage($image,$id){
        $sql = 'UPDATE  '.self::getTable().' SET image = :fichier WHERE id = :id';
        $param = [':fichier'=>$image,':id'=>$id];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($search=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tsearch = ' AND titre LIKE :search';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tsearch = '';
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
        return self::query($count.$where.$tsearch.$tDebut.$tFin,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$search=null,$debut=null,$fin=null){
        $limit = ' ORDER BY created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tsearch = ' AND titre LIKE :search';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tsearch = '';
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
        return self::query(self::selectString().$where.$tsearch.$tDebut.$tFin.$limit,$tab);
    }

}