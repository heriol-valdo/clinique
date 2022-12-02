<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 18/05/2020
 * Time: 04:35
 */

namespace Projet\Controller\Admin;


use Exception;
use DateTime;
use Projet\Database\coupons;
use Projet\Model\App;
use Projet\Model\Privilege;

class CouponsController extends AdminController
{
    public function index(){
        Privilege::hasPrivilege(Privilege::$eshopConfigCouponView,$this->user->privilege);
        $user = $this->user;
        $nbreParPage = 20;
        $coupon_code = (isset($_GET['coupon_code'])&&!empty($_GET['coupon_code'])) ? $_GET['coupon_code'] : null;
        $nbre = coupons::countBySearchType($coupon_code);
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $coupons = coupons::searchType($nbreParPage,$pageCourante,$coupon_code);
        $this->render('admin.user.coupon',compact('user','coupons','nbre','nbrePages'));
    }

    public function save(){
        Privilege::hasPrivilege(Privilege::$eshopConfigCouponAdd,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        $tab = ["add", "edit"];
        if (isset($_POST['coupon_code']) && !empty($_POST['coupon_code']) &&isset($_POST['description']) && !empty($_POST['description'])
            &&isset($_POST['discount']) && !empty($_POST['discount']) &&isset($_POST['start_date']) && !empty($_POST['start_date'])
            &&isset($_POST['end_date']) && !empty($_POST['end_date']) && isset($_POST['action']) && !empty($_POST['action'])
            && isset($_POST['id']) && in_array($_POST["action"], $tab)) {
            $coupon_code = $_POST['coupon_code'];
            $description = $_POST['description'];
            $discount = (float)$_POST['discount'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $action = $_POST['action'];
            $id = (int)$_POST['id'];
            if ( $start_date < $end_date ){
                if ( $discount > 0  &&  $discount < 100){
                        if($action == "edit") {
                            if (!empty($id)){
                                $coupons = coupons::find($id);
                                if ($coupons) {
                                    $pdo = App::getDb()->getPDO();
                                    try{
                                        $pdo->beginTransaction();
                                        $start_date = new DateTime($start_date);
                                        $end_date = new DateTime($end_date );
                                        coupons::save( $coupon_code,$description,$discount,$start_date->format(MYSQL_DATE_FORMAT),$end_date->format(MYSQL_DATE_FORMAT),$id);
                                        $message = "Le coupon a été mise à jour avec succès";
                                        $this->session->write('success',$message);
                                        $pdo->commit();
                                        $return = array("statuts" => 0, "mes" => $message);
                                    }catch (Exception $e){
                                        $pdo->rollBack();
                                        $message = $this->error;
                                        $return = array("statuts" => 1, "mes" => $message);
                                    }
                                } else {
                                    $message = $this->error;
                                    $return = array("statuts" => 1, "mes" => $message);
                                }
                            } else {
                                $message = $this->error;
                                $return = array("statuts" => 1, "mes" => $message);
                            }
                        } else {
                            $code=coupons::byCode($coupon_code);
                            if(!($code)){
                                $pdo = App::getDb()->getPDO();
                                try{
                                    $pdo->beginTransaction();
                                    $start_date = new DateTime($start_date);
                                    $end_date = new DateTime($end_date );
                                    coupons::save( $coupon_code,$description,$discount,$start_date->format(MYSQL_DATE_FORMAT),$end_date->format(MYSQL_DATE_FORMAT));
                                    $message = "Le coupon a été ajoutée avec succès";
                                    $this->session->write('success',$message);
                                    $pdo->commit();
                                    $return = array("statuts" => 0, "mes" => $message);
                                }catch (Exception $e){
                                    $pdo->rollBack();
                                    $message = $this->error;
                                    $return = array("statuts" => 1, "mes" => $message);
                                }
                            }else {

                                $message = "Le code coupons existe déja veiullez utiliser un autre code ";
                                $return = array("statuts" => 1, "mes" => $message);
                            }
                        }

                }else {

                    $message = "La rémise doit etre un réel positif de l'interval ]0;100[";
                    $return = array("statuts" => 1, "mes" => $message);
                }
        }else {

                $message = "La date de debut doit etre inferieur à date de fin";
                $return = array("statuts" => 1, "mes" => $message);
             }
         } else {
            $message = "Veiullez renseigner tous les champs requis";
            $return = array("statuts" => 1, "mes" => $message);
         }


        echo json_encode($return);
    }

    public function delete(){
        Privilege::hasPrivilege(Privilege::$eshopConfigCouponDelete,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $id = $_POST['id'];
            $coupon = coupons::find($id);
            if($coupon){
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    coupons::delete($id);
                    $message = "Le Coupons a été supprimée avec succès";
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
            $message = $this->empty;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function detail(){
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id'])&&!empty($_POST['id'])){
            $id = $_POST['id'];
            $coupons = coupons::find($id);
            if($coupons){
                $content = '<table class="table table-striped table-bordered m-t-sm">
                                <tbody>
                                       <tr><td class="col-md-2">Coupon code</td><td class="">'.$coupons->coupon_code.'</td></tr>
                                       <tr><td class="col-md-2">Discount</td><td class="">'.$coupons->discount.'</td></tr>
                                       <tr><td class="col-md-2">Description</td><td class="">'.$coupons->description.'</td></tr>
                                       <tr><td class="col-md-2">Start date</td><td class="">'.$coupons->start_date.'</td></tr>
                                       <tr><td class="col-md-2">End date</td><td class="">'.$coupons->end_date.'</td></tr>
                                </tbody>
                            </table>';
                $return = array("statuts" => 0, "contenu" => $content);
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
}