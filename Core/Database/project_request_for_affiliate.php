<?php
/**
 * Created by PhpStorm.
 * User: Youssef
 * Date: 14/05/2020
 * Time: 03:08
 */

namespace Projet\Database;


use Projet\Model\Table;


class project_request_for_affiliate extends  Table
{
    protected static $table = 'project_request_for_affiliate';

    public static function countBySearchType($customer_project_reguest_status = null, $affiliate_id = null, $customer_id = null, $project_id = null)
    {
        $count = 'SELECT COUNT(*) AS Total FROM ' . self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
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
            $tproject_id = ' AND project_id = :project_id';
            $tab[':project_id'] = $project_id;
        } else {
            $tproject_id = '';
        }
        if (isset($customer_project_reguest_status)) {
            $tcustomer_project_reguest_status = ' AND customer_project_reguest_status = :customer_project_reguest_status';
            $tab[':customer_project_reguest_status'] = $customer_project_reguest_status;
        } else {
            $tcustomer_project_reguest_status = '';
        }
        return self::query($count . $where . $tcustomer_project_reguest_status . $taffiliate_id . $tproject_id .
            $tcustomer_id, $tab, true);
    }

    public static function searchType($nbreParPage = null, $pageCourante = null, $customer_project_reguest_status = null, $affiliate_id = null, $customer_id = null, $project_id = null)
    {
        $limit = ' ORDER BY date DESC';
        $limit .= (isset($nbreParPage) && isset($pageCourante)) ? ' LIMIT ' . (($pageCourante - 1) * $nbreParPage) . ',' . $nbreParPage : '';
        $where = ' WHERE 1 = 1';
        $tab = [];
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
            $tproject_id = ' AND project_id = :project_id';
            $tab[':project_id'] = $project_id;
        } else {
            $tproject_id = '';
        }
        if (isset($customer_project_reguest_status)) {
            $tcustomer_project_reguest_status = ' AND customer_project_reguest_status = :customer_project_reguest_status';
            $tab[':customer_project_reguest_status'] = $customer_project_reguest_status;
        } else {
            $tcustomer_project_reguest_status = '';
        }
            return self::query(self::selectString() . $where . $tcustomer_project_reguest_status . $taffiliate_id . $tproject_id .
                $tcustomer_id . $limit, $tab);
    }
}
