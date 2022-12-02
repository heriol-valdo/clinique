<?php
/**
 * Created by PhpStorm.
 * User: Youssef
 * Date: 14/05/2020
 * Time: 03:08
 */

namespace Projet\Database;


use Projet\Model\Table;


class schedule_meeting extends  Table
{
    protected static $table = 'schedule_meeting ';

    public static function save($affiliate_id,$customer_id,$mode_of_meeting,$status,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().'SET affiliate_id= :affiliate_id,customer_id= :customer_id,mode_of_meeting= :mode_of_meeting,
        status= :status,';
        $baseParam = [':affiliate_id'=>$affiliate_id,':customer_id' =>$customer_id,':mode_of_meeting'=>$mode_of_meeting,
            ':status'=>$status,];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function countBySearchType($affiliate_id=null,$customer_id=null,$mode_of_meeting=null,$status=null,$debut=null,$fin=null){
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
        if(isset($mode_of_meeting)){
            $tmode_of_meeting = ' AND mode_of_meeting = :mode_of_meeting';
            $tab[':mode_of_meeting'] = $mode_of_meeting;
        }else{
            $tmode_of_meeting = '';
        }
        if(isset($status)){
            $tstatus = ' AND status = :status';
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
        return self::query($count.$where.$taffiliate_id.$tcustomer_id.$tFin.$tDebut.$tstatus.$tmode_of_meeting,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$affiliate_id=null,$customer_id=null,$mode_of_meeting=null,$status=null,$debut=null,$fin=null){
        $limit = ' ORDER BY created_date, schedule_meeting.date DESC';
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
        if(isset($mode_of_meeting)){
            $tmode_of_meeting = ' AND mode_of_meeting = :mode_of_meeting';
            $tab[':mode_of_meeting'] = $mode_of_meeting;
        }else{
            $tmode_of_meeting = '';
        }
        if(isset($status)){
            $tstatus = ' AND schedule_meeting.status = :status';
            $tab[':status'] = $status;
        }else{
            $tstatus = '';
        }
        if(isset($debut)){
            $tDebut = ' AND DATE(schedule_meeting.date) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(schedule_meeting.date) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        return self::query(self::selectString().$where.$taffiliate_id.$tcustomer_id.$tFin.$tDebut.$tstatus.$tmode_of_meeting.$limit,$tab);
    }
}