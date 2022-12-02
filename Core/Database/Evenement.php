<?php
/**
 * Created by PhpStorm.
 * User: Ndjeunou
 * Date: 23/01/2017
 * Time: 10:15
 */

namespace Projet\Database;


use Projet\Model\Table;

class Evenement extends Table{

    protected static $table = 'evenement';

    public static function save($nom,$pourcentage,$montant,$debut,$fin,$detail,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET pourcentage = :pourcentage,montant = :montant,fin = :fin,nom = :nom,detail = :detail,debut = :debut';
        $baseParam = [':pourcentage' => $pourcentage,':montant' => $montant,':fin' => $fin,':nom' => $nom,':detail' => $detail,':debut' => $debut];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function setImages($images,$id){
        $sql = 'UPDATE '.self::getTable().' SET images = :images WHERE id = :id ';
        $param = [':images' => $images,':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function expired($date){
        $sql = self::selectString().' WHERE fin <= :date';
        $param = [':date'=>($date)];
        return self::query($sql,$param);
    }

    public static function countBySearchType($search=null,$etat=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($debut)){
            $tDebut = ' AND DATE(debut) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(fin) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        if(isset($etat)){
            $tetat = ' AND etat = :etat';
            $tab[':etat'] = $etat;
        }else{
            $tetat = '';
        }
        if(isset($search)){
            $tSearch = ' AND (nom LIKE :search)';
            $tab[':search'] = '%'.($search).'%';
        }else{
            $tSearch = '';
        }
        return self::query($count.$where.$tSearch.$tDebut.$tetat.$tFin,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$search=null,$etat=null,$debut=null,$fin=null){
        $limit = ' ORDER BY nom ASC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($debut)){
            $tDebut = ' AND DATE(debut) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(fin) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        if(isset($etat)){
            $tetat = ' AND etat = :etat';
            $tab[':etat'] = $etat;
        }else{
            $tetat = '';
        }
        if(isset($search)){
            $tSearch = ' AND (nom LIKE :search)';
            $tab[':search'] = '%'.($search).'%';
        }else{
            $tSearch = '';
        }
        return self::query(self::selectString().$where.$tSearch.$tDebut.$tFin.$tetat.$limit,$tab);
    }

}