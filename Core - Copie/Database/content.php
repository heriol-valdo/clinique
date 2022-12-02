<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 14/05/2020
 * Time: 06:55
 */

namespace Projet\Database;

use Projet\Model\Table;

class content extends  Table {

    protected static $table = 'content';

    public static function setAbout($about_us,$id){
        $sql = 'UPDATE '.self::getTable().' SET about_us = :about_us WHERE id = :id';
        $param = [':about_us'=>($about_us),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }
    public static function setPolicy($privacy_policy,$id){
        $sql = 'UPDATE '.self::getTable().' SET privacy_policy = :privacy_policy WHERE id = :id';
        $param = [':privacy_policy'=>($privacy_policy),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }
    public static function setTerms($terms_and_conditions,$id){
        $sql = 'UPDATE '.self::getTable().' SET terms_and_conditions = :terms_and_conditions WHERE id = :id';
        $param = [':terms_and_conditions'=>($terms_and_conditions),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

}