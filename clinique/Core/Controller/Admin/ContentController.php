<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 21/05/2020
 * Time: 14:57
 */

namespace Projet\Controller\Admin;

use Exception;
use Projet\Database\content;
use Projet\Model\App;
use Projet\Model\Privilege;

class ContentController extends AdminController
{
    public function index(){
        Privilege::hasPrivilege(Privilege::$eshopConfigAppTextView,$this->user->privilege);
        $user = $this->user;
            $nbreParPage = 1;
            $nbre = content::count();
            $nbrePages = ceil($nbre->Total / $nbreParPage);
            if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                $pageCourante = $_GET['page'];
            } else {
                $pageCourante = 1;
                $params['page'] = $pageCourante;
            }
        $contents = content::all();
        $this->render('admin.user.content',compact('user','contents','nbre','nbrePages'));
    }

    public function about(){
        Privilege::hasPrivilege(Privilege::$eshopConfigAppTextEdit,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        $tab = ["editabout"];
        if ( isset($_POST['action']) && !empty($_POST['action']) && isset($_POST['id']) && in_array($_POST["action"], $tab)) {
            $action = $_POST['action'];
            $id = (int)$_POST['id'];
            if(($action == "editabout")&&isset($_POST['about_us']) && !empty($_POST['about_us'])){
                $about_us = $_POST['about_us'];
                if (!empty($id)){
                    $contents = content::find($id);
                    if ($contents) {
                        $pdo = App::getDb()->getPDO();
                        try{
                            $pdo->beginTransaction();
                            content::setAbout( $about_us,$id);
                            $message = "Le contenu a été mise à jour avec succès";
                            $this->session->write('success',$message);
                            $pdo->commit();
                            $return = array("statuts" => 0, "mes" => $message);
                        }catch (Exception $e){
                            $pdo->rollBack();
                            $message = $this->error;
                            $return = array("statuts" => 1, "mes" => $message);
                        }
                    } else {
                        $message = $this->error;
                        $return = array("statuts" => 1, "mes" => $message);
                    }
                } else {
                    $message = $this->error;
                    $return = array("statuts" => 1, "mes" => $message);
                }
            }else {
                $message = "Veiullez renseigner tous les champs requis";
                $return = array("statuts" => 1, "mes" => $message);
            }

        } else {
            $message = "Veiullez renseigner tous les champs requis";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }
    public function policy(){
        Privilege::hasPrivilege(Privilege::$eshopConfigAppTextEdit,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        $tab = ["editpolicy"];
        if ( isset($_POST['action']) && !empty($_POST['action']) && isset($_POST['id']) && in_array($_POST["action"], $tab)) {
            $action = $_POST['action'];
            $id = (int)$_POST['id'];
            if(($action == "editpolicy")&&isset($_POST['privacy_policy']) && !empty($_POST['privacy_policy'])){
                $privacy_policy = $_POST['privacy_policy'];
                if (!empty($id)){
                    $contents = content::find($id);
                    if ($contents) {
                        $pdo = App::getDb()->getPDO();
                        try{
                            $pdo->beginTransaction();
                            content::setPolicy($privacy_policy,$id);
                            $message = "Le content a été mise à jour avec succès";
                            $this->session->write('success',$message);
                            $pdo->commit();
                            $return = array("statuts" => 0, "mes" => $message);
                        }catch (Exception $e){
                            $pdo->rollBack();
                            $message = $this->error;
                            $return = array("statuts" => 1, "mes" => $message);
                        }
                    } else {
                        $message = $this->error;
                        $return = array("statuts" => 1, "mes" => $message);
                    }
                } else {
                    $message = $this->error;
                    $return = array("statuts" => 1, "mes" => $message);
                }
            }else {
                $message = "Veiullez renseigner tous les champs requis";
                $return = array("statuts" => 1, "mes" => $message);
            }

        } else {
            $message = "Veiullez renseigner tous les champs requis";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }
    public function term(){
        Privilege::hasPrivilege(Privilege::$eshopConfigAppTextEdit,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        $tab = ["editterm"];
        if ( isset($_POST['action']) && !empty($_POST['action']) && isset($_POST['id']) && in_array($_POST["action"], $tab)) {
            $action = $_POST['action'];
            $id = (int)$_POST['id'];
            if(($action == "editterm")&&isset($_POST['terms_and_conditions']) && !empty($_POST['terms_and_conditions'])){
                $terms_and_conditions = $_POST['terms_and_conditions'];
                if (!empty($id)){
                    $contents = content::find($id);
                    if ($contents) {
                        $pdo = App::getDb()->getPDO();
                        try{
                            $pdo->beginTransaction();
                            content::setTerms($terms_and_conditions,$id);
                            $message = "Le contenu a été mise à jour avec succès";
                            $this->session->write('success',$message);
                            $pdo->commit();
                            $return = array("statuts" => 0, "mes" => $message);
                        }catch (Exception $e){
                            $pdo->rollBack();
                            $message = $this->error;
                            $return = array("statuts" => 1, "mes" => $message);
                        }
                    } else {
                        $message = $this->error;
                        $return = array("statuts" => 1, "mes" => $message);
                    }
                } else {
                    $message = $this->error;
                    $return = array("statuts" => 1, "mes" => $message);
                }
            }else {
                $message = "Veiullez renseigner tous les champs requis";
                $return = array("statuts" => 1, "mes" => $message);
            }

        } else {
            $message = "Veiullez renseigner tous les champs requis";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

}