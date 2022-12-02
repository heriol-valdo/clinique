<?php
/**
 * Created by PhpStorm.
 * User: Youssef
 * Date: 14/05/2020
 * Time: 03:08
 */

namespace Projet\Database;


use Projet\Model\Table;


class project_payment extends  Table
{
    protected static $table = 'project_payment';

    public static function countBySearchType($project_request_for_affiliate_row_id=null,$project_id=null,$payment_status=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total, SUM(project_price) AS somme FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($project_request_for_affiliate_row_id)){
            $tproject_request_for_affiliate_row_id = ' AND project_request_for_affiliate_row_id = :project_request_for_affiliate_row_id';
            $tab[':project_request_for_affiliate_row_id'] = $project_request_for_affiliate_row_id;
        }else{
            $tproject_request_for_affiliate_row_id = '';
        }
        if(isset($project_id)){
            $tproject_id = ' AND project_id = :project_id';
            $tab[':project_id'] = $project_id;
        }else{
            $tproject_id = '';
        }
        if(isset($debut)){
            $tDebut = ' AND DATE(created_date) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(created_date) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        if(isset($payment_status)){
            $tpayment_status = ' AND payment_status = :payment_status';
            $tab[':payment_status'] = $payment_status;
        }else{
            $tpayment_status = '';
        }
        return self::query($count.$where.$tproject_request_for_affiliate_row_id.$tproject_id.$tDebut.$tFin.$tpayment_status,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$project_request_for_affiliate_row_id=null,$project_id=null,$payment_status=null,$debut=null,$fin=null){
        $limit = ' ORDER BY created_date DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($project_request_for_affiliate_row_id)){
            $tproject_request_for_affiliate_row_id = ' AND project_request_for_affiliate_row_id = :project_request_for_affiliate_row_id';
            $tab[':project_request_for_affiliate_row_id'] = $project_request_for_affiliate_row_id;
        }else{
            $tproject_request_for_affiliate_row_id = '';
        }
        if(isset($project_id)){
            $tproject_id = ' AND project_id = :project_id';
            $tab[':project_id'] = $project_id;
        }else{
            $tproject_id = '';
        }
        if(isset($debut)){
            $tDebut = ' AND DATE(created_date) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(created_date) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        if(isset($payment_status)){
            $tpayment_status = ' AND payment_status = :payment_status';
            $tab[':payment_status'] = $payment_status;
        }else{
            $tpayment_status = '';
        }
        return self::query(self::selectString().$where.$tproject_request_for_affiliate_row_id.$tproject_id.$tDebut.$tFin.$tpayment_status.$limit,$tab);
    }
}