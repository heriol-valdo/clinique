<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 03/09/2020
 * Time: 13:40
 */

namespace Projet\Controller\Hospitalisation;


use Projet\Controller\Admin\AdminsController;
use Projet\Database\Hospitalisation;
use Projet\Database\patient;
use Projet\Database\Salle;
use Projet\Model\App;
use Projet\Model\Privilege;
use DateTime;
use Exception;


class HospitalisationController extends AdminsController
{
    public function index(){
        Privilege::hasPrivilege(Privilege::$eshopProductView,$this->user->privilege);
        $user = $this->user;
        $nbreParPage = 20;
        $idsalle = (isset($_GET['idsalle'])&&!empty($_GET['idsalle'])) ? $_GET['idsalle'] : null;
        $idpatient = (isset($_GET['idpatient'])&&!empty($_GET['idpatient'])) ? $_GET['idpatient'] : null;
        $nbre = Hospitalisation::countBySearchType($idsalle,$idpatient);
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $items = Hospitalisation::searchType($nbreParPage,$pageCourante,$idsalle,$idpatient);
        $salles = Salle::searchType(null,null,null,null,null,1);
        $patients = patient::searchType(null,null,null,null,null,1);
        $this->render('admin.hospitalisation.hospitalisation',compact('search','salles','patients','user','nbre','nbrePages','items'));
    }

    public function save(){

        header('content-type: application/json');
        $return = [];
        $tab = ["add", "edit"];
        if (isset($_POST['idsalle']) && !empty($_POST['idsalle'])
            && isset($_POST['idpatient']) && !empty($_POST['idpatient'])
            && isset($_POST['date_in']) && !empty($_POST['date_in'])
            && isset($_POST['action']) && !empty($_POST['action'])
            && isset($_POST['id']) && in_array($_POST["action"], $tab)) {
            $idsalle = $_POST['idsalle'];
            $idpatient = $_POST['idpatient'];
            $date_in = $_POST['date_in'];
            $action = $_POST['action'];
            $id = $_POST['id'];
            if($action == "edit") {
                if (!empty($id)){
                    $patient = Hospitalisation::find($id);
                    if ($patient) {
                        $pdo = App::getDb()->getPDO();
                        try{
                            $pdo->beginTransaction();
                            $date_in= new DateTime($date_in);
                            Hospitalisation::save($idsalle,$idpatient,$date_in->format(MYSQL_DATE_FORMAT),$id);
                            $message = "L'hospitalisation a été mise à jour avec succès";
                            $this->session->write('success',$message);
                            $pdo->commit();
                            $return = array(" statuts" => 0, "mes" => $message);
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
                    $date_in= new DateTime($date_in);
                    Hospitalisation::save($idsalle,$idpatient,$date_in->format(MYSQL_DATE_FORMAT));
                    $message = "L'hospitalisation a été ajoutée avec succès";
                    $this->session->write('success',$message);
                    $pdo->commit();
                    $return = array("statuts" => 0, "mes" => $message);
                }catch (Exception $e){
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

}