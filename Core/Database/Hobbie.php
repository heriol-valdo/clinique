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

class Hobbie extends Table
{
    protected static $table = 'hobbie';

    public static function all(){
        return self::query(self::selectString().' ORDER BY intitule');
    }

    public static function save($intitule,$description,$id=null){
        if(isset($id)){
            $sql = 'UPDATE '.self::getTable().' SET intitule = :intitule,description = :description WHERE id =:id';
            $param = [':intitule'=>$intitule,':id'=>$id,':description'=>$description];
        }else{
            $sql = 'INSERT INTO '.self::getTable().' SET intitule = :intitule,description = :description';
            $param = [':intitule'=>$intitule,':description'=>$description];
        }
        return self::query($sql,$param,true,true);
    }

    public static function byNom($nom){
        $sql = self::selectString().' WHERE intitule = :nom';
        $param = [':nom'=>$nom];
        return self::query($sql,$param,true);
    }

    public static function countBySearchType($search=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tsearch = ' AND intitule LIKE :search';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tsearch = '';
        }
        return self::query($count.$where.$tsearch,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$search=null){
        $limit = ' ORDER BY intitule ASC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tsearch = ' AND intitule LIKE :search';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tsearch = '';
        }
        return self::query(self::selectString().$where.$tsearch.$limit,$tab);
    }



}