<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 23/01/2017
 * Time: 09:19
 */

namespace Projet\Controller\Error;


class HomeController extends ErrorController {

    public function error(){
        $this->render('error.home.error');
    }

    public function error_db(){
        $message = isset($_SESSION['error_db'])?$_SESSION['error_db']:'';
        unset($_SESSION['error_db']);
        $this->render('error.home.error_db',compact('message'));
    }

    public function unauthorize(){
        $this->render('error.home.unauthorize');
    }

    public function expired(){
        $this->session->write('danger',"Votre abonnement est déjà expiré, bien vouloir le renouveller en contactant votre administrateur au 671747474 ou abonnement@digitalschool.com");
        $this->render('error.home.expired');
    }

}