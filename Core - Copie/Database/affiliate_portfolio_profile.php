<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 14/05/2020
 * Time: 04:38
 */

namespace Projet\Database;


use Projet\Model\Table;


class affiliate_portfolio_profile extends  Table{

    protected static $table = 'affiliate_portfolio_profile';

    public static function byAffilie($val){
        $sql = self::selectString().' WHERE affiliate_id= :val';
        $param = [':val'=>($val)];
        return self::query($sql,$param,true);
    }

    public static function countBySearchType($affiliate_id=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($affiliate_id)){
            $taffiliate_id = ' AND affiliate_id = :affiliate_id';
            $tab[':affiliate_id'] = $affiliate_id;
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
        return self::query($count.$where.$taffiliate_id.$tFin.$tDebut,$tab,true);
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
        return self::query(self::selectString().$where.$taffiliate_id.$tFin.$tDebut.$limit,$tab);
    }
}