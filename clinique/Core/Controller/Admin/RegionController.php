<?php
	/**
	 * Created by PhpStorm.
	 * User: su
	 * Date: 20/08/2015
	 * Time: 14:04
	 */

namespace Projet\Controller\Admin;


use Exception;
use Projet\Database\Categorie;
use Projet\Database\Marchand;
use Projet\Database\Pays;
use Projet\Database\Profil;
use Projet\Database\Region;
use Projet\Model\App;
use Projet\Model\DataHelper;
use Projet\Model\FileHelper;
use Projet\Model\Privilege;
use Projet\Model\StringHelper;

class RegionController extends AdminController {

    public function index(){
        Privilege::hasPrivilege(Privilege::$eshopConfiguration,$this->user->privilege);
        $pays = Pays::searchType();
        $user = $this->user;
        $params = $_GET;
        $nbreParPage = 20;
        if (isset($_GET['search'])&&isset($_GET['pays'])) {
            $idPays = (!empty($_GET['pays'])) ? $_GET['pays'] : null;
            $search = (!empty($_GET['search'])) ? $_GET['search'] : null;
            $nbre = Region::countBySearchType($search,$idPays);
            $nbrePages = ceil($nbre->Total / $nbreParPage);
            if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                $pageCourante = $_GET['page'];
            } else {
                $pageCourante = 1;
                $params['page'] = $pageCourante;
            }
            $regions = Region::searchType($nbreParPage, $pageCourante,$search,$idPays);
        } else {
            $nbre = Region::countBySearchType();
            $nbrePages = ceil($nbre->Total / $nbreParPage);
            if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                $pageCourante = $_GET['page'];
            } else {
                $pageCourante = 1;
                $params['page'] = $pageCourante;
            }
            $regions = Region::searchType($nbreParPage, $pageCourante);

        }
        $this->render('admin.localisation.regions',compact('regions','pays','nbrePages','nbre','user'));

    }

    public function save(){
        Privilege::hasPrivilege(Privilege::$eshopConfiguration,$this->user->privilege);
        $result = [];
        header('content-type: application/json');
        if (isset($_POST['name'])&&!empty($_POST['name'])&& isset($_POST['action']) && !empty($_POST['action'])
            && isset($_POST['idPays'])&&!empty($_POST['idPays']) &&isset($_POST['id'])){
            $nom = $_POST['name'];
            $id = $_POST['id'];
            $idCat = $_POST['idPays'];
            $action = $_POST['action'];
            $pays = Pays::find($idCat);
            if($pays){
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    if($action == 'add'){
                        Region::save($pays->id,$pays->intitule,$nom);
                        $message = "La région a bien été ajoutée";
                        $this->session->write('success',$message);
                        $pdo->commit();
                        $result = array("statuts"=>0, "mes"=>$message);
                    }elseif($action == 'edit'){
                        $exist = Region::find($id);
                        if($exist){
                            Region::save($pays->id,$pays->intitule,$nom,$id);
                            $profils = Profil::searchType(null,null,null,null,null,null,null,null,null,null,null,$exist->id);
                            foreach ($profils as $profil) {
                                Profil::setRegion($id,$nom,$profil->id);
                            }
                            $marchands = Marchand::searchType(null,null,null,null,null,null,null,null,null,$exist->id);
                            foreach ($marchands as $marchand) {
                                Marchand::setRegion($id,$nom,$marchand->id);
                            }
                            $message = "La région a bien été modifiée";
                            $this->session->write('success',$message);
                            $pdo->commit();
                            $result = array("statuts"=>0, "mes"=>$message);
                        }else{
                            $message = "Cette région n'existe pas";
                            $result = array("statuts"=>1, "mes"=>$message);
                        }
                    }else{
                        $message = "Erreur action";
                        $result = array("statuts"=>1, "mes"=>$message);
                    }
                }catch (Exception $e){
                    $result = array("statuts"=>1, "mes"=>$this->error);
                }
            }else{
                $message = "Erreur action";
                $result = array("statuts"=>1, "mes"=>$message);
            }
        }else{
            $message = "Veuillez renseigner les champs";
            $result = array("statuts"=>1, "mes"=>$message);
        }
        echo json_encode($result);
    }

    public function delete(){
        Privilege::hasPrivilege(Privilege::$eshopConfiguration,$this->user->privilege);
        header('content-type: application/json');
        if (isset($_POST['id'])&&!empty($_POST['id'])){
            $id = $_POST['id'];
            $ville = Region::find($id);
            if ($ville){
                $nbre = Categorie::countBySearchType(null,$id);
                if($nbre->Total==0){
                    Region::delete($id);
                    $message = "La région a été supprimée avec succès";
                    $this->session->write('succes',$message);
                    $return = array("statuts"=>0, "mes"=>$message);
                }else{
                    $message = "La région ne peut être supprimée car elle contient des clients";
                    $return = array("statuts"=>1, "mes"=>$message);
                }
            }else{
                $message = "La région n'existe plus";
                $return = array("statuts"=>1, "mes"=>$message);
            }
        }else{
            $message = "Renseigner l'id SVP !!!";
            $return = array("statuts"=>1, "mes"=>$message);
        }
        echo json_encode($return);
    }

    public function loader(){
        header('content-type: application/json');
        if(isset($_POST['val'])&&!empty($_POST['val'])){
            $val = $_POST['val'];
            $pays = Pays::find($val);
            if($pays){
                $regions = Region::searchType(null,null,null,$val);
                $content = "";
                foreach ($regions as $region) {
                    $content .= '<option value="'.$region->id.'">'.$region->intitule.'</option>';
                }
                $return = array("statuts" => 0, "contenu"=>$content);
            }else{
                $return = array("statuts" => 1);
            }
        }else{
            $return = array("statuts" => 1);
        }
        echo json_encode($return);
    }

}