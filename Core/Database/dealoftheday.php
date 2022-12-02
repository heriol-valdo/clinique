<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 14/05/2020
 * Time: 09:32
 */

namespace Projet\Database;


use Projet\Model\Table;

class dealoftheday extends  Table
{
    protected static $table = 'dealoftheday';

    public static function save($title,$starttime,$endtime,$product_id,$price,$description,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().'SET title= :title,starttime= :starttime
        ,endtime= :endtime,price= :price,product_id= :product_id,description= :description';
        $baseParam = ['title'=>$title,'starttime'=>$starttime,'endtime'=>$endtime,'product_id'=>$product_id
            ,'price'=>$price,'description'=>$description];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function setEtat($etat,$id){
        $sql = 'UPDATE '.self::getTable().' SET status = :etat WHERE id = :id';
        $param = [':etat'=>($etat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setImage($image,$id){
        $sql = 'UPDATE '.self::getTable().' SET banner = :image WHERE id = :id';
        $param = [':image'=>($image),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($title=null,$product_id=null,$status=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];

        if(isset($title)){
            $ttitle = ' AND title LIKE :title';
            $tab[':title'] = '%'.$title.'%';
        }else{
            $ttitle = '';
        }
        if(isset($product_id)){
            $tproduct_id = ' AND product_id = :product_id';
            $tab[':product_id'] = $product_id;
        }else{
            $tproduct_id = '';
        }
        if(isset($status)){
            $tstatus = ' AND status = :status';
            $tab[':status'] = $status;
        }else{
            $tstatus = '';
        }
        if(isset($debut)){
            $tDebut = ' AND DATE(starttime) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(endtime) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        return self::query($count.$where.$ttitle.$tproduct_id.$tstatus.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$title=null,$product_id=null,$status=null,$debut=null,$fin=null){
        $limit = ' ORDER BY date DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($title)){
            $ttitle = ' AND title LIKE :title';
            $tab[':title'] = '%'.$title.'%';
        }else{
            $ttitle = '';
        }
        if(isset($product_id)){
            $tproduct_id = ' AND product_id = :product_id';
            $tab[':product_id'] = $product_id;
        }else{
            $tproduct_id = '';
        }
        if(isset($status)){
            $tstatus = ' AND status = :status';
            $tab[':status'] = $status;
        }else{
            $tstatus = '';
        }
        if(isset($debut)){
            $tDebut = ' AND DATE(starttime) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(endtime) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        return self::query(self::selectString().$where.$ttitle.$tproduct_id.$tstatus.$tFin.$tDebut.$limit,$tab);
    }
}