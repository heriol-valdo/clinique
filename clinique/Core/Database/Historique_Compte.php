<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 26/08/2015
 * Time: 16:49
 */

namespace Projet\Database;


use Projet\Model\Table;

class Historique_Compte extends Table{
    
    protected static $table = 'historique_compte';

    public static function saveMarchand($idMarchand,$avant,$apres,$montant,$type,$raison,$moyens){
        $sql = 'INSERT INTO '.self::getTable().' SET idMarchand = :idMarchand, avant = :avant, apres = :apres, montant = :montant, moyens = :moyens, raison = :raison, type = :types';
        $param = [':idMarchand'=>($idMarchand),':avant'=>($avant),':montant'=>($montant) ,':apres'=>($apres),':types'=>($type),':raison'=>($raison),':moyens'=>($moyens)];
        return self::query($sql,$param,true,true);
    }

    public static function saveUser($idUser,$avant,$apres,$montant,$type,$raison,$moyens){
        $sql = 'INSERT INTO '.self::getTable().' SET idUser = :idUser, avant = :avant, apres = :apres, montant = :montant, moyens = :moyens, raison = :raison, type = :types,types=2';
        $param = [':idUser'=>($idUser),':avant'=>($avant),':montant'=>($montant) ,':apres'=>($apres),':types'=>($type),':raison'=>($raison),':moyens'=>($moyens)];
        return self::query($sql,$param,true,true);
    }

    public static function setAdmin($idAdmin,$libAdmin,$id){
        $sql = 'UPDATE '.self::getTable().' SET idAdmin = :idAdmin,libAdmin = :libAdmin WHERE id = :id';
        $param = [':idAdmin'=>($idAdmin),':libAdmin'=>($libAdmin),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setEtat($etat,$id){
        $sql = 'UPDATE '.self::getTable().' SET etat = :etat, updated_at = NOW() WHERE id = :id';
        $param = [':etat'=>($etat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setRaison($raison,$id){
        $sql = 'UPDATE '.self::getTable().' SET raison = :raison WHERE id = :id';
        $param = [':raison'=>($raison),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($types = null,$idUser = null,$idMarchand = null,$idAdmin = null,$type = null,$debut=null,$fin=null,$etat=null){
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
        if(isset($idMarchand)){
            $tidMarchand = ' AND idMarchand = :idMarchand';
            $tab[':idMarchand'] = $idMarchand;
        }else{
            $tidMarchand = '';
        }
        if(isset($idAdmin)){
            $tidAdmin = ' AND idAdmin = :idAdmin';
            $tab[':idAdmin'] = $idAdmin;
        }else{
            $tidAdmin = '';
        }
        if(isset($type)){
            $ttype = ' AND type = :type';
            $tab[':type'] = $type;
        }else{
            $ttype = '';
        }
        if(isset($types)){
            $ttypes = ' AND types = :types';
            $tab[':types'] = $types;
        }else{
            $ttypes = '';
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
        return self::query($count.$where.$tDebut.$tFin.$tidUser.$tetat.$ttypes.$tidAdmin.$ttype.$tidMarchand,$tab,true);
    }

    public static function searchType($montantParPage=null,$pageCourante=null,$types = null,$idUser = null,$idMarchand = null, $idAdmin = null,$type = null,$debut=null,$fin=null,$etat=null){
        $limit = ' ORDER BY created_at DESC';
        $limit .= (isset($montantParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$montantParPage).','.$montantParPage:'';
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
        if(isset($idMarchand)){
            $tidMarchand = ' AND idMarchand = :idMarchand';
            $tab[':idMarchand'] = $idMarchand;
        }else{
            $tidMarchand = '';
        }
        if(isset($idAdmin)){
            $tidAdmin = ' AND idAdmin = :idAdmin';
            $tab[':idAdmin'] = $idAdmin;
        }else{
            $tidAdmin = '';
        }
        if(isset($type)){
            $ttype = ' AND type = :type';
            $tab[':type'] = $type;
        }else{
            $ttype = '';
        }
        if(isset($types)){
            $ttypes = ' AND types = :types';
            $tab[':types'] = $types;
        }else{
            $ttypes = '';
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
        return self::query(self::selectString().$where.$tDebut.$ttype.$ttypes.$tidUser.$tetat.$tFin.$tidAdmin.$tidMarchand.$limit,$tab);
    }


}