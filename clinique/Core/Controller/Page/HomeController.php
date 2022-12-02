<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 23/01/2017
 * Time: 09:19
 */

namespace Projet\Controller\Page;


use Exception;
use Projet\Database\Card;
use Projet\Database\Carte;
use Projet\Database\Customer;
use Projet\Database\Historique_Carte;
use Projet\Database\Marchand;
use Projet\Database\Merchant;
use Projet\Database\Profil;
use Projet\Model\App;
use Projet\Model\StringHelper;

class HomeController extends PageController{
    
    public function index(){
        $this->check();
        $this->render('page.home.index');
    }

    public function error(){
        $this->session->write('danger',"You are requesting a resource that does not exist");
        $this->render('page.home.error');
    }

    public function unauthorize(){
        $this->session->write('danger',"You do not have permission to access this resource");
        $this->render('page.home.unauthorize');
    }

    public function logout(){
        if(App::getDBAuth()->signOut()){
            App::redirect(App::url(""));
        }
    }

    public function log(){
        $return = [];
        header('content-type: application/json');
        if(isset($_POST['login']) && isset($_POST['password'])){
            $login = $_POST['login'];
            $password = $_POST['password'];
            if(!empty($login)&&!empty($password)){
                $conMessage = App::getDBAuth()->login($login,$password);
                if(is_bool($conMessage)){
                    $lastUrl = empty($this->session->read('lastUrlAsked'))?App::url('home'):$this->session->read('lastUrlAsked');
                    $this->session->delete('lastUrlAsked');
                    $return = array("statuts" => 0, "direct"=>$lastUrl);
                }else{
                    $return = array("statuts" => 1, "mes" => $conMessage);
                }
            }else{
                $message = "Please tape all required fields";
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = $this->error;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

}