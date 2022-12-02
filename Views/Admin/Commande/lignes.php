<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\Article;
use Projet\Database\products;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\Paginator;
use Projet\Model\StringHelper;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Détail de la commande $commande->order_id");
App::setNavigation("Détail de la commande $commande->order_id");
App::setBreadcumb('<li><a href="javascript:void(0);" onclick="history.go(-1);return false;">Commandes</a></li><li class="active">Détail</li>');
?>
<div class="row">
    <div class="col-md-4">
        <div class="panel info-box panel-dark">
            <div class="panel-body" style="padding: 10px;">
                <div class="info-box-stats">
                    <p style="font-size: 16px">
                        <?= $lignes[0]->fName.' '.$lignes[0]->lName; ?>
                    </p>
                    <span class="info-box-title"><?= $lignes[0]->phoneNumber.' - '.$lignes[0]->provice.', '.$lignes[0]->city; ?></span>
                </div>
                <div class="info-box-icon">
                    <i class="fa fa-user"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel info-box panel-dark">
            <div class="panel-body" style="padding: 10px;">
                <div class="info-box-stats">
                    <p style="font-size: 16px">
                        <?= thousand($commande->paid_amount)." <small>$</small>"; ?>
                    </p>
                    <span class="info-box-title">Montant total de la commande</span>
                </div>
                <div class="info-box-icon">
                    <i class="fa fa-money"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel info-box panel-dark">
            <div class="panel-body" style="padding: 10px;">
                <div class="info-box-stats">
                    <p style="font-size: 16px">
                        <?= "Payé le ".DateParser::DateShort($commande->created_date,1); ?>
                    </p>
                    <span class="info-box-title"><?= $commande->txn_id ?></span>
                </div>
                <div class="info-box-icon">
                    <i class="fa fa-calendar"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <?= "Détail de la commande $commande->order_id <small>(".thousand($nbre->Total).")</small>" ?>
                </h5>
                <div class="panel-control">
                    <a style="font-size: 20px;color: #fff;">
                        <?= $commande->transit_status; ?>
                    </a>
                    <a href="javascript:void(0);" data-toggle="tooltip"class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('commandes/detail?id='.$_GET['id']) ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <div class="table-responsive project-stats">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="" style="width: 15%">Image</th>
                                    <th class="">Produit</th>
                                    <th class="text-right">Prix</th>
                                    <th class="text-right">Quantité</th>
                                    <th class="text-right">Prix payé</th>
                                    <th class="">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($lignes)){
                                    foreach ($lignes as $ligne) {
                                        $produit = products::find($ligne->product_id);
                                        echo
                                            '
                                            <tr>
                                                <td class="text-center"><img src="'.FileHelper::url($produit->image).'" class="img-ld" alt="Img"></td>
                                                <td class="">
                                                    <b>'.ucfirst($produit->productname).'</b> <br> 
                                                    <small class="text-primary"><i class="icon-login"></i> '.$produit->sku.'</small> <br> 
                                                    <small class="text-info"><i class="icon-control-forward"></i> '.$produit->supplier_code.'</small>
                                                </td>
                                                <td class="text-right">$'.thousand($ligne->product_total_price).'</td>
                                                <td class="text-right">'.thousand($ligne->qty).'</td>
                                                <td class="text-right">$'.thousand($ligne->total_paid_price).'</td>
                                                <td class="">'.DateParser::DateShort($ligne->date,1).'</td>
                                            </tr>
                                            ';
                                    }}else{
                                    echo '<tr><td colspan="6" class="text-danger text-center">Aucune ligne de produit...</td></tr>';
                                }
                                ?>
                                </tbody>
                                <?php
                                if(!empty($lignes)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="6">
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