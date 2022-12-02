<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 17/07/2015
 * Time: 12:40
 */

namespace Projet\Model;


class Controller {

    protected $viewPath;
    protected $template;
    protected $session;
    public $error = "Soucis lors de l'execution de la requête, recharger et réessayer";
    public $empty = "Veuillez remplir correctement tous les champs requis";
    public $end_mail = "<br><i>Nous vous remercions de votre confiance</i><br><br><b>Toute l'équipe Plumers</b>";
    public $lien_app = "https://play.google.com/store/apps/details?id=net.betterplanning.glomo";
    public $lien_text = "Télécharger l'application mobile";

    public function __construct(){
        $this->session = Session::getInstance();
    }

    public function render($view, $variables=[]){
        ob_start();
        $sess = ['session'=>$this->session];
        $variables = array_merge($sess,$variables);
        extract($variables);
        $page = explode('.',$view);
        require($this->viewPath .ucfirst($page[0]).'/'.ucfirst($page[1]).'/'.$page[2].'.php');
        $content = ob_get_clean();
        require ($this->viewPath . $this->template . '.php');
    }

    public function checker($message,$url){
        if(is_ajax()){
            header('content-type: application/json');
            $return['statuts']=1;
            $return['mes']=$message;
            echo json_encode($return);
            exit();
        }else{
            $this->session->write('danger',$message);
            App::redirect(App::url($url));
        }
    }

}