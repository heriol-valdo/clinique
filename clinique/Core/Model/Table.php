<?php
/**
 * Created by PhpStorm.
 * Eleve: Poizon
 * Date: 29/06/2015
 * Time: 15:11
 */

namespace Projet\Model;


class Table {

    protected static $table;

    /*public function __get($key){
        $method = 'get'.ucfirst($key);
        $this->$key = $this->$method();
        return $this->$key;
    }*/

    public static function query($statement, $attributes = null, $one = false, $isO = false){
        if($attributes){
            return App::getDb()->prepare($statement,$attributes,get_called_class(),$one, $isO);
        }else{
            return App::getDb()->query($statement, get_called_class(),$one,$isO);
        }

    }

    public static function setCreatedAt($created_at,$id){
        $sql = 'UPDATE '.static::getTable().' SET created_at = :created_at WHERE id = :id';
        $param = [':created_at'=>($created_at),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

	public static function lastId(){
		return App::getDb()->lastInsertId();
	}

    public static function allIn($datas){
        $sql = self::selectString().' WHERE id IN ('.$datas.')';
        return self::query($sql);
    }

    protected  static function selectString(){
        return 'SELECT * FROM '.static::getTable();
    }
    protected static function getTable(){
        if(static::$table === null){
            $class = explode('\\',get_called_class());
            static::$table = ucfirst(end($class));
        }
        return static::$table;
    }

    public static function all(){
        return self::query(static::selectString());
    }

    public static function count(){
        return self::query('SELECT COUNT(*) as Total FROM '.self::getTable(),null,true);
    }

    public static function setIdMarchand($idMarchand,$libMarchand,$id){
        $sql = 'UPDATE '.self::getTable().' SET idMarchand = :idMarchand,libMarchand = :libMarchand WHERE id = :id ';
        $param = [':idMarchand' => $idMarchand,':libMarchand' => $libMarchand,':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setSlug($slug,$id){
        $sql = 'UPDATE '.self::getTable().' SET slug = :slug WHERE id = :id';
        $param = [':slug'=>($slug),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function isSlugExist($slug){
        $sql =self::selectString().' WHERE slug = :slug';
        $param = [':slug'=>($slug)];
        return self::query($sql,$param,true);
    }

    public static function find($id){
        $sql = static::selectString().' WHERE id = :id';
        return self::query($sql,[':id'=>$id],true);
    }
    public static function delete($id){
        $sql = 'DELETE FROM '. self::getTable() .' WHERE id= :id';
        $param =[':id'=>$id];
        return self::query($sql,$param,true,true);
    }
    public static function enregistrer($id=null,$fields){
        $sql_parts = [];
        $attributes = [];
        foreach ($fields as $key => $value){
            $sql_parts[] = "$key = ?";
            $attributes[] = $value;
        }
        if (isset($id)){
            return self::query('UPDATE '.self::getTable().' SET '.$sql_parts.' WHERE id = ?',$attributes,true,true);
        }
        return self::query('INSERT INTO '.self::getTable().' SET '.$sql_parts,$attributes,true,true);
    }
}