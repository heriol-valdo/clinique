<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 14/05/2020
 * Time: 05:09
 */

namespace Projet\Database;

use Projet\Model\Table;

class affiliate_project_files extends  Table
{
    protected static $table = 'affiliate_project_files';

    public static function save($affiliate_id,$affiliate_project_id,$service_type,$thumbnail,$link,$images,$pdf,$doc,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET affiliate_id= :affiliate_id,affiliate_project_id= :affiliate_project_id,
        service_type= :service_type,thumbnail= :thumbnail,link= :link, image = :images,pdf= :pdf,doc= :doc, date = NOW()';
        $baseParam = ['affiliate_id'=>$affiliate_id,'affiliate_project_id'=>$affiliate_project_id,'service_type'=>$service_type,
            'thumbnail'=>$thumbnail,'link'=>$link,'images'=>$images,'pdf'=>$pdf,'doc'=>$doc];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function exist($project_id){
        $sql =self::selectString().' WHERE affiliate_project_id = :id';
        $param = [':id'=>($project_id)];
        return self::query($sql,$param,true);
    }

    public static function setImage($root,$id){
        $sql = 'UPDATE '.self::getTable().' SET image = :root WHERE id = :id';
        $param = [':root'=>($root),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setPdf($root,$id){
        $sql = 'UPDATE '.self::getTable().' SET pdf = :root WHERE id = :id';
        $param = [':root'=>($root),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setDoc($root,$id){
        $sql = 'UPDATE '.self::getTable().' SET doc = :root WHERE id = :id';
        $param = [':root'=>($root),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($affiliate_id=null,$affiliate_project_id=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($affiliate_id)){
            $taffiliate_id = ' AND affiliate_id = :affiliate_id';
            $tab[':affiliate_id'] = $affiliate_id;
        }else{
            $taffiliate_id = '';
        }
        if(isset($affiliate_project_id)){
            $taffiliate_project_id = ' AND affiliate_project_id = :affiliate_project_id';
            $tab[':affiliate_project_id'] = $affiliate_project_id;
        }else{
            $taffiliate_id = '';
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
        return self::query($count.$where.$taffiliate_id.$taffiliate_project_id.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$affiliate_id=null,$debut=null,$fin=null){
        $limit = ' ORDER BY created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];

        if(isset($affiliate_id)){
            $taffiliate_id = ' AND affiliate_id = :affiliate_id';
            $tab[':affiliate_id'] = $affiliate_id;
        }else{
            $taffiliate_id = '';
        }
        if(isset($affiliate_project_id)){
            $taffiliate_project_id = ' AND affiliate_project_id = :affiliate_project_id';
            $tab[':affiliate_project_id'] = $affiliate_project_id;
        }else{
            $taffiliate_id = '';
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
        return self::query(self::selectString().$where.$taffiliate_id.$taffiliate_project_id.$tFin.$tDebut.$limit,$tab);
    }
}