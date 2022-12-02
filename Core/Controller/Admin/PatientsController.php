<?php
/**
 * Created by PhpStorm.
 * User: HERIOL VALDO
 * Date: 08/09/2020
 * Time: 23:20
 */


namespace Projet\Controller\Admin;

use Exception;
use Projet\Database\affiliate_off_days;
use Projet\Database\affiliate_portfolio_profile;
use Projet\Database\affiliate_project;
use Projet\Database\affiliate_user;
use Projet\Database\Commande;
use Projet\Database\council;
use Projet\Database\customer_project;
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

class PatientsController   extends AdminController {

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
        $this->render('admin.patients.index',compact('s_search','s_etat','s_sexe','s_role','s_debut','s_end','profils','user','nbre','nbrePages'));
    }

}