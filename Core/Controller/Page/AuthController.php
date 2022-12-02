<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 23/01/2017
 * Time: 09:21
 */

namespace Projet\Controller\Page;


use DateTime;
use Exception;
use Projet\Database\Card;
use Projet\Database\Carte;
use Projet\Database\Customer;
use Projet\Database\Historique_Carte;
use Projet\Database\Marchand;
use Projet\Database\Merchant;
use Projet\Database\Notification;
use Projet\Database\Preference;
use Projet\Database\Profil;
use Projet\Database\Verification;
use Projet\Model\App;
use Projet\Model\Sms;
use Projet\Model\StringHelper;

class AuthController extends PageController{

    public function middleware(){
        if(App::getDBAuth()->isLogged()){
            App::redirect(App::url("home"));
            $this->session->write("danger","Cette page est indisponible en mode connection");
        }
    }

    public function login(){
        $this->middleware();
        $this->render('page.home.login');
    }

    public function loginAction(){

    }

}