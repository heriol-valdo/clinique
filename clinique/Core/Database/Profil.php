<?php
/**
 * Created by PhpStorm.
 * Eleve: Poizon
 * Date: 26/08/2015
 * Time: 16:49
 */

namespace Projet\Database;


use Projet\Model\Table;

class Profil extends Table{

    protected static $table = 'user';

    public static function save($nom,$prenom,$numero,$sexe,$email,$password,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET prenom = :prenom,numero = :numero,
            nom = :nom,sexe = :sexe,email = :email,password = :password';
        $baseParam = [':prenom' => $prenom,':sexe' => $sexe,':nom' => $nom,
            ':email' => $email,':numero' => $numero,':password' => $password];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function setSolde($solde,$id){
        $sql = 'UPDATE '.self::getTable().' SET solde = :solde WHERE id = :id';
        $param = [':solde'=>($solde),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setCreatedAt($created_at,$id){
        $sql = 'UPDATE '.self::getTable().' SET created_at = :created_at WHERE id = :id';
        $param = [':created_at'=>($created_at),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function allSolde(){
        $sql = 'SELECT SUM(solde) AS somme FROM '.self::getTable().' WHERE roles = 1';
        return self::query($sql, null,true);
    }

    public static function setDetails($idSecteur,$libSecteur,$idHobbie,$libHobbie,$profession,$id){
        $sql = 'UPDATE '.self::getTable().' SET profession = :profession,libHobbie = :libHobbie,idHobbie = :idHobbie,libSecteur = :libSecteur,idSecteur = :idSecteur WHERE id = :id ';
        $param = [':libHobbie'=>($libHobbie),':profession'=>($profession),':idHobbie'=>($idHobbie),':libSecteur'=>($libSecteur),':idSecteur'=>($idSecteur),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setPays($idPays,$libPays,$codePays,$id){
        $sql = 'UPDATE '.self::getTable().' SET codePays = :codePays,libPays = :libPays,idPays = :idPays WHERE id = :id ';
        $param = [':codePays'=>($codePays),':libPays'=>($libPays),':idPays'=>($idPays),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setRegion($idRegion,$libRegion,$id){
        $sql = 'UPDATE '.self::getTable().' SET libRegion = :libRegion,idRegion = :idRegion WHERE id = :id ';
        $param = [':libRegion'=>($libRegion),':idRegion'=>($idRegion),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setSecteur($idSecteur,$libSecteur,$id){
        $sql = 'UPDATE '.self::getTable().' SET libSecteur = :libSecteur,idSecteur = :idSecteur WHERE id = :id ';
        $param = [':libSecteur'=>($libSecteur),':idSecteur'=>($idSecteur),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setLocalisation($idPays,$libPays,$idRegion,$libRegion,$codePays,$id){
        $sql = 'UPDATE '.self::getTable().' SET codePays = :codePays,libRegion = :libRegion,idRegion = :idRegion,libPays = :libPays,idPays = :idPays WHERE id = :id ';
        $param = [':libRegion'=>($libRegion),':codePays'=>($codePays),':idRegion'=>($idRegion),':libPays'=>($libPays),':idPays'=>($idPays),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setAbonnement($idHistory,$carteNumero,$pourcentage,$minimum,$commission,$date,$id){
        $sql = 'UPDATE '.self::getTable().' SET abonnement = :date,commission = :commission,minimum = :minimum,pourcentage = :pourcentage,carteNumero = :carteNumero,idHistory = :idHistory WHERE id = :id ';
        $param = [':date'=>($date),':minimum'=>($minimum),':commission'=>($commission),':pourcentage'=>($pourcentage),':carteNumero'=>($carteNumero),':idHistory'=>($idHistory),':id'=>($id)];
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

    public static function setLastDate($date,$id){
        $sql = 'UPDATE '.self::getTable().' SET lastDate = :date WHERE id = :id';
        $param = [':date'=>($date),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setDateAbonnement($date,$id){
        $sql = 'UPDATE '.self::getTable().' SET abonnement = :date WHERE id = :id';
        $param = [':date'=>($date),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setEtat($etat,$id){
        $sql = 'UPDATE '.self::getTable().' SET etat = :etat WHERE id = :id';
        $param = [':etat'=>($etat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setEtatAbonnement($etat,$id){
        $sql = 'UPDATE '.self::getTable().' SET etatAbonnement = :etat WHERE id = :id';
        $param = [':etat'=>($etat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setRoles($roles,$id){
        $sql = 'UPDATE '.self::getTable().' SET roles = :roles WHERE id = :id';
        $param = [':roles'=>($roles),':id'=>($id)];
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

    public static function byNumeroPlus($numero,$roles){
        $sql = self::selectString() . ' WHERE (numero = :numero OR email = :numero) AND roles = :roles';
        $param = [':numero' => $numero,':roles'=>$roles];
        return self::query($sql, $param,true);
    }

    public static function byEmailPlus($email,$roles){
        $sql = self::selectString() . ' WHERE email = :email AND roles = :roles';
        $param = [':email' => $email,':roles'=>$roles];
        return self::query($sql, $param,true);
    }

    public static function countBySearchType($search = null,$sexe = null,$debut=null,$fin=null,$conDebut = null, $conFin = null, $idProfile = null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tSearch = ' AND (nom LIKE :search OR prenom LIKE :search OR numero LIKE :search OR email LIKE :search)';
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
        if(isset($sexe)){
            $tSexe = ' AND sexe = :sexe';
            $tab[':sexe'] = $sexe;
        }else{
            $tSexe = '';
        }
        if(isset($idProfile)){
            $tidProfile = ' AND idProfile = :idProfile';
            $tab[':idProfile'] = $idProfile;
        }else{
            $tidProfile = '';
        }
        return self::query($count.$where.$tSearch.$tDebut.$tFin.$tidProfile.$tDebutCon.$tFinCon.$tSexe,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$search = null,$sexe = null,$debut=null,$fin=null,$conDebut = null, $conFin = null, $idProfile = null){
        $limit = ' ORDER BY nom ASC, prenom ASC, last_login DESC,created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tSearch = ' AND (nom LIKE :search OR prenom LIKE :search OR numero LIKE :search OR email LIKE :search)';
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
        if(isset($sexe)){
            $tSexe = ' AND sexe = :sexe';
            $tab[':sexe'] = $sexe;
        }else{
            $tSexe = '';
        }
        if(isset($idProfile)){
            $tidProfile = ' AND idProfile = :idProfile';
            $tab[':idProfile'] = $idProfile;
        }else{
            $tidProfile = '';
        }
        return self::query(self::selectString().$where.$tSearch.$tDebut.$tidProfile.$tFin.$tDebutCon.$tFinCon.$tSexe.$limit,$tab);
    }

}