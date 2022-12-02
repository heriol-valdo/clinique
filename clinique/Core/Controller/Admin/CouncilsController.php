<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 26/05/2020
 * Time: 04:50
 */

namespace Projet\Controller\Admin;


use Exception;
use Projet\Database\comment;
use Projet\Database\council;
use Projet\Database\users;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\Privilege;
use Projet\Model\StringHelper;

class CouncilsController extends AdminController
{
    public function index()
    {
       Privilege::hasPrivilege(Privilege::$eshopCouncilView, $this->user->privilege);
        $user = $this->user;
        $nbreParPage = 20;
        $status = (isset($_GET['status']) && !empty($_GET['status'])) ? $_GET['status'] : null;
        $debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
        $end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
        $nbre = council::countBySearchType(null,$status,$debut,$end);
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $councils = council::searchType($nbreParPage, $pageCourante,null,$status,$debut,$end);
        $this->render('admin.user.council', compact('user', 'councils', 'nbre', 'nbrePages'));
    }

    public function delete(){
        Privilege::hasPrivilege(Privilege::$eshopCouncilDelete, $this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $id = $_POST['id'];
            $council = council::find($id);
            if ($council) {
                $pdo = App::getDb()->getPDO();
                try {
                    $pdo->beginTransaction();
                    council::delete($id);
                    $message = "Le council a été supprimé avec succès";
                    $this->session->write('success', $message);
                    $pdo->commit();
                    $return = array("statuts" => 0, "mes" => $message);
                } catch (Exception $e) {
                    $pdo->rollBack();
                    $message = $this->error;
                    $return = $message;
                }
            } else {
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        } else {
            $message = $this->empty;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function activate(){
        Privilege::hasPrivilege(Privilege::$eshopCouncilActive,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])&&isset($_POST['status']) && in_array($_POST['status'],[0,1])){
            $id = $_POST['id'];
            $status = $_POST['status'];
            $council = council::find($id);
            if($council){
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    council::setEtat($status,$id);
                    $message = "L'opération s'est passée avec succès";
                    $this->session->write('success',$message);
                    $pdo->commit();
                    $return = array("statuts" => 0, "mes" => $message);
                }catch (Exception $e){
                    $pdo->rollBack();
                    $message = $this->error;
                    $return = array("statuts" => 1, "mes" => $message);
                }
            }else{
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = $this->error;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function detail() {
        header('content-type: application/json');
        $return = [];
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $id = $_POST['id'];
            $council = council::find($id);
            if ($council) {
                $users = users::find($council->userid);
                $content = '<table class="table table-striped table-bordered m-t-sm">
                                <tbody>
                                       <tr><td class="col-md-2">Client</td><td class="">' .$users->username . '</td></tr>
                                       <tr><td class="col-md-2">Titre</td><td class="">' .$council->title . '</td></tr>
                                       <tr><td class="col-md-2">Media</td><td class="">' . $council->media_type . '</td></tr>
                                       <tr><td class="col-md-2">Etat</td><td class="">' . StringHelper::$tabState[$council->status] . '</td></tr>
                                       <tr><td class="col-md-2">Date</td><td class="">' . $council->created_on . '</td></tr>
                                       <tr><td colspan="2"><img src="'.FileHelper::url($council->image). '" style="max-width: 100%" alt="Img"></tr>
                                </tbody>
                            </table>';
                $return = array("statuts" => 0, "contenu" => $content);
            } else {
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        } else {
            $message = $this->error;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function commentaires() {
        header('content-type: application/json');
        $return = [];
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $id = $_POST['id'];
            $council = council::find($id);
            if ($council) {
                $content = '<table class="table table-striped table-hover m-t-sm">
                                <thead><tr><th>Photo</th><th>Auteur</th><th>Message</th><th>Date</th></tr></thead><tbody>
                            ';
                $commentaires = comment::searchType(null,null,$council->id);
                foreach ($commentaires as $commentaire) {
                    $user = users::find($commentaire->userid);
                    $content .=
                        '
                        <tr>
                            <td><img src="'.FileHelper::url($user->profileimg).'" class="img-circle img-sd" alt="Img"></td>
                            <td class="">'.$user->username.'</td>
                            <td class="">'.$commentaire->comments.'</td>
                            <td class="">'.DateParser::DateShort($commentaire->created_on,1).'</td>
                        </tr>
                        ';
                }
                $content .= '</tbody></table>';
                $return = array("statuts" => 0, "contenu" => $content);
            } else {
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        } else {
            $message = $this->error;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }


}
