<?php
/**
 * Created by PhpStorm.
 * User: Youssef
 * Date: 14/05/2020
 * Time: 03:08
 */

namespace Projet\Database;


use Projet\Model\Table;


class tax_list extends  Table{

    protected static $table = 'tax_list';

    public static function save($state_name, $tps, $tvq, $id = null)
    {
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable() . 'SET state_name= :state_name,tps= :tps,tvq= :tvq';
        $baseParam = [':state_name' => $state_name, ':tps' => $tps, ':tvq' => $tvq];
        if (isset($id)) {
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql . $baseSql, $baseParam, true, true);
    }

    public static function byNom($nom){
        $sql = self::selectString().' WHERE state_name = :nom';
        $param = [':nom'=>$nom];
        return self::query($sql,$param,true);
    }

    public static function countBySearchType($state_name=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($state_name)){
            $tstate_name = ' AND state_name LIKE :state_name';
            $tab[':state_name'] = '%'.$state_name.'%';
        }else{
            $tstate_name = '';
        }
        return self::query($count.$where.$tstate_name,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$state_name=null){
        $limit = ' ORDER BY state_name';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($state_name)){
            $tstate_name = ' AND state_name LIKE :state_name';
            $tab[':state_name'] = '%'.$state_name.'%';
        }else{
            $tstate_name = '';
        }
        return self::query(self::selectString().$where.$tstate_name.$limit,$tab);
    }
}