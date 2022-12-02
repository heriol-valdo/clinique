<?php
/**
 * Created by PhpStorm.
 * Eleve: Poizon
 * Date: 26/08/2015
 * Time: 16:49
 */

namespace Projet\Database;


use Projet\Model\Table;

class Article extends Table{

    protected static $table = 'article';

    public static function save($idCat,$libCat,$idCategorie,$idSouscategorie,$libSousCategorie,$libCategorie,$type,$intitule,$detail,$ref,$prix,$forfait,$autres,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET idCat = :idCat,libCat = :libCat,detail = :detail,forfait = :forfait,prix = :prix,libSousCategorie = :libSousCategorie,idCategorie = :idCategorie,
        libCategorie = :libCategorie,intitule = :intitule,ref = :ref,idSousCategorie = :idSouscategorie,type = :type,autres = :autres';
        $baseParam = [':libCat'=>$libCat,':idCat'=>$idCat,':detail' => $detail,':forfait' => $forfait,':prix' => $prix,':libSousCategorie' => $libSousCategorie,':idCategorie' => $idCategorie,':intitule' => $intitule,
            ':libCategorie' => $libCategorie,':ref' => $ref,':idSouscategorie' => $idSouscategorie,':type' => $type,':autres' => $autres];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function setCat($idCat,$libCat,$id){
        $sql = 'UPDATE '.self::getTable().' SET idCat = :idCat,libCat = :libCat WHERE id = :id';
        $param = [':idCat'=>($idCat),':libCat'=>($libCat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setCategorie($idCat,$libCat,$id){
        $sql = 'UPDATE '.self::getTable().' SET idCategorie = :idCat,libCategorie = :libCat WHERE id = :id';
        $param = [':idCat'=>($idCat),':libCat'=>($libCat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setSous($idCat,$libCat,$id){
        $sql = 'UPDATE '.self::getTable().' SET idSouscategorie = :idCat,libSouscategorie = :libCat WHERE id = :id';
        $param = [':idCat'=>($idCat),':libCat'=>($libCat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setDetail($taille,$couleur,$mots,$id){
        $sql = 'UPDATE '.self::getTable().' SET mots = :mots,couleur = :couleur,taille = :taille WHERE id = :id';
        $param = [':mots' => $mots,':couleur' => $couleur,':taille' => $taille,':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setStock($stock,$id){
        $sql = 'UPDATE '.self::getTable().' SET stock = :stock WHERE id = :id';
        $param = [':stock'=>($stock),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setImage($image,$id){
        $sql = 'UPDATE '.self::getTable().' SET image = :image WHERE id = :id';
        $param = [':image'=>($image),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setReserved($reserved,$id){
        $sql = 'UPDATE '.self::getTable().' SET reserved = :reserved WHERE id = :id';
        $param = [':reserved'=>($reserved),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setFabricant($idFabricant,$libFabricant,$id){
        $sql = 'UPDATE '.self::getTable().' SET idFabricant = :idFabricant,libFabricant = :libFabricant WHERE id = :id';
        $param = [':idFabricant'=>($idFabricant),':libFabricant'=>($libFabricant),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setSolde($solde,$forfait,$deal,$id){
        $sql = 'UPDATE '.self::getTable().' SET solde = :solde,forfait = :forfait,deal = :deal WHERE id = :id';
        $param = [':forfait'=>($forfait),':solde'=>($solde),':deal'=>($deal),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function update($date,$id){
        $sql = 'UPDATE '.self::getTable().' SET updated_at = :date WHERE id = :id';
        $param = [':date'=>($date),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setForfait($forfait,$id){
        $sql = 'UPDATE '.self::getTable().' SET forfait = :forfait WHERE id = :id';
        $param = [':forfait'=>($forfait),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setPromotion($forfait,$pourcentage,$pourcentagePromotion,$montantPromotion,$idPromotion,$id){
        $sql = 'UPDATE '.self::getTable().' SET forfait = :forfait,pourcentagePromotion = :pourcentagePromotion,
        montantPromotion = :montantPromotion,idPromotion = :idPromotion,pourcentage = :pourcentage WHERE id = :id';
        $param = [':forfait'=>($forfait),':pourcentagePromotion'=>($pourcentagePromotion),
            ':montantPromotion'=>($montantPromotion),':pourcentage'=>($pourcentage),':idPromotion'=>($idPromotion),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setAutres($autres,$id){
        $sql = 'UPDATE '.self::getTable().' SET autres = :autres WHERE id = :id';
        $param = [':autres'=>($autres),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setEtat($etat,$id){
        $sql = 'UPDATE '.self::getTable().' SET etat = :etat WHERE id = :id';
        $param = [':etat'=>($etat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function byRef($ref){
        $sql =self::selectString().' WHERE ref = :ref';
        $param = [':ref'=>($ref)];
        return self::query($sql,$param,true);
    }

    public static function setPrix($prix,$id){
        $sql = 'UPDATE '.self::getTable().' SET prix = :prix WHERE id = :id';
        $param = [':prix'=>($prix),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setType($type,$id){
        $sql = 'UPDATE '.self::getTable().' SET type = :type WHERE id = :id';
        $param = [':type'=>($type),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setVues($vues,$id){
        $sql = 'UPDATE '.self::getTable().' SET vues = :vues WHERE id = :id';
        $param = [':vues'=>($vues),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($idCat=null,$idCategorie = null,$idSouscategorie = null,$type = null,$solde = null,$etat = null,$intitule = null,$debut=null,$fin=null,$idFabricant=null,$idMarchand=null,$idPromotion=null){
        $count = 'SELECT COUNT(id) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($etat)){
            $tetat = $etat==2?' AND stock = 0':' AND stock > 0';
        }else{
            $tetat = '';
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
        if(isset($intitule)){
            $tintitule = ' AND (ref LIKE :intitule OR intitule LIKE :intitule OR :intitule LIKE mots)';
            $tab[':intitule'] = '%'.$intitule.'%';
        }else{
            $tintitule = '';
        }
        if(isset($idCategorie)){
            $tidCategorie = ' AND idCategorie = :idCategorie';
            $tab[':idCategorie'] = $idCategorie;
        }else{
            $tidCategorie = '';
        }
        if(isset($idSouscategorie)){
            $tidSouscategorie = ' AND idSousCategorie = :idSouscategorie';
            $tab[':idSouscategorie'] = $idSouscategorie;
        }else{
            $tidSouscategorie = '';
        }
        if(isset($idFabricant)){
            $tidFabricant = ' AND idFabricant = :idFabricant';
            $tab[':idFabricant'] = $idFabricant;
        }else{
            $tidFabricant = '';
        }
        if(isset($type)){
            $ttype = ' AND type = :type';
            $tab[':type'] = $type;
        }else{
            $ttype = '';
        }
        if(isset($solde)){
            $tsolde = $solde==2?' AND forfait = 0':' AND forfait > 0';
        }else{
            $tsolde = '';
        }
        if(isset($idCat)){
            $tidCat = ' AND idCat = :idCat';
            $tab[':idCat'] = $idCat;
        }else{
            $tidCat = '';
        }
        if(isset($idMarchand)){
            $tidMarchand = ' AND idMarchand = :idMarchand';
            $tab[':idMarchand'] = $idMarchand;
        }else{
            $tidMarchand = '';
        }
        if(isset($idPromotion)){
            $tidPromotion = ' AND idPromotion = :idPromotion';
            $tab[':idPromotion'] = $idPromotion;
        }else{
            $tidPromotion = '';
        }
        return self::query($count.$where.$tDebut.$tetat.$tidCat.$tidFabricant.$tsolde.$tidMarchand.$tidPromotion.$tintitule.$tFin.$tidSouscategorie.$ttype.$tidCategorie,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$idCat=null,$idCategorie = null, $idSouscategorie = null,$type = null,$solde = null,$etat = null,$intitule = null,$debut=null,$fin=null,$idFabricant=null,$idMarchand=null,$idPromotion=null){
        $limit = ' ORDER BY id DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($etat)){
            $tetat = $etat==2?' AND stock = 0':' AND stock > 0';
        }else{
            $tetat = '';
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
        if(isset($intitule)){
            $tintitule = ' AND (ref LIKE :intitule OR intitule LIKE :intitule OR :intitule LIKE mots)';
            $tab[':intitule'] = '%'.$intitule.'%';
        }else{
            $tintitule = '';
        }
        if(isset($idCategorie)){
            $tidCategorie = ' AND idCategorie = :idCategorie';
            $tab[':idCategorie'] = $idCategorie;
        }else{
            $tidCategorie = '';
        }
        if(isset($idSouscategorie)){
            $tidSouscategorie = ' AND idSousCategorie = :idSouscategorie';
            $tab[':idSouscategorie'] = $idSouscategorie;
        }else{
            $tidSouscategorie = '';
        }
        if(isset($type)){
            $ttype = ' AND type = :type';
            $tab[':type'] = $type;
        }else{
            $ttype = '';
        }
        if(isset($solde)){
            $tsolde = $solde==2?' AND forfait = 0':' AND forfait > 0';
        }else{
            $tsolde = '';
        }
        if(isset($idFabricant)){
            $tidFabricant = ' AND idFabricant = :idFabricant';
            $tab[':idFabricant'] = $idFabricant;
        }else{
            $tidFabricant = '';
        }
        if(isset($idCat)){
            $tidCat = ' AND idCat = :idCat';
            $tab[':idCat'] = $idCat;
        }else{
            $tidCat = '';
        }
        if(isset($idMarchand)){
            $tidMarchand = ' AND idMarchand = :idMarchand';
            $tab[':idMarchand'] = $idMarchand;
        }else{
            $tidMarchand = '';
        }
        if(isset($idPromotion)){
            $tidPromotion = ' AND idPromotion = :idPromotion';
            $tab[':idPromotion'] = $idPromotion;
        }else{
            $tidPromotion = '';
        }
        return self::query(self::selectString().$where.$tDebut.$tintitule.$tidCat.$tidMarchand.$tidPromotion.$tidFabricant.$tetat.$tsolde.$ttype.$tFin.$tidSouscategorie.$tidCategorie.$limit,$tab);
    }

}