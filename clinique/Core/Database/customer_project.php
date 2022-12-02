<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 14/05/2020
 * Time: 08:29
 */

namespace Projet\Database;

use Projet\Model\Table;

class customer_project extends Table {

    protected static $table = 'customer_project';

    public static function countBySearchType($customer_id=null,$affiliate_id=null,$project_name=null,$status=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($customer_id)){
            $tcustomer_id = ' AND customer_id = :customer_id';
            $tab[':customer_id'] = $customer_id;
        }else{
            $tcustomer_id = '';
        }
        if(isset($project_name)){
            $tproject_name = ' AND project_name LIKE :project_name';
            $tab[':project_name'] = '%'.$project_name.'%';
        }else{
            $tproject_name = '';
        }
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
        if(isset($status)){
            $tstatus = ' AND status = :status';
            $tab[':status'] = $status;
        }else{
            $tstatus = '';
        }
        return self::query($count.$where.$tcustomer_id.$tstatus.$tproject_name.$taffiliate_id.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$customer_id=null,$affiliate_id=null,$project_name=null,$status=null,$debut=null,$fin=null){
        $limit = ' ORDER BY date DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($status)){
            $tstatus = ' AND status = :status';
            $tab[':status'] = $status;
        }else{
            $tstatus = '';
        }
        if(isset($customer_id)){
            $tcustomer_id = ' AND customer_id = :customer_id';
            $tab[':customer_id'] = $customer_id;
        }else{
            $tcustomer_id = '';
        }
        if(isset($project_name)){
            $tproject_name = ' AND project_name LIKE :project_name';
            $tab[':project_name'] = '%'.$project_name.'%';
        }else{
            $tproject_name = '';
        }
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
        return self::query(self::selectString().$where.$tcustomer_id.$tstatus.$tproject_name.$taffiliate_id.$tFin.$tDebut.$limit,$tab);
    }
}