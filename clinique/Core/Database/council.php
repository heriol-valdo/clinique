<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 14/05/2020
 * Time: 07:02
 */

namespace Projet\Database;

use Projet\Model\Table;

class council extends Table {

    protected static $table = 'council';

    public static function save( $userid,$title,$image, $media_type,$status,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().'SET userid= :userid,title= :title,image= :image,media_type= :media_type,status= :status';
        $baseParam = ['userid'=>$userid,'title'=>$title,'image'=>$image,
            'media_type'=>$media_type,'status'=>$status];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function setEtat($etat,$id){
        $sql = 'UPDATE '.self::getTable().' SET status = :etat WHERE id = :id';
        $param = [':etat'=>($etat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($userid=null,$status=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($userid)){
            $tuserid = ' AND userid = :userid';
            $tab[':userid'] = $userid;
        }else{
            $tuserid = '';
        }
        if(isset($status)){
            $tstatus = ' AND status = :status';
            $tab[':status'] = $status;
        }else{
            $tstatus = '';
        }
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
        return self::query($count.$where.$tuserid.$tFin.$tstatus.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$userid=null,$status=null,$debut=null,$fin=null){
        $limit = ' ORDER BY created_on DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($userid)){
            $tuserid = ' AND userid = :userid';
            $tab[':userid'] = $userid;
        }else{
            $tuserid = '';
        }
        if(isset($status)){
            $tstatus = ' AND status = :status';
            $tab[':status'] = $status;
        }else{
            $tstatus = '';
        }
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
        return self::query(self::selectString().$where.$tuserid.$tFin.$tstatus.$tDebut.$limit,$tab);
    }
}