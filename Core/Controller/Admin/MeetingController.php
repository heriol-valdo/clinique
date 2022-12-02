<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 23/01/2017
 * Time: 09:19
 */

namespace Projet\Controller\Admin;

use Projet\Database\schedule_meeting;
use Projet\Model\Privilege;

class MeetingController extends AdminController{

    public function index(){
        Privilege::hasPrivilege(Privilege::$eshopMeetingView,$this->user->privilege);
        $user = $this->user;
        $nbreParPage = 20;
        $s_etat = (isset($_GET['etat'])&&!empty($_GET['etat'])) ? $_GET['etat'] : null;
        $s_mode = (isset($_GET['mode'])&&!empty($_GET['mode'])) ? $_GET['mode'] : null;
        $s_debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
        $s_end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
        $nbre = schedule_meeting::countBySearchType(null,null,$s_mode,$s_etat,$s_debut,$s_end);
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $meetings = schedule_meeting::searchType($nbreParPage,$pageCourante,null,null,$s_mode,$s_etat,$s_debut,$s_end);
        $this->render('admin.user.meetings',compact('s_end','s_debut','s_etat','s_mode','meetings','user','nbre','nbrePages'));
    }

}