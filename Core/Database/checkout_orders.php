<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 14/05/2020
 * Time: 06:17
 */

namespace Projet\Database;


use Projet\Model\Table;

class checkout_orders extends  Table
{
    protected static $table = 'checkout_orders';
    
    public static function save( $product_id,$qty,$total_paid_price,$product_total_price,
                                 $fName,$lName,$addressLine1,$addressLine2,$phoneNumber,
                                 $provice,$city,$postalCode,$country,
                                 $user_id,$checkout_id,$order_id,$status,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().'SET category_name= :category_name,product_id= :product_id,qty= :qty,
        total_paid_price= :total_paid_price,product_total_price= :product_total_price,product_total_price= :product_total_price,
        fName= :fName,lName= :lName,addressLine1= :addressLine1,addressLine2= :addressLine2,
        phoneNumber= :phoneNumber,provice= :provice,city= :city,ostalCode= :ostalCode,
        country= :country,user_id= :user_id,checkout_id= :checkout_id,order_id= :order_id,
        status= :status';
        $baseParam = ['product_id'=>$product_id,'qty'=>$qty,'total_paid_price'=>$total_paid_price,
            'product_total_price'=>$product_total_price,'product_total_price'=>$product_total_price,
            'fName'=>$fName,'lName'=>$lName,'addressLine1'=>$addressLine1,'addressLine2'=>$addressLine2,
            'phoneNumber'=>$phoneNumber,'provice'=>$provice,'city'=>$city,'postalCode'=>$postalCode,
            'country'=>$country,'user_id'=>$user_id,'checkout_id'=>$checkout_id,
            'order_id'=>$order_id,'status'=>$status];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function countBySearchType($product_id=null,$user_id=null,$status=null,$debut=null,$fin=null,$order_id=null){
        $count = 'SELECT COUNT(*) AS Total, SUM(qty) AS somme FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($order_id)){
            $torder_id = ' AND order_id = :order_id';
            $tab[':order_id'] = $order_id;
        }else{
            $torder_id = '';
        }
        if(isset($product_id)){
            $tproduct_id = ' AND product_id = :product_id';
            $tab[':product_id'] = $product_id;
        }else{
            $tproduct_id = '';
        }
        if(isset($user_id)){
            $tuser_id = ' AND user_id = :user_id';
            $tab[':user_id'] = $user_id;
        }else{
            $tuser_id = '';
        }
        if(isset($status)){
            $tstatus = ' AND (status = :status)';
            $tab[':status'] = $status;
        }else{
            $tstatus = '';
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
        return self::query($count.$where.$tproduct_id.$tuser_id.$torder_id.$tstatus.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$product_id=null,$user_id=null,$status=null,$debut=null,$fin=null,$order_id=null){
        $limit = ' ORDER BY date DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($order_id)){
            $torder_id = ' AND order_id = :order_id';
            $tab[':order_id'] = $order_id;
        }else{
            $torder_id = '';
        }
        if(isset($product_id)){
            $tproduct_id = ' AND product_id = :product_id';
            $tab[':product_id'] = $product_id;
        }else{
            $tproduct_id = '';
        }
        if(isset($user_id)){
            $tuser_id = ' AND user_id = :user_id';
            $tab[':user_id'] = $user_id;
        }else{
            $tuser_id = '';
        }
        if(isset($status)){
            $tstatus = ' AND (status = :status)';
            $tab[':status'] = $status;
        }else{
            $tstatus = '';
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
        return self::query(self::selectString().$where.$tproduct_id.$tuser_id.$torder_id.$tstatus.$tFin.$tDebut.$limit,$tab);
    }

}