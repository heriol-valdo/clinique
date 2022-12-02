<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 17/07/2015
 * Time: 13:14
 */

namespace Projet\Controller\Page;

use Projet\Database\Visite;
use Projet\Model\App;
use Projet\Model\Controller;
use Projet\Model\Encrypt;

class PageController extends Controller {

    protected $template = 'Templates/default';

    public function __construct(){
        parent::__construct();
        //$this->check();
        $this->viewPath = 'Views/';
    }

    public function check(){
        if(App::getDBAuth()->isLogged()){
            App::redirect(App::url('home'));
        }
    }

    public function addVisite(){
        $ip = $_SERVER['REMOTE_ADDR'];
        if(isset($_GET['p'])){
            $p = Encrypt::decrypter(($_GET['p']));
        }else{
            $p = 'page.home.index';
        }
        $page = explode('.', $p);
        $exist = Visite::exist($ip,date(MYSQL_DATE_FORMAT));
        if(!$exist){
            $data = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip={$ip}"));
            $locate = '('.$data->geoplugin_latitude.' , '.$data->geoplugin_longitude.')';
            $region = $data->geoplugin_region.', '.$data->geoplugin_city;
            if ($page[0] == 'ajax' && $page[2] == 'android'){
                Visite::save($ip,$locate,DATE_COURANTE,$data->geoplugin_countryName,$region,"Mobile");
            }else{
                Visite::save($ip,$locate,DATE_COURANTE,$data->geoplugin_countryName,$region,"Web");
            }
        }
    }

}