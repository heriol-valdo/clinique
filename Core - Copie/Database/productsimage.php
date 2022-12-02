<?php
/**
 * Created by PhpStorm.
 * User: Youssef
 * Date: 14/05/2020
 * Time: 03:08
 */

namespace Projet\Database;


use Projet\Model\Table;


class productsimage extends  Table
{
    protected static $table = 'productsimage';

    public static function save($productid,$image,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET image= :image,productid= :productid';
        $baseParam = [':image'=>$image,':productid' =>$productid];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function countBySearchType($productid=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];

        if(isset($productid)){
            $tproductid = ' AND productid = :productid';
            $tab[':productid'] = $productid;
        }else{
            $tproductid = '';
        }

        return self::query($count.$where.$tproductid,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$productid=null){
        $limit = '';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];

        if(isset($productid)){
            $tproductid = ' AND productid = :productid';
            $tab[':productid'] = $productid;
        }else{
            $tproductid = '';
        }

        return self::query(self::selectString().$where.$tproductid.$limit,$tab);
    }
}