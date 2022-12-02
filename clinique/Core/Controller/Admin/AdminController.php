<?php
/**
 * Created by PhpStorm.
 * Eleve: Poizon
 * Date: 25/07/2015
 * Time: 08:37
 */

namespace Projet\Controller\Admin;

use Projet\Database\User;
use Projet\Model\App;
use Projet\Model\Controller;
use Projet\Model\Router;

class AdminController extends Controller {

    protected $template = 'Templates/admin_layout';
    protected $user;
    public $error = "Soucis lors de l'execution de la requête, recharger et réessayer";
    public $empty = "SVP renseigner correctement tous les champs requis";

    public function __construct(){
        parent::__construct();
        $this->viewPath = 'Views/';
        $auth = App::getDBAuth();
        if($auth->isLogged()){
            $user = User::find($auth->user());
            if($user->etat==1){
                $this->user = $user;
            }else{
                $this->session->delete('dbauth');
                $this->session->write('lastUrlAsked',App::url(Router::getRoute()));
                $this->checker("Votre compte a été désactivé, vous devez consulter l'administrateur",'');
            }
        }else{
            $this->session->write('lastUrlAsked',App::url(Router::getRoute()));
            $this->checker("Vous devez vous connecter pour accéder à cette ressource",'');
        }
    }
    
}