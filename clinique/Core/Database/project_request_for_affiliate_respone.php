<?php
/**
 * Created by PhpStorm.
 * User: Youssef
 * Date: 14/05/2020
 * Time: 03:08
 */

namespace Projet\Database;


use Projet\Model\Table;


class project_request_for_affiliate_respone extends  Table
{
    protected static $table = 'project_request_for_affiliate_respone';

    public static function save($project_request_for_affiliate_id, $affiliate_id, $customer_id,
                                $project_id, $fund_raised, $comment, $status, $id = null)
    {
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable() . 'SET project_request_for_affiliate_id= :project_request_for_affiliate_id,
        affiliate_id= :affiliate_id, customer_id= :customer_id,project_id= :project_id,
        fund_raised= :fund_raised,comment= :comment,status= :status';
        $baseParam = [':project_request_for_affiliate_id' => $project_request_for_affiliate_id, ':affiliate_id' => $affiliate_id,
            ':customer_id' => $customer_id, ':project_id' => $project_id, ':fund_raised' => $fund_raised, ':comment' => $comment,
            ':status' => $status,];
        if (isset($id)) {
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql . $baseSql, $baseParam, true, true);
    }

    public static function countBySearchType($project_request_for_affiliate_id = null, $affiliate_id = null, $customer_id = null,
                                             $project_id = null, $status = null)
    {
        $count = 'SELECT COUNT(*) AS Total FROM ' . self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if (isset($project_request_for_affiliate_id)) {
            $tproject_request_for_affiliate_id = ' AND project_request_for_affiliate_id = :project_request_for_affiliate_id';
            $tab[':project_request_for_affiliate_id'] = $project_request_for_affiliate_id;
        } else {
            $tproject_request_for_affiliate_id = '';
        }
        if (isset($affiliate_id)) {
            $taffiliate_id = ' AND affiliate_id = :affiliate_id';
            $tab[':affiliate_id'] = $affiliate_id;
        } else {
            $taffiliate_id = '';
        }
        if (isset($customer_id)) {
            $tcustomer_id = ' AND customer_id = :customer_id';
            $tab[':customer_id'] = $customer_id;
        } else {
            $tcustomer_id = '';
        }
        if (isset($project_id)) {
            $tproject_id = ' AND project_id <= :project_id';
            $tab[':project_id'] = $project_id;
        } else {
            $tproject_id = '';
        }
        if (isset($status)) {
            $tstatus = ' AND status LIKE :status';
            $tab[':status'] = '%'.$status.'%';
        } else {
            $tstatus = '';
        }
        return self::query($count . $where . $tproject_request_for_affiliate_id . $taffiliate_id . $tproject_id . $tstatus .
            $tcustomer_id, $tab, true);
    }

    public static function searchType($nbreParPage = null, $pageCourante = null, $project_request_for_affiliate_id = null, $affiliate_id = null, $customer_id = null, $project_id = null)
    {
        $limit = ' ORDER BY created_at DESC';
        $limit .= (isset($nbreParPage) && isset($pageCourante)) ? ' LIMIT ' . (($pageCourante - 1) * $nbreParPage) . ',' . $nbreParPage : '';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if (isset($project_request_for_affiliate_id)) {
            $tproject_request_for_affiliate_id = ' AND project_request_for_affiliate_id = :project_request_for_affiliate_id';
            $tab[':project_request_for_affiliate_id'] = $project_request_for_affiliate_id;
        } else {
            $tproject_request_for_affiliate_id = '';
        }
        if (isset($affiliate_id)) {
            $taffiliate_id = ' AND affiliate_id = :affiliate_id';
            $tab[':affiliate_id'] = $affiliate_id;
        } else {
            $taffiliate_id = '';
        }
        if (isset($customer_id)) {
            $tcustomer_id = ' AND customer_id = :customer_id';
            $tab[':customer_id'] = $customer_id;
        } else {
            $tcustomer_id = '';
        }
        if (isset($project_id)) {
            $tproject_id = ' AND project_id <= :project_id';
            $tab[':project_id'] = $project_id;
        } else {
            $tproject_id = '';
        }
        if (isset($status)) {
            $tstatus = ' AND status LIKE :status';
            $tab[':status'] = '%'.$status.'%';
        } else {
            $tstatus = '';
        }
            return self::query(self::selectString() . $where . $tproject_request_for_affiliate_id . $taffiliate_id . $tproject_id .
                $tcustomer_id . $tstatus . $limit, $tab);
        }

}