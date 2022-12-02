<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 14/05/2020
 * Time: 09:56
 */

namespace Projet\Database;

use Projet\Model\Table;

class order_delivery_date extends  Table
{
    protected static $table = 'order_delivery_date';

    public static function save( $order_id,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().'SET order_id= : order_id';
        $baseParam = ['order_id'=> $order_id];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function countBySearchType($order_id=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];

        if(isset($order_id)){
            $torder_id = ' AND order_id = :order_id';
            $tab[':order_id'] = $order_id;
        }else{
            $torder_id = '';
        }

        if(isset($debut)){
            $tDebut = ' AND DATE(delivery_date) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(delivery_date) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        return self::query($count.$where.$torder_id.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$order_id=null,$debut=null,$fin=null){
        $limit = ' ORDER BY created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];

        if(isset($order_id)){
            $torder_id = ' AND order_id = :order_id';
            $tab[':order_id'] = $order_id;
        }else{
            $torder_id = '';
        }

        if(isset($debut)){
            $tDebut = ' AND DATE(date) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(date) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        return self::query(self::selectString().$where.$torder_id.$tFin.$tDebut.$limit,$tab);
    }
}