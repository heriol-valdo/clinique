<?php
/**
 * Created by PhpStorm.
 * User: Youssef
 * Date: 14/05/2020
 * Time: 03:08
 */

namespace Projet\Database;


use Projet\Model\Table;


class wallet extends  Table
{
    protected static $table = 'wallet';

    public static function byUser($val){
        $sql = self::selectString().' WHERE userid = :val';
        $param = [':val'=>($val)];
        return self::query($sql,$param,true);
    }

    public static function setSolde($solde,$id){
        $sql = 'UPDATE '.self::getTable().' SET amount = :solde WHERE id = :id';
        $param = [':solde'=>($solde),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

}