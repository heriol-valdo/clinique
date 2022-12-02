<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\category;
use Projet\Database\products;
use Projet\Database\subcategory;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\Paginator;
use Projet\Model\Privilege;
use Projet\Model\StringHelper;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Les deals du jour");
App::setNavigation("Les deals du jour");
App::setBreadcumb('<li class="active">Deals du jour</li>');
App::addScript('assets/js/deal.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Deals du jour <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('deals') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('deals') ?>" method="get">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['search'])&&!empty($_GET['search']))?'value="'.$_GET['search'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par titre" name="search" placeholder="Chercher par titre">
                                </div>
                                <div class="col-md-3 form-group">
                                    <select class="form-control" name="etat" data-toggle="tooltip" data-original-title="Chercher par statut">
                                        <option value="">Chercher par statut</option>
                                        <option value="2" <?= (isset($_GET['etat']) && $_GET['etat'] == 2) ? 'selected' : ''; ?>>Activé</option>
                                        <option value="3" <?= (isset($_GET['etat']) && $_GET['etat'] == 3) ? 'selected' : ''; ?>>Expiré</option>
                                        <option value="1" <?= (isset($_GET['etat']) && $_GET['etat'] == 1) ? 'selected' : ''; ?>>Désactivé</option>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['debut'])&&!empty($_GET['debut']))?'value="'.$_GET['debut'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par date min" name="debut" id="debut" placeholder="Chercher par date min">
                                </div>
                                <div class="col-md-3 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['end'])&&!empty($_GET['end']))?'value="'.$_GET['end'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par date max" name="end" id="end" placeholder="Chercher par date max">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-10 col-md-2">
                                    <button class="btn btn-block btn-default" type="submit">Chercher</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <div class="table-responsive project-stats">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width: 15%">Deal Image</th>
                                    <th class="">Produit</th>
                                    <th class="" style="width: 12%">Image produit</th>
                                    <th class="text-center">Prix</th>
                                    <th class="">Titre</th>
                                    <th class="">Durée</th>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Etat</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($deals)){
                                    foreach ($deals as $deal) {
                                        $stat09 = "";
                                        if($deal->status == 0&&Privilege::canView(Privilege::$eshopProductDealActivation,$user->privilege)){
                                            $stat09 = '<li>
                                                            <a href="javascript:void(0);" data-url="'.App::url('produits/setEtat').'" 
                                                            class="activate" data-nom="'.$deal->productname.'" data-etat="'.$deal->status.'" data-id="'.$deal->productid.'">Activer le deal</a>
                                                        </li>';
                                        }
                                        if($deal->status != 0&&Privilege::canView(Privilege::$eshopProductDealDesactivation,$user->privilege)){
                                            $stat09 = '<li>
                                                            <a href="javascript:void(0);" data-url="'.App::url('produits/setEtat').'" 
                                                            class="activate" data-nom="'.$deal->productname.'" data-etat="'.$deal->status.'" data-id="'.$deal->productid.'">Désactiver le deal</a>
                                                        </li>';
                                        }
                                        $product = products::find($deal->product_id);
                                        echo
                                            '
                                            <tr>
                                                <td class="text-center"><img src="'.FileHelper::url($deal->banner).'" class="img-ld1" alt="Img"></td>
                                                <td class=""><b>'.$product->productname.'</b></td>
                                                <td class=""><img src="'.FileHelper::url($product->image).'" class="img-ld" alt="Img"></td>
                                                <td class="text-center">
                                                    <div class="style-1">
                                                      <del>
                                                        <span class="amount">$'.float_value($product->price).'</span>
                                                      </del>
                                                      <ins>
                                                        <span class="amount">$'.float_value($deal->price).'</span>
                                                      </ins>
                                                    </div>
                                                </td>
                                                <td class="">'.$deal->title.'</td>
                                                <td class="">Du <b>'.DateParser::DateShort($deal->starttime,1).'</b> au <b>'.DateParser::DateShort($deal->endtime,1).'</b></td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            Actions <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="javascript:void(0);" class="detail" data-url="'.App::url('deals/detail').'" data-id="'.$deal->id.'">Détail</a>
                                                            </li>
                                                            '.$stat09.'
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td class="text-center">'.StringHelper::$tabDealState[$deal->status].'</td>
                                            </tr>
                                            ';
                                    }}else{
                                    echo '<tr><td colspan="8" class="text-danger text-center">Liste des deals vide ...</td></tr>';
                                }
                                ?>
                                </tbody>
                                <?php
                                if(!empty($deals)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="8">
                                            <?php $paginator->paginateTwo(); ?>
                                        </td>
                                    </tr>
                                    </tfoot>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade messageModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">DETAIL DU DEAL</h2>
            </div>
            <div class="modal-body">
                <div class="loader">
                    <p class="text-center"><img class="img-xs" src="<?= FileHelper::url('assets/images/load.gif') ?>" alt=""></p>
                </div>
                <div class="contenus hide">

                </div>
            </div>
        </div>
    </div>
</div>