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

class Pays extends Table
{
    protected static $table = 'pays';

    public static function all(){
        return self::query(self::selectString().' ORDER BY intitule');
    }

    public static function save($intitule,$code,$nbre,$id=null){
        if(isset($id)){
            $sql = 'UPDATE '.self::getTable().' SET intitule = :intitule,code = :code,nbre = :nbre WHERE id =:id';
            $param = [':intitule'=>$intitule,':id'=>$id,':nbre'=>$nbre,':code'=>$code];
        }else{
            $sql = 'INSERT INTO '.self::getTable().' SET intitule = :intitule,code = :code,nbre = :nbre';
            $param = [':intitule'=>$intitule,':nbre'=>$nbre,':code'=>$code];
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