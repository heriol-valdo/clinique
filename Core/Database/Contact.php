<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 05/11/2015
 * Time: 08:28
 */

namespace Projet\Database;


use Projet\Model\Table;

class Contact extends Table{

    protected static $table = 'contact';

    public static function save($nom,$email,$numero,$sujet,$message){
        $sql = 'INSERT INTO '.self::getTable().' SET nom = :nom, numero = :numero, email = :email, sujet = :sujet, message = :message';
        $param = [':nom'=>($nom),':numero'=>($numero),':email'=>($email),':sujet'=>($sujet),':message'=>($message)];
        return self::query($sql,$param,true,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$debut=null,$fin=null){
        $limit = ' ORDER BY created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($debut)){
            $tDebut = ' AND DATE(created_at) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(created_at) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        return self::query(self::selectString().$where.$tDebut.$tFin.$limit,$tab);

    }

    public static function countBySearchType($debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($debut)){
            $tDebut = ' AND DATE(created_at) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(created_at) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        return self::query($count.$where.$tDebut.$tFin,$tab,true);
    }

}