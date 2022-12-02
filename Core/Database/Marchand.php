<?php
/**
 * Created by PhpStorm.
 * Eleve: Poizon
 * Date: 26/08/2015
 * Time: 16:49
 */

namespace Projet\Database;


use Projet\Model\Table;

class Marchand extends Table{

    protected static $table = 'marchand';

    public static function save($nom,$representant,$nifNumero,$numero,$tradeNom,$adresse,$type,$email,$password,$bp,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET nifNumero = :nifNumero,representant = :representant,numero = :numero,
            nom = :nom,tradeNom = :tradeNom,type = :type,email = :email,
            password = :password,bp = :bp,adresse = :adresse';
        $baseParam = [':nifNumero' => $nifNumero,':representant' => $representant,':tradeNom' => $tradeNom,
            ':adresse' => $adresse,':nom' => $nom,':type' => $type,
            ':email' => $email,':numero' => $numero,':password' => $password,':bp' => $bp];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function setSecteur($idSecteur,$libSecteur,$id){
        $sql = 'UPDATE '.self::getTable().' SET libSecteur = :libSecteur,idSecteur = :idSecteur WHERE id = :id ';
        $param = [':libSecteur'=>($libSecteur),':idSecteur'=>($idSecteur),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setPays($idPays,$libPays,$id){
        $sql = 'UPDATE '.self::getTable().' SET libPays = :libPays,idPays = :idPays WHERE id = :id ';
        $param = [':libPays'=>($libPays),':idPays'=>($idPays),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setRegion($idRegion,$libRegion,$id){
        $sql = 'UPDATE '.self::getTable().' SET libRegion = :libRegion,idRegion = :idRegion WHERE id = :id ';
        $param = [':libRegion'=>($libRegion),':idRegion'=>($idRegion),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setSolde($solde,$id){
        $sql = 'UPDATE '.self::getTable().' SET solde = :solde WHERE id = :id';
        $param = [':solde'=>($solde),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function allSolde(){
        $sql = 'SELECT SUM(solde) AS somme FROM '.self::getTable();
        return self::query($sql, null,true);
    }

    public static function setDetails($idSecteur,$libSecteur,$identifiant,$fix,$id){
        $sql = 'UPDATE '.self::getTable().' SET identifiant = :identifiant,fix = :fix,libSecteur = :libSecteur,idSecteur = :idSecteur WHERE id = :id ';
        $param = [':identifiant'=>($identifiant),':fix'=>($fix),':libSecteur'=>($libSecteur),':idSecteur'=>($idSecteur),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setLocalisation($idPays,$libPays,$idRegion,$libRegion,$id){
        $sql = 'UPDATE '.self::getTable().' SET libRegion = :libRegion,idRegion = :idRegion,libPays = :libPays,idPays = :idPays WHERE id = :id ';
        $param = [':libRegion'=>($libRegion),':idRegion'=>($idRegion),':libPays'=>($libPays),':idPays'=>($idPays),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setLocal($latitude,$longitude,$id){
        $sql = 'UPDATE '.self::getTable().' SET longitude = :longitude,latitude = :latitude WHERE id = :id ';
        $param = [':latitude' => $latitude,':longitude' => $longitude,':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setPoints($points,$id){
        $sql = 'UPDATE '.self::getTable().' SET points = :points WHERE id = :id ';
        $param = [':points'=>($points),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setPoint($idPoint,$libPoint,$id){
        $sql = 'UPDATE '.self::getTable().' SET idPoint = :idPoint,libPoint = :libPoint WHERE id = :id';
        $param = [':idPoint'=>($idPoint),':libPoint'=>($libPoint),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setProfile($idProfile,$libProfile,$privilege,$id){
        $sql = 'UPDATE '.self::getTable().' SET idProfile = :idProfile,libProfile = :libProfile,privilege = :privilege WHERE id = :id';
        $param = [':idProfile'=>($idProfile),':libProfile'=>($libProfile),':privilege'=>($privilege),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setPrivilege($privilege,$id){
        $sql = 'UPDATE '.self::getTable().' SET privilege = :privilege WHERE id = :id ';
        $param = [':privilege'=>($privilege),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setLast_login($date,$id){
        $sql = 'UPDATE '.self::getTable().' SET last_login = :date WHERE id = :id';
        $param = [':date'=>($date),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setEtat($etat,$id){
        $sql = 'UPDATE '.self::getTable().' SET etat = :etat WHERE id = :id';
        $param = [':etat'=>($etat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setType($type,$id){
        $sql = 'UPDATE '.self::getTable().' SET type = :type WHERE id = :id';
        $param = [':type'=>($type),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setPhoto($photo,$id){
        $sql = 'UPDATE '.self::getTable().' SET photo = :photo WHERE id = :id';
        $param = [':photo'=>($photo),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setPassword($password,$id){
        $sql = 'UPDATE '.self::getTable().' SET password = :password WHERE id = :id';
        $param = [':password'=>($password),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function byNumero($numero){
        $sql = self::selectString() . ' WHERE numero = :numero';
        $param = [':numero' => $numero];
        return self::query($sql, $param,true);
    }

    public static function byEmail($email){
        $sql = self::selectString() . ' WHERE email = :email';
        $param = [':email' => $email];
        return self::query($sql, $param,true);
    }

    public static function countBySearchType($type = null,$search = null,$debut=null,$fin=null,$conDebut = null, $conFin = null, $idPays = null, $idRegion = null, $idSecteur = null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tSearch = ' AND (nom LIKE :search OR numero LIKE :search OR email LIKE :search)';
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
        if(isset($conDebut)){
            $tDebutCon = ' AND DATE(last_login) >= :debutCon';
            $tab[':debutCon'] = $conDebut;
        }else{
            $tDebutCon = '';
        }
        if(isset($conFin)){
            $tFinCon = ' AND DATE(last_login) <= :finCon';
            $tab[':finCon'] = $conFin;
        }else{
            $tFinCon = '';
        }
        if(isset($type)){
            $ttype = ' AND type = :type';
            $tab[':type'] = $type;
        }else{
            $ttype = '';
        }
        if(isset($idProfile)){
            $tidProfile = ' AND idProfile = :idProfile';
            $tab[':idProfile'] = $idProfile;
        }else{
            $tidProfile = '';
        }
        if(isset($idPays)){
            $tidPays = ' AND idPays = :idPays';
            $tab[':idPays'] = $idPays;
        }else{
            $tidPays = '';
        }
        if(isset($idRegion)){
            $tidRegion = ' AND idRegion = :idRegion';
            $tab[':idRegion'] = $idRegion;
        }else{
            $tidRegion = '';
        }
        if(isset($idSecteur)){
            $tidSecteur = ' AND idSecteur = :idSecteur';
            $tab[':idSecteur'] = $idSecteur;
        }else{
            $tidSecteur = '';
        }
        if(isset($idHobbie)){
            $tidHobbie = ' AND idHobbie = :idHobbie';
            $tab[':idHobbie'] = $idHobbie;
        }else{
            $tidHobbie = '';
        }
        return self::query($count.$where.$tSearch.$tDebut.$tFin.$tidProfile.$tidPays.$tidRegion.$tidSecteur.$tidHobbie.$ttype.$tDebutCon.$tFinCon,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$type = null,$search = null,$debut=null,$fin=null,$conDebut = null, $conFin = null, $idPays = null, $idRegion = null, $idSecteur = null){
        $limit = ' ORDER BY nom ASC, last_login DESC,created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($idProfile)){
            $tidProfile = ' AND idProfile = :idProfile';
            $tab[':idProfile'] = $idProfile;
        }else{
            $tidProfile = '';
        }
        if(isset($type)){
            $ttype = ' AND type = :type';
            $tab[':type'] = $type;
        }else{
            $ttype = '';
        }
        if(isset($search)){
            $tSearch = ' AND (nom LIKE :search OR numero LIKE :search OR email LIKE :search)';
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
        if(isset($conDebut)){
            $tDebutCon = ' AND DATE(last_login) >= :debutCon';
            $tab[':debutCon'] = $conDebut;
        }else{
            $tDebutCon = '';
        }
        if(isset($conFin)){
            $tFinCon = ' AND DATE(last_login) <= :finCon';
            $tab[':finCon'] = $conFin;
        }else{
            $tFinCon = '';
        }
        if(isset($idPays)){
            $tidPays = ' AND idPays = :idPays';
            $tab[':idPays'] = $idPays;
        }else{
            $tidPays = '';
        }
        if(isset($idRegion)){
            $tidRegion = ' AND idRegion = :idRegion';
            $tab[':idRegion'] = $idRegion;
        }else{
            $tidRegion = '';
        }
        if(isset($idSecteur)){
            $tidSecteur = ' AND idSecteur = :idSecteur';
            $tab[':idSecteur'] = $idSecteur;
        }else{
            $tidSecteur = '';
        }
        if(isset($idHobbie)){
            $tidHobbie = ' AND idHobbie = :idHobbie';
            $tab[':idHobbie'] = $idHobbie;
        }else{
            $tidHobbie = '';
        }
        return self::query(self::selectString().$where.$tSearch.$tDebut.$ttype.$tidProfile.$tidPays.$tidRegion.$tidSecteur.$tidHobbie.$tFin.$tDebutCon.$tFinCon.$limit,$tab);
    }

}