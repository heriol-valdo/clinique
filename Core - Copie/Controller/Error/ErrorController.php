<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 17/07/2015
 * Time: 13:14
 */

namespace Projet\Controller\Error;

use Projet\Model\ExceptionController;

class ErrorController extends ExceptionController {

    protected $template = 'Templates/error';

    public function __construct(){
        parent::__construct();
        $this->viewPath = 'Views/';
    }

}