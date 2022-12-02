<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 14/05/2020
 * Time: 09:55
 */

namespace Projet\Database;

use Projet\Model\Table;

class notification extends  Table
{
    protected static $table = 'notification';

    public static function save( $from_id,$to_id,$action,$notification,$status,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().'SET from_id= : from_id,to_id= :checkout_order_i ,action= : action
        , notification= : notification,status= : status';
        $baseParam = ['from_id'=> $from_id,'to_id'=> $to_id,'action'=> $action,'notification'=> $notification,'status'=> $status];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function countBySearchType($from_id=null,$to_id=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];

        if(isset($from_id)){
            $tfrom_id = ' AND from_id = :from_id';
            $tab[':from_id'] = $from_id;
        }else{
            $tfrom_id = '';
        }
        if(isset($to_id)){
            $tto_id = ' AND to_id = :to_id';
            $tab[':to_id'] = $to_id;
        }else{
            $tto_id = '';
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
        return self::query($count.$where.$tfrom_id.$tto_id.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$from_id=null,$to_id=null,$debut=null,$fin=null){
        $limit = ' ORDER BY created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];

        if(isset($from_id)){
            $tfrom_id = ' AND from_id = :from_id';
            $tab[':from_id'] = $from_id;
        }else{
            $tfrom_id = '';
        }
        if(isset($to_id)){
            $tto_id = ' AND to_id = :to_id';
            $tab[':to_id'] = $to_id;
        }else{
            $tto_id = '';
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
        return self::query(self::selectString().$where.$tfrom_id.$tto_id.$tFin.$tDebut.$limit,$tab);
    }
}