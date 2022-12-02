<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 23/01/2017
 * Time: 09:19
 */

namespace Projet\Controller\Admin;


use DateTime;
use Exception;
use Projet\Database\Article;
use Projet\Database\Cat;
use Projet\Database\Categorie;
use Projet\Database\category;
use Projet\Database\checkout_orders;
use Projet\Database\dealoftheday;
use Projet\Database\Evenement;
use Projet\Database\Fabricant;
use Projet\Database\Histo;
use Projet\Database\Historique;
use Projet\Database\Image;
use Projet\Database\Ligne;
use Projet\Database\Fournisseur;
use Projet\Database\Marchand;
use Projet\Database\Marque;
use Projet\Database\product_review;
use Projet\Database\products;
use Projet\Database\productsimage;
use Projet\Database\Solderie;
use Projet\Database\SousCategorie;
use Projet\Database\subcategory;
use Projet\Model\App;
use Projet\Model\DataHelper;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\Privilege;
use Projet\Model\StringHelper;

class DealController extends AdminController{

    public function index(){
        Privilege::hasPrivilege(Privilege::$eshopProductDealView,$this->user->privilege);
        $user = $this->user;
        $nbreParPage = 10;
        $search = (isset($_GET['search'])&&is_numeric($_GET['search'])) ? $_GET['search']-1 : null;
        $etat = (isset($_GET['etat'])&&is_numeric($_GET['etat'])) ? $_GET['etat']-1 : null;
        $debut = (isset($_GET['debut'])&&!empty($_GET['debut'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['debut'])) : null;
        $end = (isset($_GET['end'])&&!empty($_GET['end'])) ? date(MYSQL_DATE_FORMAT, strtotime($_GET['end'])) : null;
        $nbre = dealoftheday::countBySearchType($search,null,$etat,$debut,$end);
        $nbrePages = ceil($nbre->Total / $nbreParPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
            $pageCourante = $_GET['page'];
        } else {
            $pageCourante = 1;
            $params['page'] = $pageCourante;
        }
        $deals = dealoftheday::searchType($nbreParPage,$pageCourante,$search,null,$etat,$debut,$end);
        $this->render('admin.article.deals',compact('deals','user','nbre','nbrePages','categories'));
    }

    public function detail(){
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id'])&&!empty($_POST['id'])){
            $id = $_POST['id'];
            $item = dealoftheday::find($id);
            if($item){
                $product = products::find($item->product_id);
                $tr = !empty($item->banner) ? '<tr><td colspan="2"><div class="col-md-12" style="margin-bottom: 10px">
                                <img src="'.FileHelper::url($item->banner).'" style="width: 100%;">
                                </div></td></tr>' : '';
                $content = '<table class="table table-striped table-bordered m-t-sm">
                                <tbody>
                                <tr><td class="col-md-5">Produit</td><td>'.$product->productname.'</td></tr>
                                <tr><td class="col-md-5">Image produit</td><td><img src="'.FileHelper::url($product->image).'" style="max-width: 100%;height: 90px"></td></tr>
                                <tr><td class="col-md-5">Start</td><td>'.DateParser::DateShort($item->starttime,1).'</td></tr>
                                <tr><td class="col-md-5">End</td><td>'.DateParser::DateShort($item->endtime,1).'</td></tr>
                                <tr><td class="col-md-5">Prix</td><td><div class="style-1">
                                                      <del>
                                                        <span class="amount">$'.float_value($product->price).'</span>
                                                      </del>
                                                      <ins>
                                                        <span class="amount">$'.float_value($item->price).'</span>
                                                      </ins>
                                                    </div></td>
                                </tr>
                                <tr><td class="col-md-5">Deal Title</td><td>'.$item->title.'</td></tr>
                                <tr><td class="col-md-5">Description</td><td>'.$item->description.'</td></tr>
                                <tr><td class="col-md-5">Ajouté le</td><td>'.DateParser::DateShort($item->date,1).'</td></tr>
                                '.$tr.'</tbody>
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

    public function setEtat(){
        Privilege::hasPrivilege(Privilege::$eshopProductDealActivation,$this->user->privilege);
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])&&isset($_POST['etat'])  && in_array($_POST['etat'],[1,0])){
            $id = $_POST['id'];
            $etat = $_POST['etat'];
            $article = dealoftheday::find($id);
            if($article){
                $pdo = App::getDb()->getPDO();
                try{
                    $pdo->beginTransaction();
                    dealoftheday::setEtat($etat,$id);
                    $message = "L'opération s'est effectuée avec succès";
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

}