<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 27/02/2017
 * Time: 14:08
 */

namespace Projet\Model;

class PdfHelper{

    public static function render($path,$variables = []){
        ob_start();
        extract($variables);
        require($path);
        $html = ob_get_contents();
        ob_get_clean();
        return $html;
    }

}