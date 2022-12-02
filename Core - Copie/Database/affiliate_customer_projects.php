<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 14/05/2020
 * Time: 04:17
 */

namespace Projet\Database;

use Projet\Model\Table;


class affiliate_customer_projects extends  Table
{
    protected static $table = 'affiliate_customer_projects';

    public static function save( $affiliate_id,
                                 $customer_id,
                                 $customer_project_id,
                                 $status,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().'SET affiliate_id= :affiliate_id,customer_id= :customer_id,customer_project_id= :customer_project_id,status= :status';
        $baseParam = ['affiliate_id'=>$affiliate_id,'customer_id'=>$customer_id,'customer_project_id'=> $customer_project_id,'status'=>$status];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function countBySearchType($affiliate_id=null,$customer_id=null,$customer_project_id=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($affiliate_id)){
            $taffiliate_id = ' AND affiliate_id = :affiliate_id';
            $tab[':affiliate_id'] = $affiliate_id;
        }else{
            $taffiliate_id = '';
        }
        if(isset($customer_id)){
            $tcustomer_id = ' AND customer_id = :customer_id';
            $tab[':customer_id'] = $customer_id;
        }else{
            $tcustomer_id = '';
        }
        if(isset($customer_project_id)){
            $tcustomer_project_id = ' AND customer_project_id = :customer_project_id';
            $tab[':customer_project_id'] = $customer_project_id;
        }else{
            $tcustomer_project_id = '';
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
        return self::query($count.$where.$taffiliate_id.$tcustomer_id .$tcustomer_project_id.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$rowid=null,
                                      $affiliate_id=null,$customer_id=null,$customer_project_id=null,$debut=null,$fin=null){
        $limit = ' ORDER BY created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        
        if(isset($affiliate_id)){
            $taffiliate_id = ' AND affiliate_id = :affiliate_id';
            $tab[':affiliate_id'] = $affiliate_id;
        }else{
            $taffiliate_id = '';
        }
        if(isset($customer_id)){
            $tcustomer_id = ' AND customer_id = :customer_id';
            $tab[':customer_id'] = $customer_id;
        }else{
            $tcustomer_id = '';
        }
        if(isset($customer_project_id)){
            $tcustomer_project_id = ' AND customer_project_id = :customer_project_id';
            $tab[':customer_project_id'] = $customer_project_id;
        }else{
            $tcustomer_project_id = '';
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
        return self::query(self::selectString().$where.$taffiliate_id.$tcustomer_id.$tcustomer_project_id.$tFin.$tDebut.$limit,$tab);
    }
}