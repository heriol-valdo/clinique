<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 19/05/2017
 * Time: 15:45
 */

namespace Projet\Database;


use Projet\Model\Database;
use Projet\Model\Table;

class Categorie extends Table
{
    protected static $table = 'categorie';

    public static function all(){
        return self::query(self::selectString().' ORDER BY intitule');
    }

    public static function save($idCat,$libCat,$libelle,$description,$id=null){
        if(isset($id)){
            $sql = 'UPDATE '.self::getTable().' SET idCat = :idCat,libCat = :libCat,intitule = :libelle,description = :description WHERE id =:id';
            $param = [':libCat'=>$libCat,':idCat'=>$idCat,':libelle'=>$libelle,':id'=>$id,':description'=>$description];
        }else{
            $sql = 'INSERT INTO '.self::getTable().' SET idCat = :idCat,libCat = :libCat,intitule = :libelle,description = :description';
            $param = [':libCat'=>$libCat,':idCat'=>$idCat,':libelle'=>$libelle,':description'=>$description];
        }
        return self::query($sql,$param,true,true);
    }

    public static function setCat($idCat,$libCat,$id){
        $sql = 'UPDATE '.self::getTable().' SET idCat = :idCat,libCat = :libCat WHERE id = :id';
        $param = [':idCat'=>($idCat),':libCat'=>($libCat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setImages($path,$id){
        $sql = 'UPDATE '.self::getTable().' SET images = :path WHERE id = :id';
        $param = [':path'=>$path,':id'=>$id];
        return self::query($sql,$param,true,true);
    }

    public static function byNom($nom){
        $sql = self::selectString().' WHERE intitule = :nom';
        $param = [':nom'=>$nom];
        return self::query($sql,$param,true);
    }

    public static function countBySearchType($search=null,$idCat=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tsearch = ' AND intitule LIKE :search';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tsearch = '';
        }
        if(isset($idCat)){
            $tidCat = ' AND idCat = :idCat';
            $tab[':idCat'] = $idCat;
        }else{
            $tidCat = '';
        }
        return self::query($count.$where.$tsearch.$tidCat,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$search=null,$idCat=null){
        $limit = ' ORDER BY intitule ASC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($idCat)){
            $tidCat = ' AND idCat = :idCat';
            $tab[':idCat'] = $idCat;
        }else{
            $tidCat = '';
        }
        if(isset($search)){
            $tsearch = ' AND intitule LIKE :search';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tsearch = '';
        }
        return self::query(self::selectString().$where.$tsearch.$tidCat.$limit,$tab);
    }



}