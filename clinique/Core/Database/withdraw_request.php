<?php
/**
 * Created by PhpStorm.
 * User: Youssef
 * Date: 14/05/2020
 * Time: 03:08
 */

namespace Projet\Database;


use Projet\Model\Table;


class withdraw_request extends  Table
{
    protected static $table = 'withdraw_request';

    public static function setEtat($etat,$id){
        $sql = 'UPDATE '.self::getTable().' SET status = :etat WHERE id = :id';
        $param = [':etat'=>($etat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($user_id=null,$status=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total, SUM(amount) AS somme FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($user_id)){
            $tuser_id = ' AND user_id = :user_id';
            $tab[':user_id'] = $user_id;
        }else{
            $tuser_id = '';
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
        return self::query($count.$where.$tuser_id.$tstatus.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$user_id=null,$status=null,$debut=null,$fin=null){
        $limit = ' ORDER BY date DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($user_id)){
            $tuser_id = ' AND user_id = :user_id';
            $tab[':user_id'] = $user_id;
        }else{
            $tuser_id = '';
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
        return self::query(self::selectString().$where.$tuser_id.$tstatus.$tFin.$tDebut.$limit,$tab);
    }
}