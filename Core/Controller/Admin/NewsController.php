<?php
	/**
	 * Created by PhpStorm.
	 * User: su
	 * Date: 20/08/2015
	 * Time: 14:04
	 */

namespace Projet\Controller\Admin;

use Exception;
use Projet\Database\News;
use Projet\Model\App;
use Projet\Model\DataHelper;
use Projet\Model\FileHelper;
use Projet\Model\Privilege;

class NewsController extends AdminController {

	public function index(){
        Privilege::hasPrivilege(Privilege::$eshopOtherNewView,$this->user->privilege);
		$nbreParPage = 20;
		$user = $this->user;
		if(isset($_GET['debut'])&&isset($_GET['end'])){
			$debut=(!empty($_GET['debut']))? $_GET['debut']:null;
			$fin=(!empty($_GET['fin']))? $_GET['fin']:null;
			$nbre = News::countBySearchType(null,$debut,$fin);
			$nbrePages = ceil($nbre->Total / $nbreParPage);
			if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
				$pageCourante = $_GET['page'];
			} else {
				$pageCourante = 1;
				$params['page'] = $pageCourante;
			}
			$news = News::searchType($nbreParPage,$pageCourante,null,$debut,$fin);
		}else{
			$nbre = News::countBySearchType();
			$nbrePages = ceil($nbre->Total / $nbreParPage);
			if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
				$pageCourante = $_GET['page'];
			} else {
				$pageCourante = 1;
				$params['page'] = $pageCourante;
			}
			$news = News::searchType($nbreParPage,$pageCourante);
		}
		$this->render("admin.news.index",compact("news","nbre","user","nbrePages"));
	}

	public function delete(){
        Privilege::hasPrivilege(Privilege::$eshopOtherNewDelete,$this->user->privilege);
		header('content-type: application/json');
		$return = [];
		if(isset($_POST['idPays']) && !empty($_POST['idPays'])){
			$id = $_POST['idPays'];
			$product = News::find($id);
			if($product){
				$pdo = App::getDb()->getPDO();
				try{
					$user = $this->user;
					$pdo->beginTransaction();
					News::delete($id);
					FileHelper::deleteImage('Public/'.$product->image);
					$message = "La news a été supprimée avec succès";
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

	public function save(){
        Privilege::hasPrivilege(Privilege::$eshopOtherNewAdd,$this->user->privilege);
		header('content-type: application/json');
		$tab = ["add","edit"];
		if(isset($_POST['nom']) && !empty($_POST['nom'])&&isset($_POST['detail']) && !empty($_POST['detail'])
			&&isset($_POST['action']) && !empty($_POST['action'])&&isset($_POST['id']) && in_array($_POST["action"],$tab)){
			$nom = $_POST['nom'];
			$detail = $_POST['detail'];
			$action = $_POST['action'];
			$id = (int) $_POST['id'];
			if($action == "edit"){
				if(!empty($id)){
					$product = News::find($id);
					if($product){
						$pdo = App::getDb()->getPDO();
						try{
							$pdo->beginTransaction();
							News::save($nom,$detail,$product->image,$product->id);
							$pdo->commit();
							$message = "La news a été ajouté avec succès";
							$return = array("statuts"=>0, "mes"=>$message);
							$this->session->write('success',$message);
						}catch(Exception $e){
							$pdo->rollBack();
							$erreur = $this->error;
							$return = array("statuts"=>1, "mes"=>$erreur);
						}
					}else{
						$return = array("statuts"=>1, "mes"=>$this->error);
					}
				}else{
					$message = $this->error;
					$return = array("statuts" => 1, "mes" => $message);
				}
			}else{
				if(isset($_FILES['file']['name'])){
					$extensions_valides = array('jpg','jpeg','png','JPG','JPEG','PNG');
					$extension_upload = strtolower(  substr(  strrchr($_FILES['file']['name'], '.')  ,1)  );
					if(in_array($extension_upload,$extensions_valides) && in_array($extension_upload,$extensions_valides) ){
						if($_FILES['file']['size']<=1000000){
							$pdo = App::getDb()->getPDO();
							try{
								$pdo->beginTransaction();
								$root = FileHelper::moveImage($_FILES['file']['tmp_name'],"uploads","png","",true);
								if($root){
									News::save($nom,$detail,$root);
									$return = "La news a été ajoutée avec succès";
									$this->session->write('success',$return);
									$pdo->commit();
									$return = array("statuts"=>0, "mes"=>$return);
								}else{
									$erreur = "Erreur lors de la sauvegarde de l'image";
									$return = array("statuts"=>1, "mes"=>$erreur);
								}
							}catch(Exception $e){
								$pdo->rollBack();
								$erreur = $this->error;
								$return = array("statuts"=>1, "mes"=>$erreur);
							}
						}else{
							$erreur =  "L'image est trop grande";
							$return = array("statuts"=>1, "mes"=>$erreur);
						}
					}else{
						$message = "Le type de l'image est invalide";
						$return = array("statuts"=>1, "mes"=>$message);
					}
				}else{
					$return = array("statuts" => 1, "mes" => "SVP associez une image à la news");
				}
			}
		}else{
			$message = $this->empty;
			$return = array("statuts" => 1, "mes" => $message);
		}
		echo json_encode($return);
	}

	public function change(){
        Privilege::hasPrivilege(Privilege::$eshopOtherNewChangeImg,$this->user->privilege);
		header('content-type: application/json');
		if(isset($_FILES['file']['name'])){
			$id = DataHelper::post('idCashier');
			if(isset($_FILES['file']['tmp_name']) && !empty($_FILES['file']['tmp_name']) && !is_null($id) ){
				if ($_FILES['file']['error'] == 0){
					$extensions_valides = array('jpg','jpeg','png','JPG','JPEG','PNG');
					$extension_upload = strtolower(  substr(  strrchr($_FILES['file']['name'], '.')  ,1)  );
					if(in_array($extension_upload,$extensions_valides)){
						if($_FILES['file']['size']<=1000000){
							$pdo = App::getDb()->getPDO();
							$product = News::find($id);
							try{
								$pdo->beginTransaction();
								$root = FileHelper::moveImage($_FILES['file']['tmp_name'],"uploads","png","",true);
								if (!empty($product->image) && strpos($product->image, 'file') === false){
									FileHelper::deleteImage('Public/'.$product->image);
								}
								if($root){
									News::setImage($root,$id);
									$success = "L'image de la news a été mis à jour avec succès";
									$this->session->write('success',$success);
									$pdo->commit();
									$result = array("statuts"=>0, "mes"=>$success);
								}else{
									$erreur = "Erreur lors de la sauvegarde de l'image";
									$result = array("statuts"=>1, "mes"=>$erreur);
								}
							}catch(Exception $e){
								$pdo->rollBack();
								$erreur = $this->error;
								$result = array("statuts"=>1, "mes"=>$erreur);
							}
						}else{
							$erreur =  "L'image est trop grande";
							$result = array("statuts"=>1, "mes"=>$erreur);
						}
					}else{
						$message = "Le type de l'image est invalide";
						$result = array("statuts"=>1, "mes"=>$message);
					}
				}else{
					$message = $this->error;
					$result = array("statuts"=>1, "mes"=>$message);
				}
			}else{
				$message = "Aucun fichier n'a été envoyé";
				$result = array("statuts"=>1, "mes"=>$message);
			}
		}else{
			$message = "SVP envoyez une image";
			$result = array("statuts"=>1, "mes"=>$message);
		}
		echo json_encode($result);
	}

}