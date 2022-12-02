<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 17/07/2015
 * Time: 12:40
 */

namespace Projet\Model;


use Projet\Database\Enseignant;
use Projet\Database\Setting;

class ExceptionController {

    protected $viewPath;
    protected $template;
    protected $translator;
    protected $session;

    public function __construct(){
        $this->translator = new Translator();
        $this->session = Session::getInstance();
    }

    public function render($view, $variables=[]){
        ob_start();
        $help = ['translator'=>$this->translator];
        $sess = ['session'=>$this->session];
        $variables = array_merge($help,$sess,$variables);
        extract($variables);
        $page = explode('.',$view);
        require($this->viewPath .ucfirst($page[0]).'/'.ucfirst($page[1]).'/'.$page[2].'.php');
        $content = ob_get_clean();
        require ($this->viewPath . $this->template . '.php');
    }

}