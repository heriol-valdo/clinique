<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\Classe;
use Projet\Database\Classe_Eleve;
use Projet\Database\Cours;
use Projet\Database\Enseignant;
use Projet\Database\Paiement;
use Projet\Database\Scolarite;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\Encrypt;
use Projet\Model\FileHelper;
use Projet\Model\Paginator;
use Projet\Model\Privilege;
use Projet\Model\StringHelper;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Ventes de $article->productname");
App::setNavigation("Ventes de $article->productname");
App::setBreadcumb('<li><a href="javascript:void(0);" onclick="history.go(-1);return false;">Produits</a></li><li class="active">Ventes</li>');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <?= "Ventes de $article->productname <small>(".thousand($nbre->Total).")</small>" ?>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip"class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('produits/commandes?id='.$_GET['id']) ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                    <?php if(Privilege::canView(Privilege::$eshopProductSaleEtat,$user->privilege)){ ?>
                        <a target="_blank" href="<?= App::url('produits/commandes/pdf?id='.$_GET['id'].'&etat='.$etat.'&debut='.$debut.'&end='.$end) ?>"
                           data-toggle="tooltip" data-original-title="Generer le fichier PDF des commandes" ><i class="fa fa-file-pdf-o fa-2x text-primary"></i></a>
                        <a target="_blank" href="<?= App::url('produits/commandes/excell?id='.$_GET['id'].'&etat='.$etat.'&debut='.$debut.'&end='.$end) ?>"
                           data-toggle="tooltip" data-original-title="Generer le fichier Excel des commandes" ><i class="fa fa-file-excel-o fa-2x text-info"></i></a>
                    <?php } ?>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('produits/commandes') ?>" method="get">
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <select class="form-control" name="etat" data-toggle="tooltip" data-original-title="Chercher par statut">
                                        <option value="">Chercher par statut</option>
                                        <option value="succeeded" <?= (isset($_GET['etat']) && $_GET['etat'] == 'succeeded') ? 'selected' : ''; ?>>Succeeded</option>
                                        <option value="Pending" <?= (isset($_GET['etat']) && $_GET['etat'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['debut'])&&!empty($_GET['debut']))?'value="'.$_GET['debut'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par date min" name="debut" id="debut" placeholder="Chercher par date min">
                                </div>
                                <div class="col-md-4 form-group">
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
                                    <th class="">Ref</th>
                                    <th class="">Client</th>
                                    <th class="">Adresse</th>
                                    <th class="text-right">Prix produit</th>
                                    <th class="text-right">Quantité</th>
                                    <th class="text-right">Prix payé</th>
                                    <th class="">Status</th>
                                    <th class="">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($lignes)){
                                    foreach ($lignes as $ligne) {
                                        echo
                                            '
                                            <tr>
                                                <td class="">'.$ligne->order_id.'</td>
                                                <td class="">'.$ligne->fName.' '.$ligne->lName.'</td>
                                                <td class="">'.$ligne->phoneNumber.', '.$ligne->provice.', '.$ligne->city.'</td>
                                                <td class="text-right">$'.thousand($ligne->product_total_price).'</td>
                                                <td class="text-right">'.thousand($ligne->qty).'</td>
                                                <td class="text-right">$'.thousand($ligne->total_paid_price).'</td>
                                                <td>'.StringHelper::$tabCommandeState[$ligne->status].'</td>
                                                <td class="">'.DateParser::DateShort($ligne->date,1).'</td>
                                            </tr>
                                            ';
                                    }}else{
                                    echo '<tr><td colspan="8" class="text-danger text-center">Aucune commande pour ce produit...</td></tr>';
                                }
                                ?>
                                </tbody>
                                <?php
                                if(!empty($lignes)){ ?>
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