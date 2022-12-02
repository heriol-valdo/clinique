<?php
/**
 * Created by PhpStorm.
 * User: Youssef
 * Date: 14/05/2020
 * Time: 03:08
 */

namespace Projet\Database;


use Projet\Model\Table;


class subcategory extends  Table
{
    protected static $table = 'subcategory';

    public static function save($category_id,$subcategory_name,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET subcategory_name= :subcategory_name,category_id= :category_id';
        $baseParam = [':subcategory_name'=>$subcategory_name,':category_id' =>$category_id];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function setImage($path,$id){
        $sql = 'UPDATE '.self::getTable().' SET subcategory_image = :path WHERE id = :id';
        $param = [':path'=>$path,':id'=>$id];
        return self::query($sql,$param,true,true);
    }

    public static function byNom($nom){
        $sql = self::selectString().' WHERE subcategory_name = :nom';
        $param = [':nom'=>$nom];
        return self::query($sql,$param,true);
    }

    public static function countBySearchType($category_id=null,$subcategory_name=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($category_id)){
            $tcategory_id = ' AND category_id = :category_id';
            $tab[':category_id'] = $category_id;
        }else{
            $tcategory_id = '';
        }
        if(isset($subcategory_name)){
            $tsubcategory_name = ' AND subcategory_name LIKE :subcategory_name';
            $tab[':subcategory_name'] = '%'.$subcategory_name.'%';
        }else{
            $tsubcategory_name = '';
        }

        return self::query($count.$where.$tcategory_id.$tsubcategory_name,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$category_id=null,$subcategory_name=null){
        $limit = ' ORDER BY subcategory_name';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($category_id)){
            $tcategory_id = ' AND category_id = :category_id';
            $tab[':category_id'] = $category_id;
        }else{
            $tcategory_id = '';
        }
        if(isset($subcategory_name)){
            $tsubcategory_name = ' AND subcategory_name LIKE :subcategory_name';
            $tab[':subcategory_name'] = '%'.$subcategory_name.'%';
        }else{
            $tsubcategory_name = '';
        }

        return self::query(self::selectString().$where.$tcategory_id.$tsubcategory_name.$limit,$tab);
    }
}