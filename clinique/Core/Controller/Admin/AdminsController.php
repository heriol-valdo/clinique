<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 23/01/2017
 * Time: 09:19
 */

namespace Projet\Controller\Admin;


use DateTime;
use Exception;
use Projet\Database\Annee;
use Projet\Database\Annonce;
use Projet\Database\Classe;
use Projet\Database\Conversation;
use Projet\Database\Cours;
use Projet\Database\Enseignant;
use Projet\Database\Matiere;
use Projet\Database\Message;
use Projet\Database\Pays;
use Projet\Database\Point;
use Projet\Database\Profil;
use Projet\Database\Profile;
use Projet\Database\Service;
use Projet\Database\Sollicitation;
use Projet\Database\SousCategorie;
use Projet\Database\Ville;
use Projet\Database\Vues;
use Projet\Database\Worker;
use Projet\Model\App;
use Projet\Model\DataHelper;
use Projet\Model\EmailAll;
use Projet\Model\FileHelper;
use Projet\Model\Privilege;
use Projet\Model\Random;
use Projet\Model\Sms;
use Projet\Model\StringHelper;

class AdminsController extends AdminController{

    public function index(){
        $user = $this->user;
        Privilege::hasPrivilege(Privilege::$eshopAdminView,$user->privilege);
        $nbreParPage = 20;
        $profiles = Profile::searchType();
        $search = (isset($_GET['search'])&&!empty($_GET['search'])) ? $_GET['search'] : null;
        $sexe = (isset($_GET['sexe'])&&!empty($_GET['sexe'])) ? $_GET['sexe'] : null;
        $login_debut = (isset($_GET['login_debut'])&&!empty($_GET['login_debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['login_debut'])) : null;
        $login_end = (isset($_GET['login_end'])&&!empty($_GET['login_end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['login_end'])) : null;
        $debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
        $end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
        $nbre = Profil::countBySearchType($search,$sexe,$debut,$end,$login_debut,$login_end);
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $profils = Profil::searchType($nbreParPage,$pageCourante,$search,$sexe,$debut,$end,$login_debut,$login_end);
        $this->render('admin.admin.index',compact('profiles','profils','user','nbre','nbrePages'));
    }

    public function save(){
        header('content-type: application/json');
        $return = [];
        $tab = ["add", "edit"];
        if (isset($_POST['nom']) && !empty($_POST['nom']) &&isset($_POST['prenom']) && !empty($_POST['prenom'])
            &&isset($_POST['sexe']) && !empty($_POST['sexe']) &&isset($_POST['numero']) && !empty($_POST['numero'])
            &&isset($_POST['email'])&&isset($_POST['profil'])&&!empty($_POST['profil'])
            && isset($_POST['action']) && !empty($_POST['action']) && isset($_POST['id']) && in_array($_POST["action"], $tab)) {
            $nom = trim($_POST['nom']);
            $prenom = trim($_POST['prenom']);
            $sexe = $_POST['sexe'];
            $numero = str_replace(' ','',trim($_POST['numero']));
            $email = trim($_POST['email']);
            $action = $_POST['action'];
            $id = (int)$_POST['id'];
            $errorEmail = "Cette adresse email existe déjà, veuillez le changer";
            $errorTel = "Ce numéro de téléphone existe déjà, veuillez le changer";
            $idProfil = $_POST['profil'];
            $profile = Profile::find($idProfil);
            if($profile){
                if($action == "edit") {
                    Privilege::hasPrivilege(Privilege::$eshopAdminEdits,$this->user->privilege);
                    if (!empty($id)){
                        $profil = Profil::find($id);
                        if ($profil) {
                            $bool = true;
                            $bool1 = true;
                            if($profil->numero!=$numero){
                                $cla = Profil::byNumero($numero);
                                if($cla)
                                    $bool1 = false;
                            }
                            if(!empty($email) && $profil->email!=$email){
                                $cla = Profil::byEmail($email);
                                if($cla)
                                    $bool = false;
                            }
                            if($bool1){
                                if($bool){
                                    $pdo = App::getDb()->getPDO();
                                    try{
                                        $pdo->beginTransaction();
                                        Profil::save($nom,$prenom,$numero,$sexe,$email,$profil->password,$profil->id);
                                        Profil::setProfile($idProfil,$profile->nom,$profile->privilege,$id);
                                        $message = "L'administrateur a été mis à jour avec succès";
                                        $this->session->write('success',$message);
                                        $pdo->commit();
                                        $return = array("statuts" => 0, "mes" => $message);
                                    }catch (Exception $e){
                                        $pdo->rollBack();
                                        $message = $this->error;
                                        $return = array("statuts" => 1, "mes" => $message);
                                    }
                                }else{
                                    $return = array("statuts" => 1, "mes" => $errorEmail);
                                }
                            }else{
                                $return = array("statuts" => 1, "mes" => $errorTel);
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
                    Privilege::hasPrivilege(Privilege::$eshopAdminAdds,$this->user->privilege);
                    $bool1 = true;
                    $cla = Profil::byNumero($numero);
                    if($cla)
                        $bool1 = false;
                    $bool = true;
                    if(!empty($email)){
                        $cla1 = Profil::byEmail($email);
                        if($cla1)
                            $bool = false;
                    }
                    if($bool1){
                        if($bool){
                            $pdo = App::getDb()->getPDO();
                            try{
                                $pdo->beginTransaction();
                                Profil::save($nom,$prenom,$numero,$sexe,$email,sha1("0000"));
                                $idLast = Profil::lastId();
                                Profil::setProfile($idProfil,$profile->nom,$profile->privilege,$idLast);
                                $message = "L'administrateur a été ajouté avec succès";
                                $this->session->write('success',$message);
                                $pdo->commit();
                                $return = array("statuts" => 0, "mes" => $message);
                            }catch (Exception $e){
                                $pdo->rollBack();
                                $message = $this->error;
                                $return = array("statuts" => 1, "mes" => $message);
                            }
                        }else{
                            $return = array("statuts" => 1, "mes" => $errorEmail);
                        }
                    }else{
                        $return = array("statuts" => 1, "mes" => $errorTel);
                    }
                }
            }else{
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        } else {
            $message = "Veiullez renseigner tous les champs requis";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function reset(){
        Privilege::hasPrivilege(Privilege::$eshopAdminReset,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $id = $_POST['id'];
            $profil = Profil::find($id);
            if ($profil&&$profil->roles==2){
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    $code = Random::number(4);
                    Profil::setPassword(sha1($code),$id);
                    if(!empty($profil->email)){
                        $mesMail1 = "Hi <b>$profil->nom</b>, votre mot de passe Plumers a été réinitialisé.<br>Nouveau mot de passe : $code.";
                        $mesMail1 .= $this->end_mail;
                        $emailer1 = new EmailAll($profil->email,"Réinitialisation du mot de passe",
                            "$profil->nom","","","Votre mot de passe a été réinitialisé",
                            $mesMail1,$this->lien_app,$this->lien_text,"Plumers Account");
                        $emailer1->send();
                    }
                    $message = "Le mot de passe a été changé avec succès";
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
            $message = $this->error;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function delete(){
        Privilege::hasPrivilege(Privilege::$eshopAdminActive,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])&&isset($_POST['etat']) && in_array($_POST['etat'],[0,1,2])){
            $id = $_POST['id'];
            $etat = $_POST['etat'];
            $profil = Profil::find($id);
            if($profil){
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    Profil::setEtat($etat,$id);
                    if($etat==1){
                        if(!empty($profil->email)){
                            $mesMail1 = "Hi <b>$profil->nom</b>, votre compte Afrikfid a été activé.<br>Vous pouvez à nouveau bénéficier des services et offres Afrikfid";
                            $mesMail1 .= $this->end_mail;
                            $emailer1 = new EmailAll($profil->email,"Activation du compte Plumers",
                                "$profil->nom","","","Votre compte a été activé",
                                $mesMail1,$this->lien_app,$this->lien_text,"Plumers Account");
                            $emailer1->send();
                        }
                    }else{
                        if(!empty($profil->email)){
                            $mesMail1 = "Hi <b>$profil->nom</b>, votre compte Plumers a été désactivé.<br>Vous ne pouvez plus bénéficier des services et offres Plumers <br>Contacter-nous pour quelque réclammation";
                            $mesMail1 .= "<br><i>Nous vous remercions de votre confiance</i>";
                            $mesMail1 .= "<br><br><b>Toute l'équipe Plumers</b>";
                            $emailer1 = new EmailDelete($profil->email,"Désactivation de votre compte Plumers",
                                "$profil->nom",$mesMail1,"Afrikfid Account");
                            $emailer1->send();
                        }
                    }
                    $message = "L'opération s'est passée avec succès";
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
            $message = $this->error;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function setPhoto(){
        Privilege::hasPrivilege(Privilege::$eshopAdminEditImg,$this->user->privilege);
        header('content-type: application/json');
        if(isset($_FILES['image']['name'])){
            $id = DataHelper::post('idPhoto');
            if(isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])&& !is_null($id) ){
                if ($_FILES['image']['error'] == 0){
                    $extensions_valides = array('jpg','jpeg','png','JPG','JPEG','PNG');
                    $extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
                    if(in_array($extension_upload,$extensions_valides)){
                        if($_FILES['image']['size']<=2000000){
                            $profil = Profil::find($id);
                            if($profil){
                                $pdo = App::getDb()->getPDO();
                                try{
                                    $pdo->beginTransaction();
                                    $root = FileHelper::moveImage($_FILES['image']['tmp_name'],"identity","png","",true);
                                    if (!empty($profil->photo) && strpos($profil->photo, 'images') === false){
                                        FileHelper::deleteImage($profil->photo);
                                    }
                                    if($root){
                                        Profil::setPhoto($root,$id);
                                        $success = "La photo a été mise à jour avec succès";
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
                            $erreur =  'Le fichier doit avoir une taille inférieur à 2M';
                            $result = array("statuts"=>1, "mes"=>$erreur);
                        }
                    }else{
                        $message = "Le fichier doit être une image";
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
            $message = $this->error;
            $result = array("statuts"=>1, "mes"=>$message);
        }
        echo json_encode($result);
    }

}