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
use Projet\Database\affiliate_project;
use Projet\Database\affiliate_user;
use Projet\Database\category;
use Projet\Database\checkout_orders;
use Projet\Database\Contact;
use Projet\Database\council;
use Projet\Database\customer_project;
use Projet\Database\orders;
use Projet\Database\products;
use Projet\Database\project_payment;
use Projet\Database\schedule_meeting;
use Projet\Database\subcategory;
use Projet\Database\Profil;
use Projet\Database\users;
use Projet\Database\Visite;
use Projet\Database\withdraw_request;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\Privilege;
use Projet\Model\StringHelper;

class HomeController extends AdminController{
    
    public function index(){
        Privilege::hasPrivilege(Privilege::$eshopDashboardView,$this->user->privilege);
        $user = $this->user;
        $current = date(DATE_FORMAT);
        $this->render('admin.user.index',compact('user','current'));
    }

    public function charts(){
        Privilege::hasPrivilege(Privilege::$eshopDashboardView,$this->user->privilege);
        sleep(3);
        header('content-type: application/json');
        $return = [];
        $current = date(MYSQL_DATE_FORMAT);

        $clients1 = users::countBySearchType(null,null,null,null,$current,$current);
        $clients2 = users::countBySearchType();
        $clients3 = users::countBySearchType(null,null,0);

        $affilies1 = affiliate_user::countBySearchType(null,null,null,$current,$current);
        $affilies2 = affiliate_user::countBySearchType();
        $affilies3 = affiliate_user::countBySearchType(null,null,0);

        $rdv1 = schedule_meeting::countBySearchType(null,null,null,null,$current,$current);
        $rdv2 = schedule_meeting::countBySearchType();
        $rdv3 = schedule_meeting::countBySearchType(null,null,null,'Pending');

        $projets1 = affiliate_project::countBySearchType(null,null,$current,$current);
        $projets2 = affiliate_project::countBySearchType();
        $projets3 = affiliate_project::countBySearchType(null,0);

        $conseils1 = council::countBySearchType(null,null,$current,$current);
        $conseils2 = council::countBySearchType();
        $conseils3 = council::countBySearchType(null,0);

        $pro1 = customer_project::countBySearchType(null,null,null,null,$current,$current);
        $pro2 = customer_project::countBySearchType();
        $pro3 = customer_project::countBySearchType(null,null,null,0);

        $com1 = orders::countBySearchType(null,null,null,$current,$current);
        $com2 = orders::countBySearchType();
        $com3 = orders::countBySearchType(null,null,0);

        $proj1 = project_payment::countBySearchType(null,null,'succeeded',$current,$current);
        $proj2 = project_payment::countBySearchType(null,null,'succeeded');

        $prod1 = products::countBySearchType(null,null,null,null,1);
        $prod2 = products::countBySearchType();
        $prod3 = products::countBySearchType(null,null,null,null,null,0);

        $ret1 = withdraw_request::countBySearchType(null,null,$current,$current);
        $ret2 = withdraw_request::countBySearchType();
        $ret3 = withdraw_request::countBySearchType(null,0);

        $art1 = checkout_orders::countBySearchType(null,null,null,$current,$current);
        $art2 = checkout_orders::countBySearchType();
        $art3 = checkout_orders::countBySearchType(null,null,'Pending');

        $commandes = orders::searchType(25,1);
        $projets = project_payment::searchType(25,1,null,null,'succeeded');

        $return = array("statuts" => 0, "clients1" => $clients1, "clients2" => $clients2, "clients3" => $clients3
            , "affilies1" => $affilies1, "affilies2" => $affilies2, "affilies3" => $affilies3
            , "projets1" => $projets1, "projets2" => $projets2, "projets3" => $projets3
            , "ret1" => $ret1, "ret2" => $ret2, "ret3" => $ret3, "art1" => $art1, "art2" => $art2, "art3" => $art3
            , "conseils1" => $conseils1, "conseils2" => $conseils2, "conseils3" => $conseils3
            , "com1" => $com1, "com2" => $com2, "com3" => $com3, "prod1" => $prod1, "prod2" => $prod2, "prod3" => $prod3
            , "rdv1" => $rdv1, "rdv2" => $rdv2, "rdv3" => $rdv3, "pro1" => $pro1, "pro2" => $pro2, "pro3" => $pro3
            , "commandes" => $commandes, "projets" => $projets, "proj1" => $proj1, "proj2" => $proj2
        );
        echo json_encode($return);
    }

    public function load(){
        Privilege::hasPrivilege(Privilege::$eshopDashboardAffaire,$this->user->privilege);
        $return = [];
        header('content-type: application/json');
        if (isset($_POST['debut'])  && !empty($_POST['debut']) && isset($_POST['fin'])
            && !empty($_POST['fin']) && isset($_POST['way']) && in_array($_POST['way'],[1,2])){
            $debut = new DateTime($_POST['debut']);
            $fin = new DateTime($_POST['fin']);
            $way = $_POST['way'];
            if($way==1){
                $value = orders::countBySearchType(null,null,null,$debut->format(MYSQL_DATE_FORMAT),$fin->format(MYSQL_DATE_FORMAT))->somme;
                $commandes = orders::searchType(25,1,null,null,null,$debut->format(MYSQL_DATE_FORMAT),$fin->format(MYSQL_DATE_FORMAT));
                $return = array("statuts"=>0, "value"=>$value, "commandes" => $commandes);
            }else{
                $projets = project_payment::searchType(25,1,null,null,'succeeded',$debut->format(MYSQL_DATE_FORMAT),$fin->format(MYSQL_DATE_FORMAT));
                $value = project_payment::countBySearchType(null,null,'succeeded',$debut->format(MYSQL_DATE_FORMAT),$fin->format(MYSQL_DATE_FORMAT))->somme;
                $return = array("statuts"=>0, "value"=>$value, "projets" => $projets);
            }
        }else{
            $message = "Une erreur est survenue, réessayer";
            $return = array("statuts"=>1, "mes"=>$message);
        }
        echo json_encode($return);
    }

    public function withdrawals(){
        Privilege::hasPrivilege(Privilege::$eshopDemandeRetraitView,$this->user->privilege);
        $user = $this->user;
        $nbreParPage = 50;
        $etat = (isset($_GET['etat'])&&is_numeric($_GET['etat'])) ? $_GET['etat']-1 : null;
        $debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
        $end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
        $nbre = withdraw_request::countBySearchType(null,$etat,$debut,$end);
        $in = withdraw_request::countBySearchType(null,1,$debut,$end);
        $pending = withdraw_request::countBySearchType(null,0,$debut,$end);
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $items = withdraw_request::searchType($nbreParPage,$pageCourante,null,$etat,$debut,$end);
        $this->render('admin.user.withdrawals',compact('in','pending','etat','debut','end','items','user','nbre','nbrePages'));
    }

    public function password(){
        $user = $this->user;
        $this->render('admin.user.password',compact('user'));
    }

    public function changePassword(){
        $return = [];
        header('content-type: application/json');
        if (isset($_POST['oldpassword'])  && !empty($_POST['oldpassword']) && isset($_POST['newpassword'])
            && !empty($_POST['newpassword']) && isset($_POST['confirmpassword']) && !empty($_POST['confirmpassword'])){
            $user = $this->user;
            $oldpass = $_POST['oldpassword'];
            $newpass = $_POST['newpassword'];
            $confirmpass = $_POST['confirmpassword'];
            if($user->password == sha1($oldpass)){
                if ($newpass == $confirmpass){
                    $pdo = App::getDb()->getPDO();
                    try{
                        $pdo->beginTransaction();
                        Profil::setPassword(sha1($newpass),$user->id);
                        $message = "Votre mot de passe a été modifié avec succès";
                        $pdo->commit();
                        $return = array("statuts"=>0, "mes"=>$message);
                    }catch(Exception $e){
                        $pdo->rollBack();
                        $message = "Une erreur est survenue, réessayer";
                        $return = array("statuts"=>1, "mes"=>$message);
                    }
                }else{
                    $message = "Le nouveau mot de passe doit être identique à la confirmation";
                    $return = array("statuts"=>1, "mes"=>$message);
                }
            }else{
                $message = "Votre mot de passe actuel est incorrect";
                $return = array("statuts"=>1, "mes"=>$message);
            }
        }else{
            $message = "Une erreur est survenue, réessayer";
            $return = array("statuts"=>1, "mes"=>$message);
        }
        echo json_encode($return);
    }

    public function loader(){
        $return = [];
        header('content-type: application/json');
        if(isset($_POST['val'])&&!empty($_POST['val'])){
            $val = $_POST['val'];
            $cat = category::find($val);
            if($cat){
                $sous = subcategory::searchType(null,null,$val);
                $content = "";
                foreach ($sous as $sou) {
                    $content .= '<option value="'.$sou->id.'">'.$sou->subcategory_name.'</option>';
                }
                $return = array("statuts" => 0, "con"=>$content);
            }else{
                $return = array("statuts" => 1);
            }
        }else{
            $return = array("statuts" => 1);
        }
        echo json_encode($return);
    }

    public function visites(){
        Privilege::hasPrivilege(Privilege::$eshopOtherVisitView,$this->user->privilege);
        $user = $this->user;
        $params = $_GET;
        $nbreParPage = 50;
        if (isset($_GET['debut'])&&isset($_GET['end'])) {
            $debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
            $end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
            $nbre = Visite::countBySearchType($debut,$end);
            $nbrePages = ceil($nbre->Total / $nbreParPage);
            if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                $pageCourante = $_GET['page'];
            } else {
                $pageCourante = 1;
                $params['page'] = $pageCourante;
            }
            $visites = Visite::searchType($nbreParPage,$pageCourante,$debut,$end);
        } else {
            $nbre = Visite::countBySearchType();
            $nbrePages = ceil($nbre->Total / $nbreParPage);
            if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                $pageCourante = $_GET['page'];
            } else {
                $pageCourante = 1;
                $params['page'] = $pageCourante;
            }
            $visites = Visite::searchType($nbreParPage,$pageCourante);
        }
        $this->render('admin.user.visites', compact('user','visites','nbrePages', 'nbre'));
    }

    public function suggestions(){
        Privilege::hasPrivilege(Privilege::$eshopOtherSugestionView,$this->user->privilege);
        $user = $this->user;
        $params = $_GET;
        $nbreParPage = 50;
        if (isset($_GET['debut'])&&isset($_GET['end'])) {
            $debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
            $end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
            $nbre = Contact::countBySearchType($debut,$end);
            $nbrePages = ceil($nbre->Total / $nbreParPage);
            if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                $pageCourante = $_GET['page'];
            } else {
                $pageCourante = 1;
                $params['page'] = $pageCourante;
            }
            $suggestions = Contact::searchType($nbreParPage,$pageCourante,$debut,$end);
        } else {
            $nbre = Contact::countBySearchType();
            $nbrePages = ceil($nbre->Total / $nbreParPage);
            if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                $pageCourante = $_GET['page'];
            } else {
                $pageCourante = 1;
                $params['page'] = $pageCourante;
            }
            $suggestions = Contact::searchType($nbreParPage,$pageCourante);
        }
        $this->render('admin.user.suggestions', compact('user','suggestions','nbrePages', 'nbre'));
    }

    public function detailSuggestion(){
        Privilege::hasPrivilege(Privilege::$eshopOtherSugestionView,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id'])&&!empty($_POST['id'])){
            $id = $_POST['id'];
            $suggestion = Contact::find($id);
            if($suggestion){
                $content = '<table class="table table-striped table-bordered m-t-sm">
                                <tbody>
                                <tr><td class="col-md-5">Date</td><td>'.DateParser::DateConviviale($suggestion->created_at,1).'</td></tr>
                                <tr><td class="col-md-5">Auteur</td><td>'.$suggestion->nom.'</td></tr>
                                <tr><td class="col-md-5">Email</td><td>'.StringHelper::isEmpty($suggestion->email,1).'</td></tr>
                                <tr><td class="col-md-5">Numéro</td><td>'.thousand($suggestion->numero).'</td></tr>
                                <tr><td class="col-md-5">Sujet</td><td>'.$suggestion->sujet.'</td></tr>
                                <tr><td class="col-md-5">Message</td><td>'.$suggestion->message.'</td></tr>
                                </tbody>
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