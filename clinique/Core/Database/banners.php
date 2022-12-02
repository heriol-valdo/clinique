<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 14/05/2020
 * Time: 05:33
 */

namespace Projet\Database;

use Projet\Model\Table;

class banners extends  Table
{
    protected static $table = 'banners';

    public static function save( $title,$vr,$banner,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().'SET title= :title,vr= :vr,banner= :banner';
        $baseParam = ['title'=>$title,'vr'=>$vr,'banner'=>$banner];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function countBySearchType($title=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($title)){
            $ttitle = ' AND title LIKE :title';
            $tab[':title'] = '%'.$title.'%';
        }else{
            $ttitle = '';
        }
        return self::query($count.$where.$ttitle,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$title=null){
        $limit = ' ORDER BY title ASC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];

        if(isset($title)){
            $ttitle = ' AND title LIKE :title';
            $tab[':title'] = '%'.$title.'%';
        }else{
            $ttitle = '';
        }
        return self::query(self::selectString().$where.$ttitle.$limit,$tab);
    }

}