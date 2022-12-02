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

class Region extends Table
{
    protected static $table = 'region';

    public static function all(){
        return self::query(self::selectString().' ORDER BY intitule');
    }

    public static function save($idPays,$libPays,$intitule,$id=null){
        if(isset($id)){
            $sql = 'UPDATE '.self::getTable().' SET idPays = :idPays,libPays = :libPays,intitule = :intitule WHERE id =:id';
            $param = [':libPays'=>$libPays,':idPays'=>$idPays,':intitule'=>$intitule,':id'=>$id];
        }else{
            $sql = 'INSERT INTO '.self::getTable().' SET idPays = :idPays,libPays = :libPays,intitule = :intitule';
            $param = [':libPays'=>$libPays,':idPays'=>$idPays,':intitule'=>$intitule];
        }
        return self::query($sql,$param,true,true);
    }

    public static function setPays($idPays,$libPays,$id){
        $sql = 'UPDATE '.self::getTable().' SET libPays = :libPays,idPays = :idPays WHERE id = :id ';
        $param = [':libPays'=>($libPays),':idPays'=>($idPays),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function byNom($nom){
        $sql = self::selectString().' WHERE intitule = :nom';
        $param = [':nom'=>$nom];
        return self::query($sql,$param,true);
    }

    public static function countBySearchType($search=null,$idPays=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tsearch = ' AND intitule LIKE :search';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tsearch = '';
        }
        if(isset($idPays)){
            $tidPays = ' AND idPays = :idPays';
            $tab[':idPays'] = $idPays;
        }else{
            $tidPays = '';
        }
        return self::query($count.$where.$tsearch.$tidPays,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$search=null,$idPays=null){
        $limit = ' ORDER BY intitule ASC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($idPays)){
            $tidPays = ' AND idPays = :idPays';
            $tab[':idPays'] = $idPays;
        }else{
            $tidPays = '';
        }
        if(isset($search)){
            $tsearch = ' AND intitule LIKE :search';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tsearch = '';
        }
        return self::query(self::selectString().$where.$tsearch.$tidPays.$limit,$tab);
    }



}