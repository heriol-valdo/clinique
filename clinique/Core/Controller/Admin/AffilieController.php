<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 23/01/2017
 * Time: 09:19
 */

namespace Projet\Controller\Admin;

use Exception;
use Projet\Database\affiliate_portfolio_project;
use Projet\Database\affiliate_project;
use Projet\Database\affiliate_project_files;
use Projet\Database\affiliate_user;
use Projet\Database\council;
use Projet\Database\schedule_meeting;
use Projet\Database\users;
use Projet\Database\wallet;
use Projet\Database\withdraw_request;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\EmailAll;
use Projet\Model\EmailDelete;
use Projet\Model\FileHelper;
use Projet\Model\Privilege;
use Projet\Model\StringHelper;

class AffilieController extends AdminController{

    public function index(){
        Privilege::hasPrivilege(Privilege::$eshopUserAffilieView,$this->user->privilege);
        $user = $this->user;
        $nbreParPage = 20;
        $s_search = (isset($_GET['search'])&&!empty($_GET['search'])) ? $_GET['search'] : null;
        $s_etat = (isset($_GET['etat'])&&!empty($_GET['etat'])) ? $_GET['etat']-1 : null;
        $s_sexe = (isset($_GET['sexe'])&&!empty($_GET['sexe'])) ? $_GET['sexe'] : null;
        $s_debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
        $s_end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
        $nbre = affiliate_user::countBySearchType($s_search,$s_sexe,$s_etat,$s_debut,$s_end);
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $profils = affiliate_user::searchType($nbreParPage,$pageCourante,$s_search,$s_sexe,$s_etat,$s_debut,$s_end);
        $this->render('admin.profil.affilies',compact('s_search','s_etat','s_sexe','s_debut','s_end','profils','user','nbre','nbrePages'));
    }

    public function detailPortfolio(){
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id'])&&!empty($_POST['id'])){
            $id = $_POST['id'];
            $item = affiliate_portfolio_project::find($id);
            if($item){
                $images = explode(',',$item->project_image);
                $tr = '<div class="grid"><div class="grid-sizer"></div>';
                if(!empty($images)){
                    foreach ($images as $image) {
                        $tr .= '<div class="grid-item">
                                <figure><img src="'.FileHelper::url($image).'"></figure>
                                <p class="text-center m-t-xxs m-b-xxs">
                                <a href="javascript:void(0);" data-image="'.$image.'" data-id="'.$item->id.'" data-url="'.App::url('affilies/portfolio/images/delete').'" class="deleteImage btn btn-sm btn-danger">
                                    Supprimer       
                                </a>
                                </p>
                                </div>';
                    }
                }
                $tr .= '</div>';
                $content = '<table class="table table-striped table-bordered m-t-sm">
                                <tbody>
                                <tr><td class="col-md-2">Nom projet</td><td>'.$item->project_name.'</td></tr>
                                <tr><td class="col-md-2">Description projet</td><td>'.$item->project_description.'</td></tr>
                                <tr><td class="col-md-2">Date ajout</td><td>'.DateParser::DateConviviale($item->date,1).'</td></tr>
                                </tbody>
                            </table>'.$tr.'';

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

    public function detailProject(){
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id'])&&!empty($_POST['id'])){
            $id = $_POST['id'];
            $item = affiliate_project::find($id);
            if($item){
                $images = explode(',',$item->images);
                $tr = '<div class="grid"><div class="grid-sizer"></div>';
                if(!empty($images)){
                    foreach ($images as $image) {
                        $tr .= '<div class="grid-item">
                                <figure><img src="'.FileHelper::url($image).'"></figure>
                                <p class="text-center m-t-xxs m-b-xxs">
                                <a href="javascript:void(0);" data-image="'.$image.'" data-id="'.$item->id.'" data-url="'.App::url('affilies/projects/images/delete').'" class="deleteImage btn btn-sm btn-danger">
                                    Supprimer       
                                </a>
                                </p>
                                </div>';
                    }
                }
                $tr .= '</div>';
                $content = '<table class="table table-striped table-bordered m-t-sm">
                                <tbody>
                                <tr><td class="col-md-2">Service</td><td>'.$item->service.'</td></tr>
                                <tr><td class="col-md-2">Nom projet</td><td>'.$item->project_name.'</td></tr>
                                <tr><td class="col-md-2">Description</td><td>'.$item->description.'</td></tr>
                                <tr><td class="col-md-2">Etat</td><td>'.StringHelper::$tabEtatPrimes[$item->status].'</td></tr>
                                <tr><td class="col-md-2">Date ajout</td><td>'.DateParser::DateConviviale($item->date,1).'</td></tr>
                                </tbody>
                            </table>'.$tr.'';

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

    public function detailsProject(){
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id'])&&!empty($_POST['id'])){
            $id = $_POST['id'];
            $item = affiliate_project::find($id);
            if($item){
                $exist = affiliate_project_files::exist($item->id);
                if($item->status==1&&$exist){
                    $tr_pdf = $tr_doc = '';
                    if(!empty($exist->pdf)){
                        $pdfs = explode(',',$exist->pdf);
                        $i1 = 1;
                        foreach ($pdfs as $pdf) {
                            $tr_pdf .= '<a href="'.$pdf.'" target="_blank" class="btn btn-sm btn-xxs btn-info m-r-xxs">
                                            PDF '.$i1.'
                                        </a>';
                            $i1++;
                        }
                    }
                    if(!empty($exist->doc)){
                        $docs = explode(',',$exist->doc);
                        $j1 = 1;
                        foreach ($docs as $doc) {
                            $tr_doc .= '<a href="'.$doc.'" target="_blank" class="btn btn-sm btn-xxs btn-info m-r-xxs">
                                            DOC '.$j1.'
                                        </a>';
                            $j1++;
                        }
                    }

                    $tr = '<div class="grid"><div class="grid-sizer"></div>';
                    if(!empty($exist->image)){
                        $images = explode(',',$exist->image);
                        foreach ($images as $image) {
                            $tr .= '<div class="grid-item">
                                <figure><img src="'.FileHelper::url($image).'"></figure>
                                <p class="text-center m-t-xxs m-b-xxs">
                                <a href="'.$image.'" target="_blank" class="btn btn-sm btn-primary">
                                    Télécharger       
                                </a>
                                </p>
                                </div>';
                        }
                    }
                    $affilie = affiliate_user::byId($item->affiliate_id);
                    $tr .= '</div>';
                    $content = '<table class="table table-striped table-bordered m-t-sm">
                                <tbody>
                                <tr><td class="col-md-2">Affilié</td><td>'.$affilie->username.'</td></tr>
                                <tr><td class="col-md-2">Service</td><td>'.$item->service.'</td></tr>
                                <tr><td class="col-md-2">Nom projet</td><td>'.$item->project_name.'</td></tr>
                                <tr><td class="col-md-2">Description</td><td>'.$item->description.'</td></tr>
                                <tr><td class="col-md-2">Etat</td><td>'.StringHelper::$tabEtatPrimes[$item->status].'</td></tr>
                                <tr><td class="col-md-2">Pdfs envoyés</td><td>'.$tr_pdf.'</td></tr>
                                <tr><td class="col-md-2">Words envoyés</td><td>'.$tr_doc.'</td></tr>
                                <tr><td class="col-md-2">Date réponse</td><td>'.DateParser::DateConviviale($exist->date,1).'</td></tr>
                                </tbody>
                            </table>'.$tr.'';

                    $return = array("statuts" => 0, "contenu" => $content);
                }else{
                    $message = "Aucune réponse trouvée";
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

    public function projects(){
        Privilege::hasPrivilege(Privilege::$eshopUserAffilieProjectView,$this->user->privilege);
        if(isset($_GET['id'])&&!empty($_GET['id'])){
            $id = $_GET['id'];
            $affilie = affiliate_user::byUser($id);
            if($affilie){
                $user = $this->user;
                $nbreParPage = 20;
                $etat = (isset($_GET['etat'])&&is_numeric($_GET['etat'])) ? $_GET['etat']-1 : null;
                $debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
                $end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
                $nbre = affiliate_project::countBySearchType($affilie->id,$etat,$debut,$end);
                $nbrePages = ceil($nbre->Total / $nbreParPage);
                if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                    $pageCourante = $_GET['page'];
                } else {
                    $pageCourante = 1;
                    $params['page'] = $pageCourante;
                }
                $projects = affiliate_project::searchType($nbreParPage,$pageCourante,$affilie->id,$etat,$debut,$end);
                $this->render('admin.profil.projects',compact('affilie','projects','user','nbre','nbrePages'));
            }else{
                App::error();
            }
        }else{
            App::error();
        }
    }

    public function portfolio(){
        Privilege::hasPrivilege(Privilege::$eshopUserAffilieProfolioView,$this->user->privilege);
        if(isset($_GET['id'])&&!empty($_GET['id'])){
            $id = $_GET['id'];
            $affilie = affiliate_user::byUser($id);
            if($affilie){
                $user = $this->user;
                $nbreParPage = 20;
                $debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
                $end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
                $nbre = affiliate_portfolio_project::countBySearchType($affilie->id,$debut,$end);
                $nbrePages = ceil($nbre->Total / $nbreParPage);
                if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                    $pageCourante = $_GET['page'];
                } else {
                    $pageCourante = 1;
                    $params['page'] = $pageCourante;
                }
                $projects = affiliate_portfolio_project::searchType($nbreParPage,$pageCourante,$affilie->id,$debut,$end);
                $this->render('admin.profil.portfolio',compact('affilie','projects','user','nbre','nbrePages'));
            }else{
                App::error();
            }
        }else{
            App::error();
        }
    }

    public function meetings(){
        Privilege::hasPrivilege(Privilege::$eshopMeetingView,$this->user->privilege);
        if(isset($_GET['id'])&&!empty($_GET['id'])){
            $id = $_GET['id'];
            $affilie = affiliate_user::byUser($id);
            if($affilie){
                $user = $this->user;
                $nbreParPage = 20;
                $etat = (isset($_GET['etat'])&&!empty($_GET['etat'])) ? $_GET['etat'] : null;
                $mode = (isset($_GET['mode'])&&!empty($_GET['mode'])) ? $_GET['mode'] : null;
                $debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
                $end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
                $nbre = schedule_meeting::countBySearchType($affilie->id,null,$mode,$etat,$debut,$end);
                $nbrePages = ceil($nbre->Total / $nbreParPage);
                if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                    $pageCourante = $_GET['page'];
                } else {
                    $pageCourante = 1;
                    $params['page'] = $pageCourante;
                }
                $meetings = schedule_meeting::searchType($nbreParPage,$pageCourante,$affilie->id,null,$mode,$etat,$debut,$end);
                $this->render('admin.profil.meetings',compact('affilie','meetings','user','nbre','nbrePages'));
            }else{
                App::error();
            }
        }else{
            App::error();
        }
    }

    public function delete(){
        Privilege::hasPrivilege(Privilege::$eshopUserAffilieDesactive,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])&&isset($_POST['etat']) && in_array($_POST['etat'],[0,1,2])){
            $id = $_POST['id'];
            $etat = $_POST['etat'];
            $profil = affiliate_user::byUser($id);
            if($profil){
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    affiliate_user::setEtat($etat,$profil->id);
                    if($etat==1){
                        users::setRole('Affiliate',$profil->userid);
                        if(!empty($profil->email)){
                            $mesMail1 = "Hi <b>$profil->username</b>, votre compte Afrikfid a été activé.<br>Vous pouvez à nouveau bénéficier des services et offres Afrikfid";
                            $mesMail1 .= $this->end_mail;
                            $emailer1 = new EmailAll($profil->email,"Activation du compte Plumers",
                                "$profil->username","","","Votre compte a été activé",
                                $mesMail1,$this->lien_app,$this->lien_text,"Plumers Account");
                            $emailer1->send();
                        }
                    }else{
                        if(!empty($profil->email)){
                            $mesMail1 = "Hi <b>$profil->username</b>, votre compte Plumers a été désactivé.<br>Vous ne pouvez plus bénéficier des services et offres Plumers <br>Contacter-nous pour quelque réclammation";
                            $mesMail1 .= "<br><i>Nous vous remercions de votre confiance</i>";
                            $mesMail1 .= "<br><br><b>Toute l'équipe Plumers</b>";
                            $emailer1 = new EmailDelete($profil->email,"Désactivation de votre compte Plumers",
                                "$profil->username",$mesMail1,"Afrikfid Account");
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

    public function deleteImage(){
        Privilege::hasPrivilege(Privilege::$eshopUserAffilieImgDel,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id'])&&!empty($_POST['id'])&&isset($_POST['image'])&&!empty($_POST['image'])){
            $id = $_POST['id'];
            $image = $_POST['image'];
            $item = affiliate_portfolio_project::find($id);
            if($item){
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    $tabs = [];
                    $images = explode(',',$item->project_image);
                    foreach ($images as $item) {
                        if($item!=$image){
                            $tabs[] = $item;
                        }
                    }
                    $root = implode(",",$tabs);
                    //FileHelper::deleteImage($image);
                    affiliate_portfolio_project::setImage($root,$id);
                    $message = "Image supprimée avec succès";
                    $return = array("statuts" => 0, "mes" => $message);
                    $pdo->commit();
                } catch(Exception $e){
                    $pdo->rollBack();
                    $erreur = $this->error;
                    $return = array("statuts"=>1, "mes"=>$erreur);
                }
            }else{
                $message = "Une erreur est apparue, recharger";
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = "Une erreur est apparue, recharger";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function repondreProject(){
        Privilege::hasPrivilege(Privilege::$eshopUserAffiliePjrojecAns,$this->user->privilege);
        header('content-type: application/json');
        if(isset($_FILES['pdf']['name'])&&isset($_FILES['doc']['name'])&&isset($_FILES['file']['name'])&&isset($_POST['idImage'])&&!empty($_POST['idImage'])){
            $id = $_POST['idImage'];
            $item = affiliate_project::find($id);
            if($item){
                if(count($_FILES['file'])>0){
                    $extensions_img_valides = array('jpg','jpeg','png','JPG','JPEG','PNG');
                    $extensions_pdf_valides = array('pdf','PDF');
                    $extensions_doc_valides = array('doc','docx','DOC','DOCX');
                    $pdo = App::getDb()->getPDO();
                    try{
                        $pdo->beginTransaction();
                        $j = 0;
                        $root_image = $root_pdf = $root_doc = "";

                        for($i=0;$i<count($_FILES['file']['name']);$i++){
                            if($_FILES['file']['error'][$i] == 0){
                                $extension_upload1 = strtolower(  substr(  strrchr($_FILES['file']['name'][$i], '.')  ,1)  );
                                if(in_array($extension_upload1,$extensions_img_valides)){
                                    if($_FILES['file']['size'][$i]<=1000000){
                                        $image_info = getimagesize($_FILES["file"]["tmp_name"][$i]);
                                        $image_width = $image_info[0];
                                        $image_height = $image_info[1];
                                        if($image_width==230&&$image_height==210){

                                        }
                                        $root1 = FileHelper::moveImageArticle($id,$_FILES['file']['tmp_name'][$i],"projects/images",$extension_upload1,"",true);
                                        if($root1){
                                            $root_image .= $j == 0 ? $root1 : ",$root1";
                                            $j++;
                                        }
                                    }
                                }
                            }
                        }

                        for($i=0;$i<count($_FILES['pdf']['name']);$i++){
                            if($_FILES['pdf']['error'][$i] == 0){
                                $extension_upload2 = strtolower(  substr(  strrchr($_FILES['pdf']['name'][$i], '.')  ,1)  );
                                if(in_array($extension_upload2,$extensions_pdf_valides)){
                                    if($_FILES['pdf']['size'][$i]<=20000000){
                                        $image_info = getimagesize($_FILES["pdf"]["tmp_name"][$i]);
                                        $image_width = $image_info[0];
                                        $image_height = $image_info[1];
                                        if($image_width==230&&$image_height==210){

                                        }
                                        $root2 = FileHelper::moveImageArticle($id,$_FILES['pdf']['tmp_name'][$i],"projects/pdfs",$extension_upload2,"",true);
                                        if($root2){
                                            $root_pdf .= $j == 0 ? $root2 : ",$root2";
                                            $j++;
                                        }
                                    }
                                }
                            }
                        }

                        for($i=0;$i<count($_FILES['doc']['name']);$i++){
                            if($_FILES['doc']['error'][$i] == 0){
                                $extension_upload3 = strtolower(  substr(  strrchr($_FILES['doc']['name'][$i], '.')  ,1)  );
                                if(in_array($extension_upload3,$extensions_doc_valides)){
                                    if($_FILES['doc']['size'][$i]<=20000000){
                                        $image_info = getimagesize($_FILES["doc"]["tmp_name"][$i]);
                                        $image_width = $image_info[0];
                                        $image_height = $image_info[1];
                                        if($image_width==230&&$image_height==210){

                                        }
                                        $root3 = FileHelper::moveImageArticle($id,$_FILES['doc']['tmp_name'][$i],"projects/docs",$extension_upload3,"",true);
                                        if($root3){
                                            $root_doc .= $j == 0 ? $root3 : ",$root3";
                                            $j++;
                                        }
                                    }
                                }
                            }
                        }

                        if($j>0){
                            $exist = affiliate_project_files::exist($item->id);
                            if($exist){
                                affiliate_project_files::save($item->affiliate_id,$item->id,$item->service,"","",$root_image,$root_pdf,$root_doc,$exist->id);
                            }else{
                                affiliate_project_files::save($item->affiliate_id,$item->id,$item->service,"","",$root_image,$root_pdf,$root_doc);
                            }
                            affiliate_project::setEtat(1,$item->id);
                            $return = "Le projet a été marqué comme réalisé avec succès";
                            $this->session->write('success',$return);
                            $pdo->commit();
                            $return = array("statuts"=>0, "mes"=>$return);
                        }else{
                            $pdo->rollBack();
                            $message = "Vous devez joindre au moins une image jpg ou png de 1 MB max";
                            $return = array("statuts" => 1, "mes" => $message);
                        }
                    }catch (Exception $e){
                        $pdo->rollBack();
                        $message = $this->error;
                        $return = array("statuts" => 1, "mes" => $message);
                    }
                }else{
                    $message = "Vous devez joindre au moins une image.";
                    $return = array("statuts" => 1, "mes" => $message);
                }
            }else{
                $message = "Une erreur est survenue";
                $return = array("statuts"=>1, "mes"=>$message);
            }
        }else{
            $message = $this->empty;
            $return = array("statuts"=>1, "mes"=>$message);
        }
        echo json_encode($return);
    }

    public function councils(){
        Privilege::hasPrivilege(Privilege::$eshopCouncilView,$this->user->privilege);
        if(isset($_GET['id'])&&!empty($_GET['id'])){
            $id = $_GET['id'];
            $affilie = affiliate_user::byUser($id);
            if($affilie){
                $user = $this->user;
                $nbreParPage = 20;
                $etat = (isset($_GET['etat'])&&is_numeric($_GET['etat'])) ? $_GET['etat']-1 : null;
                $debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
                $end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
                $nbre = council::countBySearchType($affilie->userid,$etat,$debut,$end);
                $nbrePages = ceil($nbre->Total / $nbreParPage);
                if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                    $pageCourante = $_GET['page'];
                } else {
                    $pageCourante = 1;
                    $params['page'] = $pageCourante;
                }
                $councils = council::searchType($nbreParPage,$pageCourante,$affilie->userid,$etat,$debut,$end);
                $this->render('admin.profil.councils',compact('affilie','councils','user','nbre','nbrePages'));
            }else{
                App::error();
            }
        }else{
            App::error();
        }
    }

    public function withdrawals(){
        Privilege::hasPrivilege(Privilege::$eshopDemandeRetraitView,$this->user->privilege);
        if(isset($_GET['id'])&&!empty($_GET['id'])){
            $id = $_GET['id'];
            $affilie = affiliate_user::byUser($id);
            if($affilie){
                $user = $this->user;
                $nbreParPage = 20;
                $etat = (isset($_GET['etat'])&&is_numeric($_GET['etat'])) ? $_GET['etat']-1 : null;
                $debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
                $end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
                $nbre = withdraw_request::countBySearchType($affilie->userid,$etat,$debut,$end);
                $nbrePages = ceil($nbre->Total / $nbreParPage);
                if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                    $pageCourante = $_GET['page'];
                } else {
                    $pageCourante = 1;
                    $params['page'] = $pageCourante;
                }
                $items = withdraw_request::searchType($nbreParPage,$pageCourante,$affilie->userid,$etat,$debut,$end);
                $this->render('admin.profil.withdrawals',compact('affilie','items','user','nbre','nbrePages'));
            }else{
                App::error();
            }
        }else{
            App::error();
        }
    }

    public function validWithdrawal(){
        Privilege::hasPrivilege(Privilege::$eshopDemandeRetraitValid,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])&&isset($_POST['etat']) && in_array($_POST['etat'],[1,2])){
            $id = $_POST['id'];
            $etat = $_POST['etat'];
            $item = withdraw_request::find($id);
            if($item&&$item->status==0){
                $wallet = wallet::byUser($item->user_id);
                if($wallet){
                    $bool = true;
                    if($etat==1)
                        if($wallet->amount<$item->amount)
                            $bool = "Vous n'avez pas assez de fonds dans votre wallet";
                    if(is_string($bool)){
                        $pdo = App::getDb()->getPDO();
                        try{
                            $pdo->beginTransaction();
                            withdraw_request::setEtat($etat,$item->id);
                            if($etat==1){
                                wallet::setSolde($wallet->amount-$item->amount,$wallet->id);
                            }
                            $message = "L'opération s'est déroulée avec succès";
                            $this->session->write('success',$message);
                            $pdo->commit();
                            $return = array("statuts" => 0, "mes" => $message);
                        }catch (Exception $e){
                            $pdo->rollBack();
                            $message = $this->error;
                            $return = array("statuts" => 1, "mes" => $message);
                        }
                    }else{
                        $return = array("statuts" => 1, "mes" => $bool);
                    }
                }else{
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

}