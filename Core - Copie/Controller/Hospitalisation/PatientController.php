<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 03/09/2020
 * Time: 13:36
 */

namespace Projet\Controller\Hospitalisation;


use Projet\Controller\Admin\AdminsController;
use Projet\Database\patient;
use Projet\Model\App;
use DateTime;
use Projet\Model\Privilege;
use Exception ;


class PatientController extends AdminsController
{

    public function index(){
        Privilege::hasPrivilege(Privilege::$eshopProductView,$this->user->privilege);
        $user = $this->user;
        $nbreParPage = 10;
        $search = (isset($_GET['search'])&&!empty($_GET['search'])) ? $_GET['search'] : null;
        $nbre = patient::countBySearchType($search);
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $items = patient::searchType($nbreParPage,$pageCourante,$search);
        $this->render('admin.hospitalisation.patient',compact('search','user','nbre','nbrePages','items'));
    }

    public function save(){

        header('content-type: application/json');
        $return = [];
        $tab = ["add", "edit"];
        if (isset($_POST['nom']) && !empty($_POST['nom'])
            && isset($_POST['prenom']) && !empty($_POST['prenom'])
            && isset($_POST['sexe']) && !empty($_POST['sexe'])
            && isset($_POST['numero']) && !empty($_POST['numero'])
            && isset($_POST['date_nais']) && !empty($_POST['date_nais'])
            && isset($_POST['group']) && !empty($_POST['group'])
            && isset($_POST['taille']) && !empty($_POST['taille'])
            && isset($_POST['poids']) && !empty($_POST['poids'])
            && isset($_POST['action']) && !empty($_POST['action'])
            && isset($_POST['id']) && in_array($_POST["action"], $tab)) {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $sexe = $_POST['sexe'];
            $numero = $_POST['numero'];
            $date_nais = $_POST['date_nais'];
            $group = ($_POST['group']);
            $taille = (float)($_POST['taille']);
            $poids = (float)(string)($_POST['poids']);
            $action = $_POST['action'];
            $id = $_POST['id'];
            if($action == "edit") {
                if (!empty($id)){
                    $patient = patient::find($id);
                    if ($patient) {
                        $pdo = App::getDb()->getPDO();
                        try{
                            $pdo->beginTransaction();
                            $date_nais= new DateTime($date_nais);
                            patient::save($nom,$prenom,$sexe,$numero,$date_nais->format(MYSQL_DATE_FORMAT),$group,$poids,$taille,$id);
                            $message = "Le patient a été mise à jour avec succès";
                            $this->session->write('success',$message);
                            $pdo->commit();
                            $return = array("statuts" => 0, "mes" => $message);
                        }catch (Exception $e){
                            $pdo->rollBack();
                            $message = $this->error;
                            $return = array("statuts" => 1, "mes" => $message);
                        }
                        }else {
                            $message = $this->error;
                            $return = array("statuts" => 1, "mes" => $message);
                        }
                } else {
                    $message = $this->error;
                    $return = array("statuts" => 1, "mes" => $message);
                }
            } else {
                    $pdo = App::getDb()->getPDO();
                    try{
                        $pdo->beginTransaction();
                        $date_nais= new DateTime($date_nais);
                        patient::save($nom,$prenom,$sexe,$numero,$date_nais->format(MYSQL_DATE_FORMAT),$group,$poids,$taille);
                        $message = "Le patient a été ajoutée avec succès";
                        $this->session->write('success',$message);
                        $pdo->commit();
                        $return = array("statuts" => 0, "mes" => $message);
                    }catch (Exception $e){
                        var_die($e->getMessage());
                        $pdo->rollBack();
                        $message = $this->error;
                        $return = array("statuts" => 1, "mes" => $message);
                    }
            }

        } else {
            $message = "Veiullez renseigner tous les champs requis";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function delete(){
        Privilege::hasPrivilege(Privilege::$eshopProductView,$this->user->privilege);
        header('content-type: application/json');
        if (isset($_POST['id'])&&!empty($_POST['id'])){
            $id = $_POST['id'];
            $patient = patient::find($id);
            if ($patient){
                    patient::delete($id);
                    $message = "Le patient a été supprimée avec succès";
                    $this->session->write('success',$message);
                    $return = array("statuts"=>0, "mes"=>$message);
               
            }else{
                $message = "Le patient n'existe plus";
                $return = array("statuts"=>1, "mes"=>$message);
            }
        }else{
            $message = "Renseigner l'id SVP !!!";
            $return = array("statuts"=>1, "mes"=>$message);
        }
        echo json_encode($return);
    }
}