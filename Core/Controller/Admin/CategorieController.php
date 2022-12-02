<?php
	/**
	 * Created by PhpStorm.
	 * User: su
	 * Date: 20/08/2015
	 * Time: 14:04
	 */

namespace Projet\Controller\Admin;


use Exception;
use Projet\Database\Article;
use Projet\Database\Cat;
use Projet\Database\Categorie;
use Projet\Database\category;
use Projet\Database\Evenement;
use Projet\Database\products;
use Projet\Database\SousCategorie;
use Projet\Database\subcategory;
use Projet\Model\App;
use Projet\Model\DataHelper;
use Projet\Model\FileHelper;
use Projet\Model\Privilege;
use Projet\Model\StringHelper;

class CategorieController extends AdminController {

    public function index(){
        Privilege::hasPrivilege(Privilege::$eshopProductSubCatView,$this->user->privilege);
        $categories = category::searchType();
        $user = $this->user;
        $params = $_GET;
        $nbreParPage = 20;
        $categorie = (isset($_GET['categorie'])&&!empty($_GET['categorie'])) ? $_GET['categorie'] : null;
        $search = (isset($_GET['search'])&&!empty($_GET['search'])) ? $_GET['search'] : null;
        $nbre = subcategory::countBySearchType($categorie,$search);
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $sous = subcategory::searchType($nbreParPage, $pageCourante,$categorie,$search);
        $this->render('admin.categorie.categorie',compact('categories','sous','nbrePages','nbre','user'));

    }

    public function save(){

        $result = [];
        header('content-type: application/json');
        if (isset($_POST['name'])&&!empty($_POST['name'])&& isset($_POST['action']) && !empty($_POST['action'])
            && isset($_POST['idPays'])&&!empty($_POST['idPays']) &&isset($_POST['id'])){
            $nom = trim($_POST['name']);
            $id = $_POST['id'];
            $idCat = $_POST['idPays'];
            $action = $_POST['action'];
            $categorie = category::find($idCat);
            if($categorie){
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    if($action == 'add'){
                        Privilege::hasPrivilege(Privilege::$eshopProductSubCatAdd,$this->user->privilege);
                        if(!subcategory::byNom($nom)){
                            subcategory::save($idCat,$nom);
                            $message = "La sous catégorie a bien été ajoutée";
                            $this->session->write('success',$message);
                            $pdo->commit();
                            $result = array("statuts"=>0, "mes"=>$message);
                        }else{
                            $message = "Cette catégorie existe déjà";
                            $result = array("statuts"=>1, "mes"=>$message);
                        }
                    }elseif($action == 'edit'){
                        Privilege::hasPrivilege(Privilege::$eshopProductSubCatEdit,$this->user->privilege);
                        $exist = subcategory::find($id);
                        if($exist){
                            $bool = true;
                            if($exist->subcategory_name!=$nom&&subcategory::byNom($nom))
                                $bool = false;
                            if($bool){
                                subcategory::save($idCat,$nom,$id);
                                $message = "La sous catégorie a bien été modifiée";
                                $this->session->write('success',$message);
                                $pdo->commit();
                                $result = array("statuts"=>0, "mes"=>$message);
                            }else{
                                $message = "Cette sous catégorie existe déjà";
                                $result = array("statuts"=>1, "mes"=>$message);
                            }
                        }else{
                            $message = "Cette sous catégorie n'existe pas";
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
        Privilege::hasPrivilege(Privilege::$eshopProductCatDelete,$this->user->privilege);
        header('content-type: application/json');
        if (isset($_POST['id'])&&!empty($_POST['id'])){
            $id = $_POST['id'];
            $item = subcategory::find($id);
            if ($item){
                $nbre = products::countBySearchType(null,null,$id);
                if($nbre->Total==0){
                    subcategory::delete($id);
                    if (!empty($item->subcategory_image) && strpos($item->subcategory_image, 'assets/img') === false){
                        FileHelper::deleteImage('public/'.$item->subcategory_image);
                    }
                    $message = "La sous catégorie a été supprimée avec succès";
                    $this->session->write('succes',$message);
                    $return = array("statuts"=>0, "mes"=>$message);
                }else{
                    $message = "La sous catégorie ne peut être supprimée car elle contient des produits";
                    $return = array("statuts"=>1, "mes"=>$message);
                }
            }else{
                $message = "La sous catégorie n'existe plus";
                $return = array("statuts"=>1, "mes"=>$message);
            }
        }else{
            $message = "Renseigner l'id SVP !!!";
            $return = array("statuts"=>1, "mes"=>$message);
        }
        echo json_encode($return);
    }

    public function setImage(){
        Privilege::hasPrivilege(Privilege::$eshopProductSubCatImg,$this->user->privilege);
        header('content-type: application/json');
        if(isset($_FILES['file']['name'])){
            $id = DataHelper::post('idPhoto');
            if(isset($_FILES['file']['tmp_name']) && !empty($_FILES['file']['tmp_name'])&& !is_null($id) ){
                if ($_FILES['file']['error'] == 0){
                    $extensions_valides = array('jpg','jpeg','png','JPG','JPEG','PNG');
                    $extension_upload = strtolower(  substr(  strrchr($_FILES['file']['name'], '.')  ,1)  );
                    if(in_array($extension_upload,$extensions_valides)){
                        if($_FILES['file']['size']<=1000000){
                            $item = subcategory::find($id);
                            if($item){
                                $pdo = App::getDb()->getPDO();
                                try{
                                    $pdo->beginTransaction();
                                    $root = FileHelper::moveImage($_FILES['file']['tmp_name'],"cats",$extension_upload,"",true);
                                    if($root){
                                        if (!empty($item->subcategory_image) && strpos($item->subcategory_image, 'assets/img') === false){
                                            FileHelper::deleteImage('public/'.$item->subcategory_image);
                                        }
                                        subcategory::setImage($root,$id);
                                        $success = "L'image a été mise à jour avec succès";
                                        $this->session->write('success',$success);
                                        $pdo->commit();
                                        $return = array("statuts"=>0, "mes"=>$success);
                                    }else{
                                        $erreur = $this->error;
                                        $return = array("statuts"=>1, "mes"=>$erreur);
                                    }
                                } catch(Exception $e){
                                    $pdo->rollBack();
                                    $erreur = $this->error;
                                    $return = array("statuts"=>1, "mes"=>$erreur);
                                }
                            } else{
                                $erreur =  'Une erreur est survenue, recharger et réessayer';
                                $return = array("statuts"=>1, "mes"=>$erreur);
                            }
                        }else{
                            $erreur =  'Le fichier doit avoir une taille inférieur à 1M';
                            $return = array("statuts"=>1, "mes"=>$erreur);
                        }
                    }else{
                        $message = "Le fichier doit être une image";
                        $return = array("statuts"=>1, "mes"=>$message);
                    }
                }else{
                    $message = $this->error;
                    $return = array("statuts"=>1, "mes"=>$message);
                }
            }else{
                $message = "Vous devez uploader un fichier";
                $return = array("statuts"=>1, "mes"=>$message);
            }
        }else{
            $message = "Please fill all input";
            $return = array("statuts"=>1, "mes"=>$message);
        }
        echo json_encode($return);
    }

    public function detail(){
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id'])&&!empty($_POST['id'])){
            $id = $_POST['id'];
            $sous = subcategory::find($id);
            if($sous){
                $cat = category::find($sous->category_id);
                $tr = !empty($sous->subcategory_image) ? '<tr><td colspan="2"><div class="col-md-12" style="margin-bottom: 10px">
                                <img src="'.FileHelper::url($sous->subcategory_image).'" style="width: 100%;">
                                </div></td></tr>' : '';
                $content = '<table class="table table-striped table-bordered m-t-sm">
                                <tbody>
                                <tr><td class="col-md-5">Catégorie</td><td>'.ucfirst($cat->category_name).'</td></tr>
                                <tr><td class="col-md-5">Intitulé</td><td>'.ucfirst($sous->subcategory_name).'</td></tr>
                                '.$tr.'</tbody>
                            </table>';

                $return = array("statuts" => 0, "contenu" => $content);
            }else{
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = $this->error;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

}