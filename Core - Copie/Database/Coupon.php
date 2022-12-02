<?php
/**
 * Created by PhpStorm.
 * User: le marcelo
 * Date: 28/02/2017
 * Time: 12:32
 */

namespace Projet\Database;


use Projet\Model\Table;

class Coupon extends Table{

    protected static $table = 'coupon';

    public static function save($idUser,$code,$montant,$minimum,$titre,$fin,$pourcentage,$points){
        $sql = 'INSERT INTO ' . self::getTable() . ' SET idUser = :idUser,points = :points,code = :code,
        minimum= :minimum,titre= :titre,fin= :fin,montant= :montant,pourcentage= :pourcentage';
        $param = [':idUser' => $idUser,':points' => $points,':code' => $code,':titre' => $titre,':fin' => $fin,':minimum' => $minimum,':montant' => $montant,':pourcentage' => $pourcentage];
        return self::query($sql, $param, true, true);
    }

    public static function lastCouponId(){
        $sql = 'SELECT id FROM '.self::getTable() . ' ORDER BY created_at DESC';
        return self::query($sql, null,true);
    }

    public static function byCode($code){
        $sql = self::selectString() . ' WHERE code = :code';
        $param = [':code' => $code];
        return self::query($sql, $param,true);
    }

    public static function setMax($max,$id){
        $sql = 'UPDATE '.self::getTable().' SET max = :max WHERE id = :id ';
        $param = [':max'=>($max),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setEtat($etat,$id){
        $sql = 'UPDATE '.self::getTable().' SET etat = :etat WHERE id = :id ';
        $param = [':etat'=>($etat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setUpdated($date,$id){
        $sql = 'UPDATE '.self::getTable().' SET updated_at = :date, etat = 1 WHERE id = :id ';
        $param = [':date'=>($date),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($idUser=null,$code=null,$debut=null,$fin=null,$idMarchand=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($code)){
            $tcode = ' AND code LIKE :code';
            $tab[':code'] = '%'.$code.'%';
        }else{
            $tcode = '';
        }
        if(isset($idUser)){
            $tidUser = ' AND idUser = :idUser';
            $tab[':idUser'] = $idUser;
        }else{
            $tidUser = '';
        }
        if(isset($idMarchand)){
            $tidMarchand = ' AND coupon.idMarchand = :idMarchand';
            $tab[':idMarchand'] = $idMarchand;
        }else{
            $tidMarchand = '';
        }
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

        return self::query($count.$where.$tidUser.$tidMarchand.$tcode.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$idUser=null,$code=null,$debut=null,$fin=null,$idMarchand=null){
        $limit = ' ORDER BY coupon.created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' LEFT JOIN user ON user.id = coupon.idUser WHERE 1 = 1';
        $tab = [];
        if(isset($code)){
            $tcode = ' AND code LIKE :code';
            $tab[':code'] = '%'.$code.'%';
        }else{
            $tcode = '';
        }
        if(isset($idUser)){
            $tidUser = ' AND idUser = :idUser';
            $tab[':idUser'] = $idUser;
        }else{
            $tidUser = '';
        }
        if(isset($idMarchand)){
            $tidMarchand = ' AND coupon.idMarchand = :idMarchand';
            $tab[':idMarchand'] = $idMarchand;
        }else{
            $tidMarchand = '';
        }
        if(isset($debut)){
            $tDebut = ' AND DATE(coupon.created_at) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(coupon.created_at) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        return self::query('SELECT coupon.*, user.nom,user.prenom FROM '.self::getTable().$where.$tidUser.$tidMarchand.$tcode.$tFin.$tDebut.$limit,$tab);
    }

}