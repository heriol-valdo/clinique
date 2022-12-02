<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 23/01/2017
 * Time: 09:19
 */

namespace Projet\Controller\Android;


use Exception;
use Projet\Database\Annee;
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

class LocationController{

    public function login(){
        $return = [];
        header('content-type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(!empty($data)){
                if(isset($data["numero"])&&!empty($data["numero"])&&isset($data["password"])&&!empty($data["password"])){
                    $login = StringHelper::getPhone($data["numero"]);
                    $password = $data["password"];
                    $user = Profil::byLogins($login);
                    if($user){
                        if($user->password == sha1($password)){
                            $message = "You have been successfully logged, now you can manage agency locations";
                            $return = array("statuts" => 0, "id" => $user->id, "mes" => $message);
                        }else{
                            $return = array("statuts" => 1, "mes" => "Your password is incorrect");
                        }
                    }else{
                        $return = array("statuts" => 1, "mes" => "There is no user attached to this login");
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

    public function agences(){
        $return = [];
        header('content-type: application/json');
        $agences = Annee::all();
        echo json_encode(array("agences"=>$agences,"statuts"=>0));
    }

    public function geolocate(){
        $return = [];
        header('content-type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(!empty($data)){
                if(isset($data["latitude"])&&!empty($data["latitude"])&&isset($data["longitude"])&&!empty($data["longitude"])&&isset($data["id"])&&!empty($data["id"])){
                    $lat = $data["latitude"];
                    $lon = $data["longitude"];
                    $id = (int)$data["id"];
                    $agence = Annee::find($id);
                    if($agence){
                        $pdo = App::getDb()->getPDO();
                        try{
                            $pdo->beginTransaction();
                            Annee::geolocate($lat,$lon,$id);
                            Annee::setIsLocalise(1,$id);
                            $pdo->commit();
                            $return = array("statuts" => 0, "mes" => "The agency has been geolocated successfully");
                        }catch (Exception $e){
                            $pdo->rollBack();
                            $return = array("statuts" => 1, "mes" => "An error appear, please reload");
                        }
                    }else{
                        $return = array("statuts" => 1, "mes" => "An error appear, please reload");
                    }
                }else{
                    $message = "An error appear, please reload";
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