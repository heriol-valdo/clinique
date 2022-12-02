<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 14/05/2020
 * Time: 05:39
 */

namespace Projet\Database;

use Projet\Model\Table;

class category extends  Table
{
    protected static $table = 'category';

    public static function save($category_name,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET category_name= :category_name';
        $baseParam = ['category_name'=>$category_name];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function setImage($path,$id){
        $sql = 'UPDATE '.self::getTable().' SET category_image = :path WHERE id = :id';
        $param = [':path'=>$path,':id'=>$id];
        return self::query($sql,$param,true,true);
    }

    public static function byNom($nom){
        $sql = self::selectString().' WHERE category_name = :nom';
        $param = [':nom'=>$nom];
        return self::query($sql,$param,true);
    }

    public static function countBySearchType($category_name=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($category_name)){
            $tcategory_name = ' AND category_name LIKE :category_name';
            $tab[':category_name'] = '%'.$category_name.'%';
        }else{
            $tcategory_name = '';
        }
        return self::query($count.$where.$tcategory_name,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$category_name=null){
        $limit = ' ORDER BY category_name';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];

        if(isset($category_name)){
            $tcategory_name = ' AND category_name LIKE :category_name';
            $tab[':category_name'] = '%'.$category_name.'%';
        }else{
            $tcategory_name = '';
        }
        return self::query(self::selectString().$where.$tcategory_name.$limit,$tab);
    }

}