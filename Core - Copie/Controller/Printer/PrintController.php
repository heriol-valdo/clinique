<?php
/**
 * Created by PhpStorm.
 * Eleve: Poizon
 * Date: 25/07/2015
 * Time: 08:37
 */

namespace Projet\Controller\Printer;

use Projet\Database\Enseignant;
use Projet\Model\App;
use Projet\Model\Controller;

class PrintController extends Controller {

    protected $template = 'Templates/printer';
    protected $user;

    public function __construct(){
        parent::__construct();
        $this->viewPath = 'Views/';
        $auth = App::getDBAuth();
        if($auth->isLogged()){
            $user = Enseignant::find($auth->user());
            $this->user = $user;
        }else{
            App::interdit();
        }
    }
    
}