<?php
	/**
	 * Created by PhpStorm.
	 * User: su
	 * Date: 20/08/2015
	 * Time: 14:04
	 */

namespace Projet\Controller\Admin;


use Exception;
use Projet\Database\Cat;
use Projet\Database\Categorie;
use Projet\Database\Evenement;
use Projet\Database\Marchand;
use Projet\Database\Publicite;
use Projet\Database\SousCategorie;
use Projet\Model\App;
use Projet\Model\DataHelper;
use Projet\Model\FileHelper;
use Projet\Model\Privilege;
use Projet\Model\StringHelper;

class PubliciteController extends AdminController {

    public function index(){
        Privilege::hasPrivilege(Privilege::$eshopOtherNewView,$this->user->privilege);
        $user = $this->user;
        $params = $_GET;
        $nbreParPage = 20;
        $nbre = Publicite::countBySearchType();
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        $marchands = Marchand::searchType();
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $publicites = Publicite::searchType($nbreParPage, $pageCourante);
        $this->render('admin.user.publicites',compact('marchands','publicites','nbrePages','nbre','user'));

    }

    public function save(){
        Privilege::hasPrivilege(Privilege::$eshopOtherNewAdd,$this->user->privilege);
        header('content-type: application/json');
        if(isset($_FILES['image']['name'])&&isset($_POST['name'])&&isset($_POST['idMarchand'])&&isset($_POST['priorite'])&&in_array($_POST['priorite'],[1,2,3,4,5,6])){
            $idMarchand = $_POST['idMarchand'];
            $nom = $_POST['name'];
            $priorite = $_POST['priorite'];
            if(isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])){
                if ($_FILES['image']['error'] == 0){
                    $extensions_valides = array('jpg','png','JPG','PNG');
                    $extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
                    if(in_array($extension_upload,$extensions_valides)){
                        if($_FILES['image']['size']<=900000){
                            $image_info = getimagesize($_FILES["image"]["tmp_name"]);
                            $image_width = $image_info[0];
                            $image_height = $image_info[1];
                            if($image_width==1500&&$image_height==500){
                                $bool = true;
                                if(!empty($idMarchand)){
                                    $marchand = Marchand::find($idMarchand);
                                    if(!$marchand)
                                        $bool = false;
                                }
                                if($bool){
                                    $pdo = App::getDb()->getPDO();
                                    try{
                                        $pdo->beginTransaction();
                                        $root = FileHelper::moveImage($_FILES['image']['tmp_name'],"uploads","jpg","",true);
                                        if($root){
                                            Publicite::save($idMarchand,$priorite,$root,$nom,"");
                                            $success = "Le slide publicitaire a été ajouté avec succès";
                                            $this->session->write('success',$success);
                                            $pdo->commit();
                                            $result = array("statuts"=>0, "mes"=>$success);
                                        }else{
                                            $erreur = $this->error;
                                            $result = array("statuts"=>1, "mes"=>$erreur);
                                        }
                                    } catch(Exception $e){
                                        $pdo->rollBack();
                                        $erreur = $this->error;
                                        $result = array("statuts"=>1, "mes"=>$erreur);
                                    }
                                } else{
                                    $erreur =  'Une erreur est survenue, recharger et réessayer';
                                    $result = array("statuts"=>1, "mes"=>$erreur);
                                }
                            }else{
                                $erreur = "L'image doit avoir 1500 pixels de large sur 500 pixels de haut";
                                $result = array("statuts"=>1, "mes"=>$erreur);
                            }
                        }else{
                            $erreur =  'Le fichier doit avoir une taille inférieure ou égale à 500 Ko';
                            $result = array("statuts"=>1, "mes"=>$erreur);
                        }
                    }else{
                        $message = "Le fichier doit être une image d'extension jpg ou png";
                        $result = array("statuts"=>1, "mes"=>$message);
                    }
                }else{
                    $message = $this->error;
                    $result = array("statuts"=>1, "mes"=>$message);
                }
            }else{
                $message = "Vous devez uploader un fichier";
                $result = array("statuts"=>1, "mes"=>$message);
            }
        }else{
            $message = $this->empty;
            $result = array("statuts"=>1, "mes"=>$message);
        }
        echo json_encode($result);
    }

    public function delete(){
        Privilege::hasPrivilege(Privilege::$eshopOtherNewDelete,$this->user->privilege);
        header('content-type: application/json');
        if (isset($_POST['id'])&&!empty($_POST['id'])){
            $id = $_POST['id'];
            $publicite = Publicite::find($id);
            if ($publicite){
                try{
                    FileHelper::deleteImage($publicite->path);
                    Publicite::delete($id);
                    $message = "La catégorie a été supprimée avec succès";
                    $this->session->write('succes',$message);
                    $return = array("statuts"=>0, "mes"=>$message);
                }catch (Exception $e){
                    $return = array("statuts"=>1, "mes"=>$this->error);
                }
            }else{
                $message = "La catégorie n'existe plus";
                $return = array("statuts"=>1, "mes"=>$message);
            }
        }else{
            $message = "Renseigner l'id SVP !!!";
            $return = array("statuts"=>1, "mes"=>$message);
        }
        echo json_encode($return);
    }

}