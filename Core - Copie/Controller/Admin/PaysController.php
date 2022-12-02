<?php
	/**
	 * Created by PhpStorm.
	 * User: su
	 * Date: 20/08/2015
	 * Time: 14:04
	 */

	namespace Projet\Controller\Admin;


    use Exception;
    use Projet\Database\Marchand;
    use Projet\Database\Pays;
    use Projet\Database\Profil;
    use Projet\Database\Region;
    use Projet\Model\App;
    use Projet\Model\Privilege;
    use Projet\Model\StringHelper;

    class PaysController extends AdminController {

		public function index(){
            Privilege::hasPrivilege(Privilege::$eshopConfigTaxeView,$this->user->privilege);
			$params = $_GET;
			$nbreParPage = 20;
			$user = $this->user;
			if (isset($_GET['search'])) {
				$search = (!empty($_GET['search'])) ? $_GET['search'] : null;
				$nbre = Pays::countBySearchType($search);
				$nbrePages = ceil($nbre->Total / $nbreParPage);
				if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
					$pageCourante = $_GET['page'];
				} else {
					$pageCourante = 1;
					$params['page'] = $pageCourante;
				}
                $pays = Pays::searchType($nbreParPage, $pageCourante,$search);
			} else{
				$nbre = Pays::countBySearchType();
				$nbrePages = ceil($nbre->Total / $nbreParPage);
				if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
					$pageCourante = $_GET['page'];
				} else {
					$pageCourante = 1;
					$params['page'] = $pageCourante;
				}
                $pays = Pays::searchType($nbreParPage, $pageCourante);
			}
            $this->render('admin.localisation.pays', compact('pays', 'nbrePages', 'nbre','user'));
		}

		public function save(){
            Privilege::hasPrivilege(Privilege::$eshopConfigTaxeAdd,$this->user->privilege);
			$result = [];
			header('content-type: application/json');
			if (isset($_POST['name'])&&!empty($_POST['name'])&&isset($_POST['code'])&&!empty($_POST['code'])
                &&isset($_POST['nbre'])&&!empty($_POST['nbre'])&&isset($_POST['action'])&&!empty($_POST['action'])&&isset($_POST['id'])){
				$name = $_POST['name'];
				$code = $_POST['code'];
				$nbre = $_POST['nbre'];
				$id = $_POST['id'];
				$action = $_POST['action'];
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    if($action == 'add'){
                        if(!Pays::byNom($name)){
                            Pays::save($name,$code,$nbre);
                            $message = "Ce pays a bien été ajouté";
                            $this->session->write('success',$message);
                            $pdo->commit();
                            $result = array("statuts"=>0, "mes"=>$message);
                        }else{
                            $message = "Ce pays existe déjà";
                            $result = array("statuts"=>1, "mes"=>$message);
                        }
                    }elseif($action == 'edit'){
                        $exist = Pays::find($id);
                        if($exist){
                            $bool = true;
                            if(StringHelper::str_without_accents($exist->intitule)!=StringHelper::str_without_accents($name)&&Pays::byNom($name)){
                                $bool = false;
                            }
                            if($bool){
                                Pays::save($name,$code,$nbre,$id);
                                $profils = Profil::searchType(null,null,null,null,null,null,null,null,null,null,$exist->id);
                                foreach ($profils as $profil) {
                                    Profil::setPays($id,$name,$code,$profil->id);
                                }
                                $marchands = Marchand::searchType(null,null,null,null,null,null,null,null,$exist->id);
                                foreach ($marchands as $marchand) {
                                    Marchand::setPays($id,$name,$marchand->id);
                                }
                                $regions = Region::searchType(null,null,null,$exist->id);
                                foreach ($regions as $region) {
                                    Region::setPays($id,$name,$region->id);
                                }
                                $message = "Le pays a été modifié avec succès";
                                $this->session->write('success',$message);
                                $pdo->commit();
                                $result = array("statuts"=>0, "mes"=>$message);
                            }else{
                                $message = "Ce pays existe déjà";
                                $result = array("statuts"=>1, "mes"=>$message);
                            }
                        }else{
                            $message = "Ce pays n'existe pas";
                            $result = array("statuts"=>1, "mes"=>$message);
                        }
                    }else{
                        $message = "Erreur Fatale";
                        $result = array("statuts"=>1, "mes"=>$message);
                    }
                }catch (Exception $e){
                    $result = array("statuts"=>1, "mes"=>$this->error);
                }
			}else{
                $message = "Erreur Fatale";
                $result = array("statuts"=>1, "mes"=>$message);
            }
			echo json_encode($result);
		}

		public function delete(){
            Privilege::hasPrivilege(Privilege::$eshopConfigTaxeDelete,$this->user->privilege);
            header('content-type: application/json');
            if (isset($_POST['id'])&&!empty($_POST['id'])){
                $id = $_POST['id'];
                $pays = Pays::find($id);
                if ($pays){
                    $nbre = Region::countBySearchType(null,$id);
                    if($nbre->Total==0){
                        Pays::delete($id);
                        $message = "Le pays a été supprimé avec succès";
                        $this->session->write('success',$message);
                        $return = array("statuts"=>0, "mes"=>$message);
                    }else{
                        $message = "Le pays ne peut être supprimé car il contient des régions";
                        $return = array("statuts"=>1, "mes"=>$message);
                    }
                }else{
                    $message = "Le pays n'existe pas";
                    $return = array("statuts"=>1, "mes"=>$message);
                }
            }else{
                $message = "Renseigner l'id SVP !!!";
                $return = array("statuts"=>1, "mes"=>$message);
            }
			echo json_encode($return);

		}


	}