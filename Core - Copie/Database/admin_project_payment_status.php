<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 14/05/2020
 * Time: 03:46
 */

namespace Projet\Database;

use Projet\Model\Table;


class admin_project_payment_status extends  Table
{
    protected static $table = 'admin_project_payment_status';

    public static function save($rowid,$affiliate_id,$customer_id,$project_id, $affiliate_comment, $customer_comment,$status,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().'SET rowid= :rowid,affiliate_id= :affiliate_id,customer_id= :customer_id,project_id= :project_id
        affiliate_comment= :affiliate_comment,customer_comment= :customer_comment,status= :status';
        $baseParam = ['rowid'=>$rowid,'affiliate_id'=>$affiliate_id,'customer_id'=>$customer_id,'project_id'=>$project_id,'affiliate_comment'=>$affiliate_comment,'customer_comment'=>$customer_comment,'status'=>$status];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function countBySearchType($rowid=null,$affiliate_id=null,$customer_id=null,$project_id=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($rowid)){
            $trowid = ' AND rowid = :rowid';
            $tab[':rowid'] = $rowid;
        }else{
            $trowid = '';
        }
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
        if(isset($project_id)){
            $tproject_id = ' AND project_id = :project_id';
            $tab[':project_id'] = $project_id;
        }else{
            $tproject_id = '';
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
        return self::query($count.$where.$trowid.$taffiliate_id.$tcustomer_id .$tproject_id.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$rowid=null,
                                      $affiliate_id=null,$customer_id=null,$project_id=null,$debut=null,$fin=null){
        $limit = ' ORDER BY created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($rowid)){
            $trowid = ' AND rowid = :rowid';
            $tab[':rowid'] = $rowid;
        }else{
            $trowid = '';
        }
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
        if(isset($project_id)){
            $tproject_id = ' AND project_id = :project_id';
            $tab[':project_id'] = $project_id;
        }else{
            $tproject_id = '';
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
        return self::query(self::selectString().$where.$trowid.$taffiliate_id.$tcustomer_id.$tproject_id.$tFin.$tDebut.$limit,$tab);
    }
}