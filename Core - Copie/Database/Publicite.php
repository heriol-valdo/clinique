<?php
/**
 * Created by PhpStorm.
 * User: le marcelo
 * Date: 28/02/2017
 * Time: 12:32
 */

namespace Projet\Database;


use Projet\Model\Table;

class Publicite extends Table{

    protected static $table = 'publicite';

    public static function save($idMarchand,$priorite,$path,$nom,$lien){
        $sql = 'INSERT INTO ' . self::getTable() . ' SET idMarchand = :idMarchand,priorite = :priorite,nom= :nom,path= :path,lien= :lien';
        $param = [':idMarchand' => $idMarchand,':priorite' => $priorite,':nom' => $nom,':path' => $path,':lien' => $lien];
        return self::query($sql, $param, true, true);
    }

    public static function countBySearchType($idMarchand=null,$priorite=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($priorite)){
            $tpriorite = ' AND priorite = :priorite';
            $tab[':priorite'] = $priorite;
        }else{
            $tpriorite = '';
        }
        if(isset($idMarchand)){
            $tidMarchand = ' AND idMarchand = :idMarchand';
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

        return self::query($count.$where.$tidMarchand.$tpriorite.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$idMarchand=null,$priorite=null,$debut=null,$fin=null){
        $limit = ' ORDER BY priorite DESC, created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($priorite)){
            $tpriorite = ' AND priorite = :priorite';
            $tab[':priorite'] = $priorite;
        }else{
            $tpriorite = '';
        }
        if(isset($idMarchand)){
            $tidMarchand = ' AND idMarchand = :idMarchand';
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
        return self::query(self::selectString().$where.$tidMarchand.$tpriorite.$tFin.$tDebut.$limit,$tab);
    }

}