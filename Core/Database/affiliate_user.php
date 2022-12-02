<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 14/05/2020
 * Time: 05:26
 */

namespace Projet\Database;
 
use Projet\Model\Table;

class affiliate_user extends  Table
{
    protected static $table = 'affiliate_user';

    private static function selects() {
        return 'SELECT u.*, a.status AS etat, a.earnings, a.date, a.id, a.accountnumber, a.routingNumber 
                FROM '.self::getTable().' a LEFT JOIN users u ON u.userid = a.user_id';
    }

    public static function byUser($val){
        $sql = self::selects().' WHERE a.user_id IS NOT NULL AND u.userid IS NOT NULL AND user_id = :val';
        $param = [':val'=>($val)];
        return self::query($sql,$param,true);
    }

    public static function byId($val){
        $sql = self::selects().' WHERE a.user_id IS NOT NULL AND u.userid IS NOT NULL AND id = :val';
        $param = [':val'=>($val)];
        return self::query($sql,$param,true);
    }

    public static function setEtat($etat,$id){
        $sql = 'UPDATE '.self::getTable().' SET status = :etat WHERE id = :id';
        $param = [':etat'=>($etat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($search=null,$gender=null,$status=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' a LEFT JOIN users u ON u.userid = a.user_id WHERE a.user_id IS NOT NULL AND u.userid IS NOT NULL';
        $tab = [];
        if(isset($debut)){
            $tDebut = ' AND DATE(a.date) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(a.date) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        if(isset($search)){
            $tSearch = ' AND (u.username LIKE :search OR u.country LIKE :search OR u.mobile LIKE :search OR u.email LIKE :search OR accountnumber LIKE :search)';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tSearch = '';
        }
        if(isset($gender)){
            $tgender = ' AND u.gender = :gender';
            $tab[':gender'] = $gender;
        }else{
            $tgender = '';
        }
        if(isset($status)){
            $tstatus = ' AND a.status = :status';
            $tab[':status'] = $status;
        }else{
            $tstatus = '';
        }
        return self::query($count.$where.$tSearch.$tgender.$tstatus.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$search=null,$gender=null,$status=null,$debut=null,$fin=null){
        $limit = ' ORDER BY u.username, created_on DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE a.user_id IS NOT NULL AND u.userid IS NOT NULL';
        $tab = [];
        if(isset($debut)){
            $tDebut = ' AND DATE(a.date) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(a.date) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        if(isset($search)){
            $tSearch = ' AND (u.username LIKE :search OR u.country LIKE :search OR u.mobile LIKE :search OR u.email LIKE :search OR accountnumber LIKE :search)';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tSearch = '';
        }
        if(isset($gender)){
            $tgender = ' AND u.gender = :gender';
            $tab[':gender'] = $gender;
        }else{
            $tgender = '';
        }
        if(isset($status)){
            $tstatus = ' AND a.status = :status';
            $tab[':status'] = $status;
        }else{
            $tstatus = '';
        }
        return self::query(self::selects().$where.$tSearch.$tgender.$tstatus.$tFin.$tDebut.$limit,$tab);
    }

}