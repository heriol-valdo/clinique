<?php
/**
 * Created by PhpStorm.
 * User: HERIOL VALDO
 * Date: 07/09/2020
 * Time: 14:55
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

class MedicamentController  extends AdminController
{

    public function index()
    {
        Privilege::hasPrivilege(Privilege::$eshopProductView, $this->user->privilege);
        $user = $this->user;
        $nbreParPage = 10;
        $categories = category::searchType();
        $sousCat = subcategory::searchType();
        $s_search = (isset($_GET['search']) && !empty($_GET['search'])) ? $_GET['search'] : null;
        $s_cat = (isset($_GET['cat']) && !empty($_GET['cat'])) ? $_GET['cat'] : null;
        $s_categorie = (isset($_GET['categorie']) && !empty($_GET['categorie'])) ? $_GET['categorie'] : null;
        $s_etat = (isset($_GET['etat']) && is_numeric($_GET['etat'])) ? $_GET['etat'] - 1 : null;
        $s_stock = (isset($_GET['stock']) && !empty($_GET['stock'])) ? $_GET['stock'] : null;
        $s_type = (isset($_GET['type']) && !empty($_GET['type'])) ? $_GET['type'] : null;
        $nbre = products::countBySearchType($s_search, $s_cat, $s_categorie, $s_type, $s_stock, $s_etat);
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $articles = products::searchType($nbreParPage, $pageCourante, $s_search, $s_cat, $s_categorie, $s_type, $s_stock, $s_etat);
        $this->render('admin.article.index', compact('s_stock', 's_search', 's_etat', 's_type', 's_cat', 's_categorie', 'sousCat', 'articles', 'user', 'nbre', 'nbrePages', 'categories'));
    }

}