<?php
/**
 * Created by PhpStorm.
 * User: Youssef
 * Date: 14/05/2020
 * Time: 03:08
 */

namespace Projet\Database;


use Projet\Model\Table;


class users extends  Table
{
    protected static $table = 'users';

    public static function find($id){
        $sql = static::selectString().' WHERE userid = :id';
        return self::query($sql,[':id'=>$id],true);
    }

    public static function setRole($role,$id){
        $sql = 'UPDATE '.self::getTable().' SET role = :role WHERE userid = :id';
        $param = [':role'=>($role),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setPassword($password,$id){
        $sql = 'UPDATE '.self::getTable().' SET password = :password WHERE userid = :id';
        $param = [':password'=>($password),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setEtat($etat,$id){
        $sql = 'UPDATE '.self::getTable().' SET status = :etat WHERE userid = :id';
        $param = [':etat'=>($etat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($search=null,$gender=null,$status=null,$role=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($debut)){
            $tDebut = ' AND DATE(created_on) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(created_on) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        if(isset($search)){
            $tSearch = ' AND (username LIKE :search OR country LIKE :search OR mobile LIKE :search OR email LIKE :search)';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tSearch = '';
        }
        if(isset($gender)){
            $tgender = ' AND gender = :gender';
            $tab[':gender'] = $gender;
        }else{
            $tgender = '';
        }
        if(isset($status)){
            $tstatus = ' AND status = :status';
            $tab[':status'] = $status;
        }else{
            $tstatus = '';
        }
        if(isset($role)){
            $trole = ' AND role = :role';
            $tab[':role'] = $role;
        }else{
            $trole = '';
        }
        return self::query($count.$where.$tSearch.$tgender.$tstatus.$trole.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$search=null,$gender=null,$status=null,$role=null,$debut=null,$fin=null){
        $limit = ' ORDER BY username, created_on DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($debut)){
            $tDebut = ' AND DATE(created_on) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(created_on) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        if(isset($search)){
            $tSearch = ' AND (username LIKE :search OR country LIKE :search OR mobile LIKE :search OR email LIKE :search)';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tSearch = '';
        }
        if(isset($gender)){
            $tgender = ' AND gender = :gender';
            $tab[':gender'] = $gender;
        }else{
            $tgender = '';
        }
        if(isset($status)){
            $tstatus = ' AND status = :status';
            $tab[':status'] = $status;
        }else{
            $tstatus = '';
        }
        if(isset($role)){
            $trole = ' AND role = :role';
            $tab[':role'] = $role;
        }else{
            $trole = '';
        }
        return self::query(self::selectString().$where.$tSearch.$tgender.$tstatus.$trole.$tFin.$tDebut.$limit,$tab);
    }
}