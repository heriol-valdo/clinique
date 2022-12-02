<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 14/05/2020
 * Time: 07:39
 */

namespace Projet\Database;

class coupon_users extends  Table
{
    protected static $table = 'coupon_users';

    public static function save( $userid,$coupon_id,$coupon_code, $description,$discount,$start_date,$end_date,$status,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().'SET userid= :userid,coupon_id= :coupon_id,coupon_code= :coupon_code,description= :description,discount= :discount
        ,start_date= :start_date,end_date= :end_date,status= :status';
        $baseParam = ['userid'=>$userid,'coupon_id'=>$coupon_id,'coupon_code'=>$coupon_code,
            'description'=>$description,'discount'=>$discount,'start_date'=>$start_date,'end_date'=>$end_date,'status'=>$status];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function countBySearchType($userid=null,$coupon_id=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($userid)){
            $tuserid = ' AND userid = :userid';
            $tab[':userid'] = $userid;
        }else{
            $tuserid = '';
        }
        if(isset($coupon_id)){
            $tcoupon_id = ' AND coupon_id = :coupon_id';
            $tab[':coupon_id'] = $coupon_id;
        }else{
            $tcoupon_id = '';
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
        return self::query($count.$where.$tuserid.$tcoupon_id.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$userid=null,$coupon_id=null,$debut=null,$fin=null){
        $limit = ' ORDER BY created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];

        if(isset($userid)){
            $tuserid = ' AND userid = :userid';
            $tab[':userid'] = $userid;
        }else{
            $tuserid = '';
        }
        if(isset($coupon_id)){
            $tcoupon_id = ' AND coupon_id = :coupon_id';
            $tab[':coupon_id'] = $coupon_id;
        }else{
            $tcoupon_id = '';
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
        return self::query(self::selectString().$where.$tuserid.$tcoupon_id.$tFin.$tDebut.$limit,$tab);
    }
}