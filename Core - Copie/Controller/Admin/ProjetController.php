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

class ProjetController extends AdminController{


    public function projets(){
        Privilege::hasPrivilege(Privilege::$eshopProjectClientView,$this->user->privilege);
        $user = $this->user;
        $nbreParPage = 50;
        $etat = (isset($_GET['etat'])&&is_numeric($_GET['etat'])) ? $_GET['etat']-1 : null;
        $debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
        $end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
        $nbre = customer_project::countBySearchType(null,null,null,$etat,$debut,$end);
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $projects = customer_project::searchType($nbreParPage,$pageCourante,null,null,null,$etat,$debut,$end);
        $this->render('admin.user.projets',compact('projects','user','nbre','nbrePages'));
    }

    public function projects(){
        Privilege::hasPrivilege(Privilege::$eshopProjectClientView,$this->user->privilege);
        $user = $this->user;
        $nbreParPage = 50;
        $etat = (isset($_GET['etat'])&&is_numeric($_GET['etat'])) ? $_GET['etat']-1 : null;
        $debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
        $end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
        $nbre = affiliate_project::countBySearchType(null,$etat,$debut,$end);
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $projects = affiliate_project::searchType($nbreParPage,$pageCourante,null,$etat,$debut,$end);
        $this->render('admin.user.projects',compact('projects','user','nbre','nbrePages'));
    }

}