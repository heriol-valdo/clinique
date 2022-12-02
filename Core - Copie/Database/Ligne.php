<?php
/**
 * Created by PhpStorm.
 * Eleve: Poizon
 * Date: 26/08/2015
 * Time: 16:49
 */

namespace Projet\Database;


use Projet\Model\Table;

class Ligne extends Table{

    protected static $table = 'ligne';

    public static function save($idCommande,$idArticle,$nbre,$prix,$prixTotal,$comission,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET prix = :prix,comission = :comission,nbre = :nbre,idCommande = :idCommande,prixTotal = :prixTotal,idArticle = :idArticle';
        $baseParam = [':prix' => $prix,':nbre' => $nbre,':idCommande' => $idCommande,
            ':prixTotal' => $prixTotal,':idArticle' => $idArticle,':comission' => $comission];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function setEtat($etat,$id){
        $sql = 'UPDATE '.self::getTable().' SET etat = :etat WHERE id = :id';
        $param = [':etat'=>($etat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($idCommande = null,$idArticle = null,$debut=null,$fin=null,$etat=null){
        $count = 'SELECT COUNT(id) AS Total FROM '.self::getTable();
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
        if(isset($idCommande)){
            $tidCommande = ' AND idCommande = :idCommande';
            $tab[':idCommande'] = $idCommande;
        }else{
            $tidCommande = '';
        }
        if(isset($idArticle)){
            $tidArticle = ' AND idArticle = :idArticle';
            $tab[':idArticle'] = $idArticle;
        }else{
            $tidArticle = '';
        }
        if(isset($etat)){
            $tetat = ' AND etat = :etat';
            $tab[':etat'] = $etat;
        }else{
            $tetat = '';
        }
        return self::query($count.$where.$tDebut.$tetat.$tFin.$tidArticle.$tidCommande,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$idCommande = null, $idArticle = null,$debut=null,$fin=null,$etat=null){
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
        if(isset($idCommande)){
            $tidCommande = ' AND idCommande = :idCommande';
            $tab[':idCommande'] = $idCommande;
        }else{
            $tidCommande = '';
        }
        if(isset($idArticle)){
            $tidArticle = ' AND idArticle = :idArticle';
            $tab[':idArticle'] = $idArticle;
        }else{
            $tidArticle = '';
        }
        if(isset($etat)){
            $tetat = ' AND etat = :etat';
            $tab[':etat'] = $etat;
        }else{
            $tetat = '';
        }
        return self::query(self::selectString().$where.$tDebut.$tetat.$tFin.$tidArticle.$tidCommande.$limit,$tab);
    }

}