<?php
/**
 * Created by PhpStorm.
 * User: le marcelo
 * Date: 28/02/2017
 * Time: 12:32
 */

namespace Projet\Database;


use Projet\Model\Table;

class Historique_Carte extends Table{

    protected static $table = 'historique_carte';

    public static function save($idUser,$idCarte,$libCarte,$debut,$fin,$pourcentage,$montant,$minimum,$commission,$carteNumero,$nbre,$id=null){
        $baseParam = [':idUser' => $idUser,':libCarte' => $libCarte,':idCarte' => $idCarte,':montant' => $montant,
            ':debut' => $debut,':fin' => $fin,':pourcentage' => $pourcentage,':carteNumero' => $carteNumero,':commission' => $commission,':nbre' => $nbre,':minimum' => $minimum];
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET idUser = :idUser,idCarte = :idCarte,libCarte = :libCarte,
            debut= :debut,fin= :fin, pourcentage = :pourcentage, montant = :montant,carteNumero = :carteNumero,commission = :commission,nbre = :nbre,minimum = :minimum';
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql,$baseParam,true,true);
    }
    public static function savePrime($idCarte,$libCarte,$debut,$fin,$pourcentage,$minimum,$commission,$carteNumero,$nbre){
        $sql = 'INSERT INTO ' . self::getTable() . ' SET idCarte = :idCarte,libCarte = :libCarte,
            debut= :debut,fin= :fin, pourcentage = :pourcentage, carteNumero = :carteNumero,commission = :commission,nbre = :nbre,minimum = :minimum';
        $param = [':libCarte' => $libCarte,':idCarte' => $idCarte,
            ':debut' => $debut,':fin' => $fin,':pourcentage' => $pourcentage,':carteNumero' => $carteNumero,':commission' => $commission,':nbre' => $nbre,':minimum' => $minimum];
        return self::query($sql, $param, true, true);
    }

    public static function setMoyens($moyens,$id){
        $sql = 'UPDATE ' . self::getTable() . ' SET moyens = :moyens WHERE id = :id';
        $param = [':moyens' => $moyens,':id' => $id];
        return self::query($sql, $param, true, true);
    }

    public static function setIdTransaction($idTransaction,$id){
        $sql = 'UPDATE ' . self::getTable() . ' SET idTransaction = :idTransaction WHERE id = :id';
        $param = [':idTransaction' => $idTransaction,':id' => $id];
        return self::query($sql, $param, true, true);
    }

    public static function update($idCarte,$libCarte,$debut,$fin,$pourcentage,$montant,$minimum,$commission,$nbre,$id){
        $sql = 'UPDATE ' . self::getTable() . ' SET idCarte = :idCarte,libCarte = :libCarte,debut= :debut,fin= :fin, pourcentage = :pourcentage, 
            montant = :montant,commission = :commission,nbre = :nbre,minimum = :minimum WHERE id = :id';
        $param = [':libCarte' => $libCarte,':idCarte' => $idCarte,':montant' => $montant,':debut' => $debut,':fin' => $fin,
            ':pourcentage' => $pourcentage,':id' => $id,':commission' => $commission,':nbre' => $nbre,':minimum' => $minimum];
        return self::query($sql, $param, true, true);
    }

    public static function setEtat($etat,$id){
        $sql = 'UPDATE '.self::getTable().' SET etat = :etat WHERE id = :id ';
        $param = [':etat'=>($etat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setCourant($etat,$id){
        $sql = 'UPDATE '.self::getTable().' SET courant = :etat WHERE id = :id ';
        $param = [':etat'=>($etat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setPrix($prix,$id){
        $sql = 'UPDATE '.self::getTable().' SET prix = :prix WHERE id = :id ';
        $param = [':prix'=>($prix),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setProlongement($prix,$dates,$nbre,$id){
        $sql = 'UPDATE '.self::getTable().' SET dates = :dates,prolonger = :nbre,prix = :prix WHERE id = :id ';
        $param = [':prix'=>($prix),':nbre'=>($nbre),':dates'=>($dates),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setProlonger($dates,$nbre,$id){
        $sql = 'UPDATE '.self::getTable().' SET dates = :dates,prolonger = :nbre WHERE id = :id ';
        $param = [':nbre'=>($nbre),':dates'=>($dates),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function byCode($code){
        $sql = self::selectString() . ' WHERE carteNumero = :code';
        $param = [':code' => $code];
        return self::query($sql, $param,true);
    }

    public static function setIdAdmin($idAdmin,$id){
        $sql = 'UPDATE '.self::getTable().' SET idAdmin = :idAdmin WHERE id = :id ';
        $param = [':idAdmin'=>($idAdmin),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setIdMarchad($idMarchand,$id){
        $sql = 'UPDATE '.self::getTable().' SET idMarchand = :idMarchand WHERE id = :id ';
        $param = [':idMarchand'=>($idMarchand),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setIsValidAdmin($isValidAdmin,$id){
        $sql = 'UPDATE '.self::getTable().' SET isValidAdmin = :isValidAdmin WHERE id = :id ';
        $param = [':isValidAdmin'=>($isValidAdmin),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($idUser=null,$idCarte=null,$debut=null,$fin=null,$idMarchand=null,$etat=null,$search=null){
        $count = 'SELECT COUNT(historique_carte.id) AS Total FROM '.self::getTable();
        $where = ' LEFT JOIN user ON user.id = historique_carte.idUser WHERE 1 = 1';
        $tab = [];
        if(isset($idCarte)){
            $tidCarte = ' AND idCarte = :idCarte';
            $tab[':idCarte'] = $idCarte;
        }else{
            $tidCarte = '';
        }
        if(isset($idUser)){
            $tidUser = ' AND idUser = :idUser';
            $tab[':idUser'] = $idUser;
        }else{
            $tidUser = '';
        }
        if(isset($search)){
            $tsearch = ' AND (historique_carte.carteNumero LIKE :search OR user.prenom LIKE :search OR user.nom LIKE :search OR user.numero LIKE :search)';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tsearch = '';
        }
        if(isset($etat)){
            $tetat = ' AND historique_carte.courant = :etat';
            $tab[':etat'] = $etat;
        }else{
            $tetat = '';
        }
        if(isset($idMarchand)){
            $tidMarchand = ' AND historique_carte.idMarchand = :idMarchand';
            $tab[':idMarchand'] = $idMarchand;
        }else{
            $tidMarchand = '';
        }
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
        return self::query($count.$where.$tidUser.$tidMarchand.$tetat.$tsearch.$tidCarte.$tFin.$tDebut,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$idUser=null,$idCarte=null,$debut=null,$fin=null,$idMarchand=null,$etat=null,$search=null){
        $limit = ' ORDER BY historique_carte.created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' LEFT JOIN user ON user.id = historique_carte.idUser WHERE 1 = 1';
        $tab = [];
        if(isset($idCarte)){
            $tidCarte = ' AND idCarte = :idCarte';
            $tab[':idCarte'] = $idCarte;
        }else{
            $tidCarte = '';
        }
        if(isset($idUser)){
            $tidUser = ' AND idUser = :idUser';
            $tab[':idUser'] = $idUser;
        }else{
            $tidUser = '';
        }
        if(isset($search)){
            $tsearch = ' AND (historique_carte.carteNumero LIKE :search OR user.prenom LIKE :search OR user.nom LIKE :search)';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tsearch = '';
        }
        if(isset($etat)){
            $tetat = ' AND historique_carte.courant = :etat';
            $tab[':etat'] = $etat;
        }else{
            $tetat = '';
        }
        if(isset($idMarchand)){
            $tidMarchand = ' AND historique_carte.idMarchand = :idMarchand';
            $tab[':idMarchand'] = $idMarchand;
        }else{
            $tidMarchand = '';
        }
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
        return self::query('SELECT historique_carte.*, user.nom,user.prenom FROM '.self::getTable().$where.$tidUser.$tetat.$tsearch.$tidMarchand.$tidCarte.$tFin.$tDebut.$limit,$tab);
    }

}