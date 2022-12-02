<?php
/**
 * Created by PhpStorm.
 * User: Youssef
 * Date: 14/05/2020
 * Time: 03:08
 */

namespace Projet\Database;


use Projet\Model\Table;


class role_change_status extends  Table
{
    protected static $table = 'role_change_status';

    public static function save($user_id,$role,$status,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().'SET user_id= :user_id,role= :role,status= :status';
        $baseParam = [':id_user'=>$user_id,':role' =>$role,':status' =>$status];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function countBySearchType($user_id=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($user_id)){
            $tuser_id = ' AND user_id = :user_id';
            $tab[':user_id'] = $user_id;
        }else{
            $tuser_id = '';
        }
        if (isset($status)) {
            $tstatus = ' AND status LIKE :status';
            $tab[':status'] = '%'.$status.'%';
        } else {
            $tstatus = '';
        }
        if (isset($role)) {
            $trole = ' AND status LIKE :role';
            $tab[':role'] = '%'.$role.'%';
        } else {
            $trole = '';
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
        return self::query($count.$where.$tuser_id.$trole.$tstatus.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$user_id=null,$debut=null,$fin=nul){
        $limit = ' ORDER BY created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($user_id)){
            $tuser_id = ' AND user_id = :user_id';
            $tab[':user_id'] = $user_id;
        }else{
            $tuser_id = '';
        }
        if (isset($status)) {
            $tstatus = ' AND status LIKE :status';
            $tab[':status'] = '%'.$status.'%';
        } else {
            $tstatus = '';
        }
        if (isset($role)) {
            $trole = ' AND status LIKE :role';
            $tab[':role'] = '%'.$role.'%';
        } else {
            $trole = '';
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
        return self::query(self::selectString().$where.$tuser_id.$trole.$tstatus.$tFin.$tDebut.$limit,$tab);
    }
}