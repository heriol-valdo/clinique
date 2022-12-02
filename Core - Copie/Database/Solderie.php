<?php
/**
 * Created by PhpStorm.
 * Eleve: Poizon
 * Date: 26/08/2015
 * Time: 16:49
 */

namespace Projet\Database;


use Projet\Model\Table;

class Solderie extends Table{

    protected static $table = 'solderie';

    public static function save($idEvenement,$idSouscategorie,$libSousCategorie,$libEvenement,$idArticle,$libArticle,$idUser,$libUser,$pourcentage,$montant,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET idUser = :idUser,montant = :montant,pourcentage = :pourcentage,libSousCategorie = :libSousCategorie,idEvenement = :idEvenement,
        libEvenement = :libEvenement,libArticle = :libArticle,libUser = :libUser,idSousCategorie = :idSouscategorie,idArticle = :idArticle';
        $baseParam = [':idUser' => $idUser,':montant' => $montant,':pourcentage' => $pourcentage,':libSousCategorie' => $libSousCategorie,':idEvenement' => $idEvenement,':libArticle' => $libArticle,
            ':libEvenement' => $libEvenement,':libUser' => $libUser,':idSouscategorie' => $idSouscategorie,':idArticle' => $idArticle];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function countBySearchType($idEvenement = null,$idSouscategorie = null,$idArticle = null,$debut=null,$fin=null,$search=null){
        $count = 'SELECT COUNT(id) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tSearch = ' AND (libArticle LIKE :search OR libEvenement LIKE :search)';
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
        if(isset($idEvenement)){
            $tidEvenement = ' AND idEvenement = :idEvenement';
            $tab[':idEvenement'] = $idEvenement;
        }else{
            $tidEvenement = '';
        }
        if(isset($idSouscategorie)){
            $tidSouscategorie = ' AND idSousCategorie = :idSouscategorie';
            $tab[':idSouscategorie'] = $idSouscategorie;
        }else{
            $tidSouscategorie = '';
        }
        if(isset($idArticle)){
            $tidArticle = ' AND idArticle = :idArticle';
            $tab[':idArticle'] = $idArticle;
        }else{
            $tidArticle = '';
        }
        return self::query($count.$where.$tDebut.$tSearch.$tFin.$tidSouscategorie.$tidArticle.$tidEvenement,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$idEvenement = null,$idSouscategorie = null,$idArticle = null,$debut=null,$fin=null,$search=null){
        $limit = ' ORDER BY created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tSearch = ' AND (libArticle LIKE :search OR libEvenement LIKE :search)';
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
        if(isset($idEvenement)){
            $tidEvenement = ' AND idEvenement = :idEvenement';
            $tab[':idEvenement'] = $idEvenement;
        }else{
            $tidEvenement = '';
        }
        if(isset($idSouscategorie)){
            $tidSouscategorie = ' AND idSousCategorie = :idSouscategorie';
            $tab[':idSouscategorie'] = $idSouscategorie;
        }else{
            $tidSouscategorie = '';
        }
        if(isset($idArticle)){
            $tidArticle = ' AND idArticle = :idArticle';
            $tab[':idArticle'] = $idArticle;
        }else{
            $tidArticle = '';
        }
        return self::query(self::selectString().$where.$tDebut.$tSearch.$tidArticle.$tFin.$tidSouscategorie.$tidEvenement.$limit,$tab);
    }
}