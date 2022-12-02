<?php
/**
 * Created by PhpStorm.
 * Eleve: Poizon
 * Date: 26/08/2015
 * Time: 16:49
 */

namespace Projet\Database;


use Projet\Model\Table;

class Salle extends Table{

    protected static $table = 'salle';

    public static function save($nom,$prix,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET nom = :nom,prix = :prix';
        $baseParam = [':prix' => $prix,':nom' => $nom];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function byNom($nom){
        $sql = self::selectString() . ' WHERE nom = :nom';
        $param = [':nom' => $nom];
        return self::query($sql, $param,true);
    }

    public static function countBySearchType($search = null,$debut=null,$fin=null,$etat=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tSearch = ' AND (nom LIKE :search OR prix LIKE :search)';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tSearch = '';
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
        if(isset($etat)){
            $tEtat = ' AND etat = :etat';
            $tab[':etat'] = $etat;
        }else{
            $tEtat = '';
        }

        return self::query($count.$where.$tSearch.$tDebut.$tFin.$tEtat,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$search = null,$debut=null,$fin=null,$etat=null){
        $limit = ' ORDER BY nom ASC, prix ASC,created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tSearch = ' AND (nom LIKE :search OR prix LIKE :search)';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tSearch = '';
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
        if(isset($etat)){
            $tEtat = ' AND etat = :etat';
            $tab[':etat'] = $etat;
        }else{
            $tEtat = '';
        }
        return self::query(self::selectString().$where.$tSearch.$tDebut.$tFin.$tEtat.$limit,$tab);
    }

}