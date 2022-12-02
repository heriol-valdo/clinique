<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 14/05/2020
 * Time: 06:46
 */

namespace Projet\Database;

use Projet\Model\Table;

class comment extends  Table
{
    protected static $table = 'comment';

    public static function save($council_id,$userid,$comments,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().'SET council_id= :council_id,userid= :userid,comments= :comments';
        $baseParam = ['council_id'=>$council_id,'userid'=>$userid,
            'comments'=>$comments];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function countBySearchType($council_id=null,$userid=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($council_id)){
            $tcouncil_id = ' AND council_id = :council_id';
            $tab[':council_id'] = $council_id;
        }else{
            $tcouncil_id = '';
        }
        if(isset($userid)){
            $tuserid = ' AND userid = :userid';
            $tab[':userid'] = $userid;
        }else{
            $tuserid = '';
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
        return self::query($count.$where.$tcouncil_id.$tuserid.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$council_id=null,$userid=null,$debut=null,$fin=null){
        $limit = ' ORDER BY created_on DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];

        if(isset($council_id)){
            $tcouncil_id = ' AND council_id = :council_id';
            $tab[':council_id'] = $council_id;
        }else{
            $tcouncil_id = '';
        }
        if(isset($userid)){
            $tuserid = ' AND userid = :userid';
            $tab[':userid'] = $userid;
        }else{
            $tuserid = '';
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
        return self::query(self::selectString().$where.$tcouncil_id.$tuserid.$tFin.$tDebut.$limit,$tab);
    }
}