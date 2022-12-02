<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 14/05/2020
 * Time: 08:19
 */

namespace Projet\Database;

use Projet\Model\Table;

class coupons extends  Table {

    protected static $table = 'coupons';

    public static function save( $coupon_code,$description,$discount,$start_date,$end_date,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().'SET coupon_code= :coupon_code,description= :description,discount= :discount
        ,start_date= :start_date,end_date= :end_date';
        $baseParam = ['coupon_code'=>$coupon_code,'description'=>$description,'discount'=>$discount,'start_date'=>$start_date,'end_date'=>$end_date];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function countBySearchType($coupon_code=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($coupon_code)){
            $tcoupon_code = ' AND coupon_code LIKE :coupon_code';
            $tab[':coupon_code'] = '%'.$coupon_code.'%';
        }else{
            $tcoupon_code = '';
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
        return self::query($count.$where.$tcoupon_code.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$coupon_code=null,$debut=null,$fin=null){
        $limit = ' ORDER BY date DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($coupon_code)){
            $tcoupon_code = ' AND coupon_code LIKE :coupon_code';
            $tab[':coupon_code'] = '%'.$coupon_code.'%';
        }else{
            $tcoupon_code = '';
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
        return self::query(self::selectString().$where.$tcoupon_code.$tFin.$tDebut.$limit,$tab);
    }
}