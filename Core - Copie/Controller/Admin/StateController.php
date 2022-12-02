<?php
/**
 * Created by PhpStorm.
 * User: yousseph
 * Date: 18/05/2020
 * Time: 13:34
 */


namespace Projet\Controller\Admin;

use Exception;
use Projet\Database\tax_list;
use Projet\Model\App;
use Projet\Model\Privilege;

class StateController extends AdminController{

    public function index()
    {
        Privilege::hasPrivilege(Privilege::$eshopConfigTaxeView, $this->user->privilege);
        $user = $this->user;
        $nbreParPage = 20;
        $state_name = (isset($_GET['state_name']) && !empty($_GET['state_name'])) ? $_GET['state_name'] : null;
        $nbre = tax_list::countBySearchType($state_name);
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $tax_lists = tax_list::searchType($nbreParPage, $pageCourante, $state_name);

        $this->render('admin.user.state', compact('user', 'nbre', 'nbrePages', 'state_name', 'tax_lists'));
    }


    public function save(){
        header('content-type: application/json');
        $return = [];
        $tab = ["add", "edit"];
        if (isset($_POST['state_name']) && !empty($_POST['state_name'])
            && isset($_POST['tps'])
            && isset($_POST['tvq'])
            && isset($_POST['action']) && !empty($_POST['action'])
            && isset($_POST['id']) && in_array($_POST["action"], $tab)) {
            $state_name = trim($_POST['state_name']);
            $tps = (float)$_POST['tps'];
            $tvq = (float)$_POST['tvq'];
            $action = $_POST['action'];
            $id = (int)$_POST['id'];
            if($tps>=0&&$tps<=100&& $tvq>=0&&$tvq<=100 ){
                if($action == "edit") {
                    Privilege::hasPrivilege(Privilege::$eshopConfigTaxeEdit,$this->user->privilege);
                    if (!empty($id)){
                        $tax_lists = tax_list::find($id);
                        if ($tax_lists) {
                            $bool = true;
                            if($state_name!=$tax_lists){
                                if(tax_list::byNom($state_name))
                                    $bool = false;
                            }
                            if($bool){
                                $pdo = App::getDb()->getPDO();
                                try{
                                    $pdo->beginTransaction();
                                    tax_list::save($state_name,$tps,$tvq,$id);
                                    $message = "La taxe a été mise à jour avec succès";
                                    $this->session->write('success',$message);
                                    $pdo->commit();
                                    $return = array("statuts" => 0, "mes" => $message);
                                }catch (Exception $e){
                                    $pdo->rollBack();
                                    $message = $this->error;
                                    $return = array("statuts" => 1, "mes" => $message);
                                }
                            }else{
                                $message = "Le nom de la taxe exite déja veiullez utiliser un autre ! ";
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
                    Privilege::hasPrivilege(Privilege::$eshopConfigTaxeAdd,$this->user->privilege);
                    if(!tax_list::byNom($state_name)){
                        $pdo = App::getDb()->getPDO();
                        try{
                            $pdo->beginTransaction();
                            tax_list::save( $state_name,$tps,$tvq);
                            $message = "La taxe a été ajouté avec succès";
                            $this->session->write('success',$message);
                            $pdo->commit();
                            $return = array("statuts" => 0, "mes" => $message);
                        }catch (Exception $e){
                            $pdo->rollBack();
                            $message = $this->error;
                            $return = array("statuts" => 1, "mes" => $message);
                        }
                    }else{
                        $message = "Le nom de la taxe exite déja veiullez utiliser un autre ! ";
                        $return = array("statuts" => 1, "mes" => $message);
                    }
                }
            }else{
                $message = "La TPS ou TVP doit etre de l'interval [0;100] ";
                $return = array("statuts" => 1, "mes" => $message);
            }
        } else {
            $message = "Veiullez renseigner tous les champs requis";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }


    public function delete(){
        Privilege::hasPrivilege(Privilege::$eshopConfigTaxeDelete,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $id = $_POST['id'];
            $state_name = tax_list::find($id);
            if($state_name){
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    tax_list::delete($id);
                    $message = "La taxe a été supprimée avec succès";
                    $this->session->write('success',$message);
                    $pdo->commit();
                    $return = array("statuts" => 0, "mes" => $message);
                }catch (Exception $e){
                    $pdo->rollBack();
                    $message = $this->error;
                    $return = array("statuts" => 1, "mes" => $message);
                }
            }else{
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = $this->empty;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }




}
