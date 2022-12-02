<?php
/**
 * Created by PhpStorm.
 * User: Ndjeunou
 * Date: 05/11/2018
 * Time: 05:52
 */

namespace Projet\Database;


use Projet\Model\Table;

class Card extends Table {

    protected static $table = 'card';

    public static function find($id){
        $sql = static::selectString().' WHERE iCardId = :id';
        return self::query($sql,[':id'=>$id],true);
    }

}