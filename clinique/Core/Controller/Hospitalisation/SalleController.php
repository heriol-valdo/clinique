<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 03/09/2020
 * Time: 13:37
 */

namespace Projet\Controller\Hospitalisation;



use Projet\Controller\Admin\AdminsController;
use Projet\Database\Salle;
use Projet\Model\App;
use Projet\Model\Privilege;
use Exception;


class SalleController extends AdminsController
{
    public function index(){
        Privilege::hasPrivilege(Privilege::$eshopProductView,$this->user->privilege);
        $user = $this->user;
        $nbreParPage = 10;
        $search = (isset($_GET['search'])&&!empty($_GET['search'])) ? $_GET['search'] : null;
        $nbre = Salle::countBySearchType($search);
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $items = Salle::searchType($nbreParPage,$pageCourante,$search);
        $this->render('admin.hospitalisation.salle',compact('search','user','nbre','nbrePages','items'));
    }
    public function save(){

        header('content-type: application/json');
        $return = [];
        $tab = ["add", "edit"];
        if (isset($_POST['nom']) && !empty($_POST['nom'])
            && isset($_POST['prix']) && $_POST['prix']>=0
            && isset($_POST['action']) && !empty($_POST['action'])
            && isset($_POST['id']) && in_array($_POST["action"], $tab)) {
            $nom = $_POST['nom'];
            $prix = (float)$_POST['prix'];
            $action = $_POST['action'];
            $id = $_POST['id'];
                    if($action == "edit") {
                        if (!empty($id)){
                            $salle = Salle::find($id);
                            if ($salle) {
                                $bool = true;
                                if($nom != $salle->nom){
                                    if(Salle::byNom($nom))
                                        $bool = "La salle existe déja";
                                 }
                                 if(is_bool($bool)){
                                    $pdo = App::getDb()->getPDO();
                                    try{
                                        $pdo->beginTransaction();
                                        Salle::save ($nom,$prix,$id);
                                        $message = "La salle a été mise à jour avec succès";
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
                            $message = $this->error;
                            $return = array("statuts" => 1, "mes" => $message);
                        }
                    } else {
                        if(!(Salle::bynom($nom))){
                            $pdo = App::getDb()->getPDO();
                            try{
                                $pdo->beginTransaction();
                                Salle::save( $nom,$prix);
                                $message = "La salle a été ajoutée avec succès";
                                $this->session->write('success',$message);
                                $pdo->commit();
                                $return = array("statuts" => 0, "mes" => $message);
                            }catch (Exception $e){
                                $pdo->rollBack();
                                $message = $this->error;
                                $return = array("statuts" => 1, "mes" => $message);
                            }
                        }else {

                            $message = "Le nom de salle existe déja veiullez utiliser un autre nom ";
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
            $salle = Salle::find($id);
            if ($salle){
                Salle::delete($id);
                $message = "La salle a été supprimée avec succès";
                $this->session->write('success',$message);
                $return = array("statuts"=>0, "mes"=>$message);

            }else{
                $message = "La salle n'existe plus";
                $return = array("statuts"=>1, "mes"=>$message);
            }
        }else{
            $message = "Renseigner l'id SVP !!!";
            $return = array("statuts"=>1, "mes"=>$message);
        }
        echo json_encode($return);
    }

}