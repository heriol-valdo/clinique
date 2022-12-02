<?php
/**
 * Created by PhpStorm.
 * User: Ndjeunou
 * Date: 23/01/2017
 * Time: 09:19
 */

namespace Projet\Controller\Admin;

use DateTime;
use Exception;
use Projet\Database\Action;
use Projet\Database\Agence;
use Projet\Database\Branche;
use Projet\Database\Caisse;
use Projet\Database\Log;
use Projet\Database\Partenaire;
use Projet\Database\Settings;
use Projet\Database\Suggestion;
use Projet\Database\Tour;
use Projet\Database\Tranche;
use Projet\Database\Transaction;
use Projet\Database\Transfert;
use Projet\Database\User;
use Projet\Database\Compte;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\Privilege;
use Projet\Model\Random;
use Projet\Model\Sms;
use Projet\Model\StringHelper;

class TrancheController extends AdminController{
    
    public function index(){
        Privilege::hasPrivilege(Privilege::$gestionCommissions,$this->user->privilege);
        $user = $this->user;
        $nbreParPage = 50;
        $nbre = Tranche::countBySearch();
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $tranches = Tranche::search($nbreParPage,$pageCourante);
        $this->render('admin.tranche.index',compact('user','nbrePages','nbre','tranches'));
    }

    public function delete(){
        Privilege::hasPrivilege(Privilege::$gestionCommissions,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $id = $_POST['id'];
            $tranche = Tranche::find($id);
            if($tranche){
                $pdo = App::getDb()->getPDO();
                try{
                    $user = $this->user;
                    $pdo->beginTransaction();
                    Tranche::delete($id);
                    $message = "La ligne de commission a été supprimée avec succès";
                    $this->session->write('success',$message);
                    $pdo->commit();
                    $return = array("statuts" => 0, "mes" => $message);
                }catch (Exception $e){
                    $pdo->rollBack();
                    $return = array("statuts" => 1, "mes" => $this->error);
                }
            }else{
                $return = array("statuts" => 1, "mes" => $this->error);
            }
        }else{
            $return = array("statuts" => 1, "mes" => $this->empty);
        }
        echo json_encode($return);
    }

    public function save(){
        header('content-type: application/json');
        Privilege::hasPrivilege(Privilege::$gestionCommissions,$this->user->privilege);
        $tab = ["add","edit"];
        if(isset($_POST['debut']) && isset($_POST['fin']) && $_POST['fin']>0&&$_POST['debut']>=0&&isset($_POST['cout'])&&$_POST['cout']>=0
            &&isset($_POST['action']) && !empty($_POST['action'])&&isset($_POST['id']) && in_array($_POST["action"],$tab)){
            $debut = (int)$_POST['debut'];
            $fin = (int)$_POST['fin'];
            $cout = (int)$_POST['cout'];
            $action = $_POST['action'];
            $id = (int) $_POST['id'];
            $errorNOM= "La ligne de commission existe déjà";
            if($debut<$fin){
                if($action == "edit"){
                    if(!empty($id)){
                        $tranche = Tranche::find($id);
                        if($tranche){
                            $tExist = Tranche::isExist($debut,$fin);
                            $bool = true;
                            if(($tranche->debut != $debut || $tranche->fin != $fin) && $tExist){
                                $bool = $tExist->id==$id?true:false;
                            }
                            if($bool){
                                $pdo = App::getDb()->getPDO();
                                try{
                                    $pdo->beginTransaction();
                                    Tranche::save($debut,$fin,$cout,$id);
                                    $pdo->commit();
                                    $message = "La ligne de commission a été modifiée avec succès";
                                    $return = array("statuts"=>0, "mes"=>$message);
                                    $this->session->write('success',$message);
                                }catch(Exception $e){
                                    $pdo->rollBack();
                                    $return = array("statuts"=>1, "mes"=>$this->error);
                                }
                            }else{
                                $return = array("statuts"=>1, "mes"=>$errorNOM);
                            }
                        }else{
                            $return = array("statuts"=>1, "mes"=>$this->error);
                        }
                    }else{
                        $return = array("statuts" => 1, "mes" => $this->error);
                    }
                }else{
                    $texist = Tranche::isExist($debut,$fin);
                    if(!$texist){
                        $pdo = App::getDb()->getPDO();
                        try{
                            $pdo->beginTransaction();
                            Tranche::save($debut,$fin,$cout);
                            $pdo->commit();
                            $message = "La ligne de commission a été ajoutée avec succès";
                            $return = array("statuts"=>0, "mes"=>$message);
                            $this->session->write('success',$message);
                        }catch(Exception $e){
                            $pdo->rollBack();
                            $return = array("statuts"=>1, "mes"=>$this->error);
                        }
                    }else{
                        $return = array("statuts"=>1, "mes"=>$errorNOM);
                    }
                }
            }else{
                $message = "Le prix de départ doit être inférieur au prix de fin";
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $return = array("statuts" => 1, "mes" => $this->empty);
        }
        echo json_encode($return);
    }
    
}
