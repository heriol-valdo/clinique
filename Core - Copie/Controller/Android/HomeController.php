<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 23/01/2017
 * Time: 09:19
 */

namespace Projet\Controller\Android;


use Exception;
use Projet\Database\Branche;
use Projet\Database\Absence;
use Projet\Database\Mandataire;
use Projet\Database\Paiement;
use Projet\Database\Partenaire;
use Projet\Database\Rapport;
use Projet\Database\Transaction;
use Projet\Database\Transfert;
use Projet\Database\Profil;
use Projet\Model\App;
use Projet\Model\Random;
use Projet\Model\Sms;
use Projet\Model\StringHelper;

class HomeController{

    public function login(){
        $return = [];
        header('content-type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(!empty($data)){
                if(isset($data["numero"])&&!empty($data["numero"])&&isset($data["password"])&&!empty($data["password"])){
                    $login = StringHelper::getPhone($data["numero"]);
                    $password = $data["password"];
                    $agency = Branche::byLogin($login);
                    if($agency){
                        if($agency->password == sha1($password)){
                            $partenaire = Partenaire::find($agency->idPartenaire);
                            $message = "You have been successfully logged into your account";
                            $return = array("statuts" => 0, "partenaire" => $partenaire, "agency" => $agency, "mes" => $message);
                        }else{
                            $return = array("statuts" => 1, "mes" => "Your password is incorrect");
                        }
                    }else{
                        $return = array("statuts" => 1, "mes" => "There is no agency attached to this login");
                    }
                }else{
                    $message = "Please tape all required fields";
                    $return = array("statuts" => 1, "mes" => $message);
                }
            }else{
                $message = "An error appear, please reload";
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = "An error appear, please reload";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function solde(){
        $return = [];
        header('content-type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(!empty($data)){
                if(isset($data["id"])&&!empty($data["id"])){
                    $id = (int)$data["id"];
                    $agence = Branche::find($id);
                    if($agence){
                        $compte = Absence::byUser($agence->idPartenaire,1);
                        if($compte){
                            $return = array("statuts" => 0, "mes" => $compte->solde);
                        }else{
                            $return = array("statuts" => 1, "mes" => "Your agency's account is locked, please contact an administrator");
                        }
                    }else{
                        $return = array("statuts" => 1, "mes" => "This agency don't have rights to make Sesame transaction");
                    }
                }else{
                    $message = "Please tape all required fields";
                    $return = array("statuts" => 1, "mes" => $message);
                }
            }else{
                $message = "An error appear, please reload";
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = "An error appear, please reload";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function token(){
        $return = [];
        header('content-type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(!empty($data)){
                if(isset($data["amount"])&&!empty($data["amount"])&&isset($data["login"])&&!empty($data["login"])
                    &&isset($data["id"])&&!empty($data["id"])){
                    $login = StringHelper::getPhone($data["login"]);
                    $amount = (int)$data["amount"];
                    $id = (int)$data["id"];
                    $user = Profil::byLogin($login);
                    if($user&&$user->roles=='ROLE_USER'){
                        if($user->etat == 1){
                            $agence = Branche::find($id);
                            if($agence){
                                $compte = Absence::byUser($agence->idPartenaire,1);
                                if($compte&&$agence->etat==1){
                                    if((int)$user->solde>=$amount){
                                        $token = Random::number(7);
                                        Sms::resultSms($user->numero,"$token is the ID of the transaction to validate the payment of ".number_format($amount)." XOF\nSesame Team","Sesame");
                                        $return = array("statuts" => 0, "token" => $token);
                                    }else{
                                        $return = array("statuts" => 1, "mes" => "You don't have enough money in your account");
                                    }
                                }else{
                                    $return = array("statuts" => 1, "mes" => "Your agency's account is locked, please contact an administrator");
                                }
                            }else{
                                $return = array("statuts" => 1, "mes" => "This agency don't have rights to make Sesame transaction");
                            }
                        }else{
                            $return = array("statuts" => 1, "mes" => "Your account is locked, please contact an administrator");
                        }
                    }else{
                        $return = array("statuts" => 1, "mes" => "There is no account attached to this login");
                    }
                }else{
                    $message = "Please tape all required fields";
                    $return = array("statuts" => 1, "mes" => $message);
                }
            }else{
                $message = "An error appear, please reload";
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = "An error appear, please reload";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function check(){
        $return = [];
        header('content-type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(!empty($data)){
                if(isset($data["login"])&&!empty($data["login"])&&isset($data["title"])&&!empty($data["title"])
                    &&isset($data["id"])&&!empty($data["id"])&&isset($data["amount"])&&!empty($data["amount"])){
                    $login = StringHelper::getPhone($data["login"]);
                    $title = $data["title"];
                    $amount = (int)$data["amount"];
                    $id = (int)$data["id"];
                    $user = Profil::byLogin($login);
                    if($user){
                        if($user->etat == 1){
                            $agence = Branche::find($id);
                            if($agence){
                                $compte = Absence::byUser($agence->idPartenaire,1);
                                if($compte&&$agence->etat==1){
                                    if((int)$user->solde>=$amount){
                                        $newSolde = (int)$user->solde-$amount;
                                        $pdo = App::getDb()->getPDO();
                                        try{
                                            $pdo->beginTransaction();
                                            $reference = Random::reference();
                                            while (Transaction::byReference($reference)){
                                                $reference = Random::reference();
                                            }
                                            Transaction::save($user->idCompte,$amount,2,"Payment by account",$reference,(int)$user->solde,$newSolde,0);
                                            $idTransaction = Transaction::lastId();
                                            Transaction::setEtat($idTransaction,1);
                                            $ref = Random::reference();
                                            while (Transaction::byReference($ref)){
                                                $ref = Random::reference();
                                            }
                                            Transaction::save($compte->id,$amount,1,"Payment by account",$ref,(int)$compte->solde,(int)$compte->solde+$amount,0);
                                            $idTransac = Transaction::lastId();
                                            Paiement::save($user->id,$agence->idPartenaire,$idTransac,$title);
                                            Transaction::setBranche($idTransac,$id);
                                            Transaction::setEtat($idTransac,1);
                                            Absence::setSolde((int)$compte->solde+$amount,$compte->id);
                                            Absence::setSolde($newSolde,$user->idCompte);
                                            Sms::resultSms($agence->numero,"Hi $agence->nom, you have received a money transfer of ".number_format($amount)." XOF in your account.\nRef transaction: $reference.\nSesame team","Sesame");
                                            $rapport = Rapport::byDate(date(MYSQL_DATE_FORMAT));
                                            if($rapport){
                                                Rapport::save($rapport->entree,$rapport->sortie,(int)$rapport->sommeTransfert+$amount,$rapport->commission,$rapport->id);
                                            }else{
                                                Rapport::save(0,0,$amount,0);
                                            }
                                            $message = "The money transfert was carried out successfully, your account has been credited";
                                            $pdo->commit();
                                            $return = array("statuts" => 0, "mes" => $message);
                                        }catch (Exception $e){
                                            $pdo->rollBack();
                                            $message = "An error appear, please reload";
                                            $return = array("statuts" => 1, "mes" => $message);
                                        }
                                    }else{
                                        $return = array("statuts" => 1, "mes" => "You don't have enough money in your account");
                                    }
                                }else{
                                    $return = array("statuts" => 1, "mes" => "Your agency's account is locked, please contact an administrator");
                                }
                            }else{
                                $return = array("statuts" => 1, "mes" => "This agency don't have rights to make Sesame transaction");
                            }
                        }else{
                            $return = array("statuts" => 1, "mes" => "Your account is locked, please contact an administrator");
                        }
                    }else{
                        $return = array("statuts" => 1, "mes" => "There is no account attached to this login");
                    }
                }else{
                    $message = "Please tape all required fields";
                    $return = array("statuts" => 1, "mes" => $message);
                }
            }else{
                $message = "An error appear, please reload";
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = "An error appear, please reload";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function profil(){
        $return = [];
        header('content-type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(!empty($data)){
                if(isset($data["id"])&&!empty($data["id"])){
                    $id = $data["id"];
                    $user = Profil::find($id);
                    $compte = Absence::byUser($id,0);
                    if($user){
                        $return = array("statuts" => 0, "user" => $user, "compte" => $compte);
                    }else{
                        $message = "An error appear, please reload";
                        $return = array("statuts" => 1, "mes" => $message);
                    }
                }else{
                    $message = "Please tape all required fields";
                    $return = array("statuts" => 1, "mes" => $message);
                }
            }else{
                $message = "An error appear, please reload";
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = "An error appear, please reload";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function transactions(){
        $return = [];
        header('content-type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(!empty($data)){
                if(isset($data["id"])&&!empty($data["id"])&&isset($data["pageCourante"])){
                    $id = $data["id"];
                    $pageCourante = $data["pageCourante"];
                    $branche = Branche::find($id);
                    if($branche){
                        $nbreParPage = 40;
                        $partner = null;
                        $search = null;
                        $bool = isset($data["search"])&&!empty($data["search"])?true:false;
                        if($bool){
                            $search = $data["search"];
                        }
                        if(isset($data["admin"])&&!empty($data["admin"])){
                            $partner = $branche->idPartenaire;
                            $id = null;
                        }
                        $nbre = Paiement::countBySearchType(null,$partner,$id,$search);
                        $nbrePages = ceil($nbre->Total/$nbreParPage);
                        $pageCourante = $bool?null:$pageCourante;
                        $nbreParPage = $bool?null:$nbreParPage;
                        $transactions = Paiement::searchType($nbreParPage,$pageCourante,null,$partner,$id,$search);
                        if(!empty($transactions)){
                            $return = $bool?array("statuts" => 0, "transactions" => $transactions):
                                array("statuts" => 0, "transactions" => $transactions, "nbre" => $nbrePages);
                        }else{
                            $conMessage = $bool?"There is no transaction corresponding to $search":"The transaction list is empty";
                            $return = array("statuts" => 1, "mes" => $conMessage);
                        }
                    }else{
                        $message = "An error appear, please reload";
                        $return = array("statuts" => 1, "mes" => $message);
                    }
                }else{
                    $message = "Please tape all required fields";
                    $return = array("statuts" => 1, "mes" => $message);
                }
            }else{
                $message = "An error appear, please reload";
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = "An error appear, please reload";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

}