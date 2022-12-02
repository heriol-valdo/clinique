<?php
	/**
	 * Created by PhpStorm.
	 * User: su
	 * Date: 26/10/2015
	 * Time: 07:43
	 */

	namespace Projet\Database;


use Projet\Model\Table;

class Visite extends Table {
	protected static $table = 'visite';

    public static function byIp($ip){
        $sql = 'SELECT COUNT(*) as Total FROM '.self::getTable().' WHERE ip = :ip';
        $param = [':ip'=>htmlspecialchars($ip)];
        return self::query($sql,$param,true);
    }

	public static function save($ip,$location,$pays,$region,$device){
		$sql = 'INSERT INTO '.self::getTable().' SET ip = :ip, location = :location, pays = :pays, region = :region, device = :device';
		$param = [':ip'=>($ip),':location'=>$location,':pays'=>$pays,':region'=>$region,':device'=>$device];
		return self::query($sql,$param,true,true);
	}

	public static function exist($ip,$date){
		$sql = 'SELECT * FROM '.self::getTable().' WHERE ip = :ip AND DATE(date) = :date';
		$param = [':ip'=>htmlspecialchars($ip),':date'=>htmlspecialchars($date)];
		return self::query($sql,$param,true);
	}

	public static function searchType($nbreParPage=null,$pageCourante=null,$debut=null,$fin=null){
        $limit = ' ORDER BY created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
		$tab = [];
        if(isset($debut)){
            $tDebut = ' AND DATE(created_at) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(created_at) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
		return self::query(self::selectString().$where.$tDebut.$tFin.$limit,$tab);

	}

	public static function countBySearchType($debut=null,$fin=null){
		$count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
		$where = ' WHERE 1 = 1';
		$tab = [];
        if(isset($debut)){
            $tDebut = ' AND DATE(created_at) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(created_at) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
		return self::query($count.$where.$tDebut.$tFin,$tab,true);
	}

}