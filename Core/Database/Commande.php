<?php
/**
 * Created by PhpStorm.
 * Eleve: Poizon
 * Date: 26/08/2015
 * Time: 16:49
 */

namespace Projet\Database;


use Projet\Model\Table;

class Commande extends Table{

    protected static $table = 'commande';

    public static function save($idUser,$etat,$prix,$comission,$methode,$reference,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET methode = :methode,prix = :prix,idUser = :idUser,
        reference = :reference,etat = :etat,comission = :comission';
        $baseParam = [':methode' => $methode,':prix' => $prix,':idUser' => $idUser,
            ':reference' => $reference,':etat' => $etat,':comission' => $comission];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function setCoupon($forfait,$pourcentage,$idCoupon,$codeCoupon,$id){
        $sql = 'UPDATE '.self::getTable().' SET forfaitCoupon = :forfait,pourcentageCoupon = :pourcentage,codeCoupon = :codeCoupon,idCoupon = :idCoupon WHERE id = :id ';
        $param = [':forfait'=>($forfait),':pourcentage'=>($pourcentage),':codeCoupon'=>($codeCoupon),':idCoupon'=>($idCoupon),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setForfait($forfait,$pourcentage,$id){
        $sql = 'UPDATE '.self::getTable().' SET forfait = :forfait,pourcentage = :pourcentage WHERE id = :id ';
        $param = [':forfait'=>($forfait),':pourcentage'=>($pourcentage),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setUpdate($nom,$prenom,$numero,$adresse,$sexe,$numero2,$id){
        $sql = 'UPDATE '.self::getTable().' SET nom = :nom,sexe = :sexe,adresse = :adresse,prenom = :prenom,
        numero2 = :numero2,numero = :numero WHERE id = :id';
        $param = [':nom'=>($nom),':id'=>($id),':sexe' => $sexe,':adresse' => $adresse,':prenom' => $prenom,
            ':numero2' => $numero2,':numero' => $numero];
        return self::query($sql,$param,true,true);
    }

    public static function setDatePaiement($date,$id){
        $sql = 'UPDATE '.self::getTable().' SET date_paiement = :date WHERE id = :id';
        $param = [':date'=>($date),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setDisponible($disponible,$id){
        $sql = 'UPDATE '.self::getTable().' SET disponible = :disponible WHERE id = :id';
        $param = [':disponible'=>($disponible),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setDateLivraison($date,$id){
        $sql = 'UPDATE '.self::getTable().' SET date_livraison = :date WHERE id = :id';
        $param = [':date'=>($date),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setEtat($etat,$id){
        $sql = 'UPDATE '.self::getTable().' SET etat = :etat WHERE id = :id';
        $param = [':etat'=>($etat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setCoutReel($coutReel,$id){
        $sql = 'UPDATE '.self::getTable().' SET coutReel = :coutReel WHERE id = :id';
        $param = [':coutReel'=>($coutReel),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setComissionCarte($frais,$id){
        $sql = 'UPDATE '.self::getTable().' SET comissionCarte = :frais WHERE id = :id';
        $param = [':frais'=>($frais),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setComission($frais,$id){
        $sql = 'UPDATE '.self::getTable().' SET comission = :frais WHERE id = :id';
        $param = [':frais'=>($frais),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function getSomme($etat,$etats){
        $sql = 'SELECT SUM(coutReel) AS val, SUM(prix) AS valeur FROM '.self::getTable().' WHERE etat = :etat AND etats = :etats';
        $param = [':etat'=>($etat),':etats'=>($etats)];
        return self::query($sql,$param,true);
    }

    public static function getSommes(){
        $sql = 'SELECT SUM(coutReel) AS val, SUM(prix) AS valeur FROM '.self::getTable().' WHERE etat = 2 OR etat = 3';
        return self::query($sql,null,true);
    }

    public static function setEtats($etats,$id){
        $sql = 'UPDATE '.self::getTable().' SET etats = :etats WHERE id = :id';
        $param = [':etats'=>($etats),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setLivraison($livraison,$id){
        $sql = 'UPDATE '.self::getTable().' SET livraison = :livraison WHERE id = :id';
        $param = [':livraison'=>($livraison),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setLivreur($idLivraison,$libLivraison,$bonLivraison,$date,$id){
        $sql = 'UPDATE '.self::getTable().' SET livraison = 1, etat = 3, bonLivraison = :bonLivraison, idLivraison = :idLivraison, libLivraison = :libLivraison, date_livraison = :date WHERE id = :id';
        $param = [':libLivraison'=>($libLivraison),':bonLivraison'=>($bonLivraison),':idLivraison'=>($idLivraison),':date'=>($date),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($idUser = null,$etat = null,$debut=null,$fin=null,$etats=null,$reference=null,$isReceive=null,$idMarchand=null){
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
        if(isset($idUser)){
            $tidUser = ' AND idUser = :idUser';
            $tab[':idUser'] = $idUser;
        }else{
            $tidUser = '';
        }
        if(isset($etat)){
            $tetat = ' AND etat = :etat';
            $tab[':etat'] = $etat;
        }else{
            $tetat = '';
        }
        if(isset($etats)){
            $tetats = ' AND etats = :etats';
            $tab[':etats'] = $etats;
        }else{
            $tetats = '';
        }
        if(isset($isReceive)){
            $tisReceive = ' AND isReceive = :isReceive';
            $tab[':isReceive'] = $isReceive;
        }else{
            $tisReceive = '';
        }
        if(isset($reference)){
            $treference = ' AND reference LIKE :reference';
            $tab[':reference'] = '%'.$reference.'%';
        }else{
            $treference = '';
        }
        if(isset($idMarchand)){
            $tidMarchand = ' AND idMarchand = :idMarchand';
            $tab[':idMarchand'] = $idMarchand;
        }else{
            $tidMarchand = '';
        }
        return self::query($count.$where.$tDebut.$tFin.$tetats.$treference.$tidMarchand.$tisReceive.$tetat.$tidUser,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$idUser = null, $etat = null,$debut=null,$fin=null,$etats=null,$reference=null,$isReceive=null,$idMarchand=null){
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
        if(isset($idUser)){
            $tidUser = ' AND idUser = :idUser';
            $tab[':idUser'] = $idUser;
        }else{
            $tidUser = '';
        }
        if(isset($etat)){
            $tetat = ' AND etat = :etat';
            $tab[':etat'] = $etat;
        }else{
            $tetat = '';
        }
        if(isset($etats)){
            $tetats = ' AND etats = :etats';
            $tab[':etats'] = $etats;
        }else{
            $tetats = '';
        }
        if(isset($isReceive)){
            $tisReceive = ' AND isReceive = :isReceive';
            $tab[':isReceive'] = $isReceive;
        }else{
            $tisReceive = '';
        }
        if(isset($reference)){
            $treference = ' AND reference LIKE :reference';
            $tab[':reference'] = '%'.$reference.'%';
        }else{
            $treference = '';
        }
        if(isset($idMarchand)){
            $tidMarchand = ' AND idMarchand = :idMarchand';
            $tab[':idMarchand'] = $idMarchand;
        }else{
            $tidMarchand = '';
        }
        return self::query(self::selectString().$where.$tDebut.$tetats.$tisReceive.$treference.$tidMarchand.$tFin.$tetat.$tidUser.$limit,$tab);
    }
}