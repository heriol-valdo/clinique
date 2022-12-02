<?php
/**
 * Created by PhpStorm.
 * User: Youssef
 * Date: 14/05/2020
 * Time: 03:08
 */

namespace Projet\Database;


use Projet\Model\Table;


class orders extends  Table
{
    protected static $table = 'orders';

    public static function save($product_id,$checkout_order_id,$checkout_id,$order_id,
                                $user_id,$qty,$product_price,$product_price_currency,
                                $paid_amount,$paid_amount_currency,$wallet_amount_used,
                                $coupon_id,$coupon_discount,$txn_id,$payment_status,$transit_status,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().'SET user_id= :user_id,product_id= :product_id';
        $baseParam = [':id_user'=>$user_id,':product_id' =>$product_id,':checkout_order_id'=>$checkout_order_id,
                        ':checkout_id'=>$checkout_id,':order_id'=>$order_id,':qty'=>$qty,
                        ':product_price'=>$product_price,':product_price_currency'=>$product_price_currency,':paid_amount'=>$paid_amount,
                        ':paid_amount_currency'=>$paid_amount_currency,':wallet_amount_used'=>$wallet_amount_used,':coupon_id'=>$coupon_id,
                        ':coupon_discount'=>$coupon_discount,':txn_id'=>$txn_id,
                        ':payment_status'=>$payment_status,':transit_status'=>$transit_status,];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function countBySearchType($user_id=null,$ref=null,$status=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total, SUM(paid_amount) AS somme FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($user_id)){
            $tuser_id = ' AND user_id = :user_id';
            $tab[':user_id'] = $user_id;
        }else{
            $tuser_id = '';
        }
        if(isset($ref)){
            $tref = ' AND order_id LIKE :ref';
            $tab[':ref'] = '%'.$ref.'%';
        }else{
            $tref = '';
        }
        if(isset($status)){
            $tstatus = ' AND transit_status = :status';
            $tab[':status'] = $status;
        }else{
            $tstatus = '';
        }
        if(isset($debut)){
            $tDebut = ' AND DATE(created_date) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(created_date) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        return self::query($count.$where.$tuser_id.$tref.$tstatus.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$user_id=null,$ref=null,$status=null,$debut=null,$fin=null){
        $limit = ' ORDER BY created_date DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($user_id)){
            $tuser_id = ' AND user_id = :user_id';
            $tab[':user_id'] = $user_id;
        }else{
            $tuser_id = '';
        }
        if(isset($ref)){
            $tref = ' AND order_id LIKE :ref';
            $tab[':ref'] = '%'.$ref.'%';
        }else{
            $tref = '';
        }
        if(isset($status)){
            $tstatus = ' AND transit_status = :status';
            $tab[':status'] = $status;
        }else{
            $tstatus = '';
        }
        if(isset($debut)){
            $tDebut = ' AND DATE(created_date) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(created_date) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        return self::query(self::selectString().$where.$tuser_id.$tref.$tstatus.$tFin.$tDebut.$limit,$tab);
    }

    public static function setStatus($transit_status,$id){
        $sql = 'UPDATE '.self::getTable().' SET transit_status = :transit_status WHERE id = :id';
        $param = [':transit_status'=>($transit_status),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }
    public static function setDateDelivery($date,$id){
        $sql = 'UPDATE '.self::getTable().' SET date_delivery = :date WHERE id = :id';
        $param = [':date'=>($date),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }
    public static function setDeliveryDate($date,$id){
        $sql = 'UPDATE '.self::getTable().' SET delivery_date = :date WHERE id = :id';
        $param = [':date'=>($date),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

}