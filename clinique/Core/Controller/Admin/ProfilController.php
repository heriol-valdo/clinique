<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 23/01/2017
 * Time: 09:19
 */

namespace Projet\Controller\Admin;

use Exception;
use Projet\Database\affiliate_off_days;
use Projet\Database\affiliate_portfolio_profile;
use Projet\Database\affiliate_user;
use Projet\Database\Commande;
use Projet\Database\council;
use Projet\Database\customer_project;
use Projet\Database\orders;
use Projet\Database\Profil;
use Projet\Database\project_payment;
use Projet\Database\project_request_for_affiliate;
use Projet\Database\users;
use Projet\Database\wallet;
use Projet\Database\withdraw_request;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\EmailAll;
use Projet\Model\EmailDelete;
use Projet\Model\FileHelper;
use Projet\Model\Privilege;
use Projet\Model\Random;
use Projet\Model\StringHelper;

class ProfilController extends AdminController{

    public function index(){
        Privilege::hasPrivilege(Privilege::$eshopGestionProfils,$this->user->privilege);
        $user = $this->user;
        $nbreParPage = 20;

        $s_search = (isset($_GET['search'])&&!empty($_GET['search'])) ? $_GET['search'] : null;
        $s_role = (isset($_GET['role'])&&!empty($_GET['role'])) ? $_GET['role'] : null;
        $s_etat = (isset($_GET['etat'])&&!empty($_GET['etat'])) ? $_GET['etat']-1 : null;
        $s_sexe = (isset($_GET['sexe'])&&!empty($_GET['sexe'])) ? $_GET['sexe'] : null;
        $s_debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
        $s_end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
        $nbre = users::countBySearchType($s_search,$s_sexe,$s_etat,$s_role,$s_debut,$s_end);
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $profils = users::searchType($nbreParPage,$pageCourante,$s_search,$s_sexe,$s_etat,$s_role,$s_debut,$s_end);
        $this->render('admin.profil.index',compact('s_search','s_etat','s_sexe','s_role','s_debut','s_end','profils','user','nbre','nbrePages'));
    }

    public function detail(){
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id'])&&!empty($_POST['id'])){
            $id = $_POST['id'];
            $profil = users::find($id);
            if($profil){
                $wallet = wallet::byUser($profil->userid);
                $tr = '';
                $affilie = affiliate_user::byUser($id);
                $i = '12';
                if($affilie){
                    $tr = '<div class="col-md-6"><table class="table table-striped table-bordered m-t-sm"><thead><tr><th class="bg-primary text-center" colspan="2">Section Affilié</th></tr></thead><tbody>';
                    $portofolio_profile = affiliate_portfolio_profile::byAffilie($affilie->id);
                    if($portofolio_profile){
                        $tr .= '<tr><td class="col-md-3">Catégorie</td><td>'.$portofolio_profile->category.'</td></tr>
                                    <tr><td class="col-md-3">Linkedin Link</td><td>'.$portofolio_profile->linkedin_link.'</td></tr>
                                    <tr><td class="col-md-3">Facebook Link</td><td>'.$portofolio_profile->fb_link.'</td></tr>
                                    <tr><td class="col-md-3">Mini bio</td><td>'.$portofolio_profile->description.'</td></tr>';
                    }
                    $tr1 = '<tr><td>Jours Off</td>';
                    $off_days = affiliate_off_days::searchType(null,null,$affilie->id);
                    if(!empty($off_days)){
                        $tr1 .= '<td>';
                        foreach ($off_days as $off_day) {
                            $tr1 .= '<p>'.DateParser::DateShort($off_day->date).'</p>';
                        }
                        $tr1 .= '</td>';
                    }else{
                        $tr1 .= '<td class="text-danger">Pas renseigné</td>';
                    }
                    $tr1 .= '</tr>';
                    $tr .= '<tr><td class="col-md-3">Gains</td><td>'.float_value($affilie->earnings).'</td></tr>
                            <tr><td class="col-md-3">Numéro de compte</td><td>'.StringHelper::isEmpty($affilie->accountnumber).'</td></tr>
                            <tr><td class="col-md-3">Numéro de routing</td><td>'.StringHelper::isEmpty($affilie->routingNumber).'</td></tr>
                            <tr><td class="col-md-3">Etat Affilié</td><td>'.StringHelper::$tabState[$affilie->etat].'</td></tr>
                            <tr><td class="col-md-3">Date affiliation</td><td>'.DateParser::DateConviviale($affilie->date,1).'</td></tr>'.$tr1;
                    $tr .= '</tbody></table></div>';
                    $i = '6';
                }
                $content = '<div class="row"><div class="col-md-'.$i.'"><table class="table table-striped table-bordered m-t-sm">
                                <thead><tr><th colspan="2" class="bg-primary text-center">Section Client</th></tr></thead>
                                <tbody>
                                <tr><td colspan="2" class="text-center"><img style="height: 150px; max-width: 100%" src="'.FileHelper::url($profil->profileimg).'"></td></tr>
                                <tr><td class="col-md-3">Etat Client</td><td>'.StringHelper::$tabState[$profil->status].'</td></tr>
                                <tr><td class="col-md-3">Solde Wallet</td><td>'.$wallet->secetkey.'</td></tr>
                                <tr><td class="col-md-3">Clé Wallet</td><th>$'.float_value($wallet->amount).'</th></tr>
                                <tr><td class="col-md-3">Nom</td><td>'.$profil->fname.'</td></tr>
                                <tr><td class="col-md-3">Prénom</td><td>'.$profil->lname.'</td></tr>
                                <tr><td class="col-md-3">Sexe</td><td>'.StringHelper::isEmpty($profil->gender).'</td></tr>
                                <tr><td class="col-md-3">Numéro de téléphone</td><td>'.StringHelper::isEmpty($profil->mobile).'</td></tr>
                                <tr><td class="col-md-3">Email</td><td>'.StringHelper::isEmpty($profil->email,1).'</td></tr>
                                <tr><td class="col-md-3">Clé secrete</td><td>'.StringHelper::isEmpty($profil->secetkey).'</td></tr>
                                <tr><td class="col-md-3">Pays</td><td>'.StringHelper::isEmpty($profil->country).'</td></tr>
                                <tr><td class="col-md-3">Ville</td><td>'.StringHelper::isEmpty($profil->city).'</td></tr>
                                <tr><td class="col-md-3">Adresse</td><td>'.StringHelper::isEmpty($profil->address).'</td></tr>
                                <tr><td class="col-md-3">Code ZIP</td><td>'.StringHelper::isEmpty($profil->zip).'</td></tr>
                                <tr><td class="col-md-3">Latitude</td><td>'.StringHelper::isEmpty($profil->latitude).'</td></tr>
                                <tr><td class="col-md-3">Longitude</td><td>'.StringHelper::isEmpty($profil->longitude).'</td></tr>
                                <tr><td class="col-md-3">Chat Id</td><td>'.StringHelper::isEmpty($profil->chat_uid).'</td></tr>
                                <tr><td class="col-md-3">Chat Api Key</td><td>'.StringHelper::isEmpty($profil->chat_apiKey).'</td></tr>
                                <tr><td class="col-md-3">Token</td><td style="word-break: break-all"><small>'.StringHelper::isEmpty($profil->fcmToken).'</small></td></tr>
                                <tr><td class="col-md-3">App version</td><td>'.StringHelper::isEmpty($profil->appVersion).'</td></tr>
                                <tr><td class="col-md-3">Device Id</td><td>'.StringHelper::isEmpty($profil->deviceId).'</td></tr>
                                <tr><td class="col-md-3">Device Type</td><td>'.StringHelper::isEmpty($profil->deviceType).'</td></tr>
                                <tr><td class="col-md-3">Date création du compte</td><td>'.DateParser::DateConviviale($profil->created_on,1).'</td></tr>
                                </tbody>
                            </table></div>'.$tr.'</div>';

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

    public function commandes(){
        Privilege::hasPrivilege(Privilege::$eshopCommandView,$this->user->privilege);
        if(isset($_GET['id'])&&!empty($_GET['id'])){
            $id = $_GET['id'];
            $profil = users::find($id);
            if($profil){
                $user = $this->user;
                $nbreParPage = 50;
                $s_etat = (isset($_GET['etat'])&&!empty($_GET['etat'])) ? $_GET['etat'] : null;
                $s_ref = (isset($_GET['ref'])&&!empty($_GET['ref'])) ? $_GET['ref'] : null;
                $s_debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
                $s_end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
                $nbre = orders::countBySearchType($profil->userid,$s_ref,$s_etat,$s_debut,$s_end);
                $nbrePages = ceil($nbre->Total / $nbreParPage);
                if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                    $pageCourante = $_GET['page'];
                } else {
                    $pageCourante = 1;
                    $params['page'] = $pageCourante;
                }
                $commandes = orders::searchType($nbreParPage,$pageCourante,$profil->userid,$s_ref,$s_etat,$s_debut,$s_end);
                $this->render('admin.profil.commandes',compact('id','profil','s_etat','s_debut','s_end','s_ref','commandes','user','nbre','nbrePages'));
            }else{
                App::error();
            }
        }else{
            App::error();
        }
    }

    public function reset(){
        Privilege::hasPrivilege(Privilege::$eshopUserClientReset,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $id = $_POST['id'];
            $profil = users::find($id);
            if ($profil){
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    $code = Random::number(6);
                    users::setPassword(sha1($code),$id);
                    if(!empty($profil->email)){
                        $mesMail1 = "Hi <b>$profil->username</b>, votre mot de passe Plumers a été réinitialisé.<br>Nouveau mot de passe : $code.";
                        $mesMail1 .= $this->end_mail;
                        $emailer1 = new EmailAll($profil->email,"Réinitialisation du mot de passe",
                            "$profil->username","","","Votre mot de passe a été réinitialisé",
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
        Privilege::hasPrivilege(Privilege::$eshopUserClientActive,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])&&isset($_POST['etat']) && in_array($_POST['etat'],[0,1,2])){
            $id = $_POST['id'];
            $etat = $_POST['etat'];
            $profil = users::find($id);
            if($profil){
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    users::setEtat($etat,$id);
                    if($etat==1){
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

    public function detailProject(){
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id'])&&!empty($_POST['id'])){
            $id = $_POST['id'];
            $item = customer_project::find($id);
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
                $explodes = explode(',',$item->affiliate_ids);
                $i = 0;
                $nom = '';
                foreach ($explodes as $explode) {
                    $affilie = affiliate_user::byId($explode);
                    $nom  .= $i == 0 ? $affilie->username : ", $affilie->username";
                    $i++;
                }
                $tr .= '</div>';
                $nom_client = '';
                $client = users::find($item->customer_id);
                if($client)
                    $nom_client = $client->username;
                $content = '<table class="table table-striped table-bordered m-t-sm">
                                <tbody>
                                <tr><td class="col-md-2">Categorie</td><td>'.$item->category.'</td></tr>
                                <tr><td class="col-md-2">Client</td><th>'.$nom_client.'</th></tr>
                                <tr><td class="col-md-2">Affilié(s)</td><th>'.$nom.'</th></tr>
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
            $item = customer_project::find($id);
            if($item){
                $content = '<table class="table table-striped table-bordered m-t-sm">
                            <thead><tr><th>Affilié</th><th>Etat demande</th><th>Etat paiement</th><th class="text-right">Prix</th><th>Id paiement</th><th>Date paiement</th></tr></thead>
                            <tbody>
                            ';
                $projets = project_request_for_affiliate::searchType(null,null,null,null,null,$id);
                foreach ($projets as $projet) {
                    $affilie = affiliate_user::byId($projet->affiliate_id);
                    $prix = $etat_payment = $id_payment = $date_payment = '<i class="text-danger">Demande en traitement</i>';
                    $payment = project_payment::find($projet->id);
                    if($payment){
                        $prix = '$ '.float_value($payment->project_price);
                        $etat_payment = StringHelper::$tabCommandeState[$payment->payment_status];
                        $id_payment = $payment->txn_id;
                        $date_payment = DateParser::DateShort($payment->created_date,1);
                    }
                    $content .= '
                                <tr>
                                    <td>'.$affilie->username.'</td>
                                    <td>'.StringHelper::$tabEtatPrime[$projet->customer_project_reguest_status].'</td>
                                    <td>'.$etat_payment.'</td>
                                    <td class="text-right">'.$prix.'</td>
                                    <td>'.$id_payment.'</td>
                                    <td>'.$date_payment.'</td>
                                </tr>
                                ';
                }
                $content .= '</tbody></table>';
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

    public function projects(){
        Privilege::hasPrivilege(Privilege::$eshopProjectClientView,$this->user->privilege);
        if(isset($_GET['id'])&&!empty($_GET['id'])){
            $id = $_GET['id'];
            $profil = users::find($id);
            if($profil){
                $user = $this->user;
                $nbreParPage = 20;
                $etat = (isset($_GET['etat'])&&is_numeric($_GET['etat'])) ? $_GET['etat']-1 : null;
                $debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
                $end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
                $nbre = customer_project::countBySearchType($profil->userid,null,null,$etat,$debut,$end);
                $nbrePages = ceil($nbre->Total / $nbreParPage);
                if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                    $pageCourante = $_GET['page'];
                } else {
                    $pageCourante = 1;
                    $params['page'] = $pageCourante;
                }
                $projects = customer_project::searchType($nbreParPage,$pageCourante,$profil->userid,null,null,$etat,$debut,$end);
                $this->render('admin.profil.projets',compact('profil','projects','user','nbre','nbrePages'));
            }else{
                App::error();
            }
        }else{
            App::error();
        }
    }

    public function change(){
        Privilege::hasPrivilege(Privilege::$eshopAdminActivate,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])&&isset($_POST['etat']) && in_array($_POST['etat'],[0,1,2,3])){
            $id = $_POST['id'];
            $etat= $_POST['etat'];
            if($etat==0)  {
                $transit_status='Order Placed';
            } elseif ($etat==1) {
                $transit_status='Order is in Production';
            } elseif ($etat==2){
                $transit_status='Order in Delivery';
            } else{
                $transit_status='Order is Delivered';
            }
            $order = orders::find($id);
            if($order){
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    orders::setStatus($transit_status,$id);
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

}