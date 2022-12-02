<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\Article;
use Projet\Database\Categorie;
use Projet\Database\Marchand;
use Projet\Database\Profil;
use Projet\Database\SousCategorie;
use Projet\Database\Worker;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\Paginator;
use Projet\Model\StringHelper;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Les pays");
App::setNavigation("Les pays");
App::setBreadcumb('<li class="active">Pays</li>');
App::addScript('assets/js/pays.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Pays <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" id="ajouterPays" data-original-title="Nouveau pays">
                        <i class="icon-plus text-success fa-2x"></i>
                    </a>
                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('pays') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('pays') ?>" method="get">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="search" <?= (isset($_GET['search'])&&!empty($_GET['search']))?'value="'.$_GET['search'].'"':''; ?> placeholder="Chercher un pays par son nom ..." class="form-control" title=" Chercher un pays par son nom ... ">
                                    </div>
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
                                    <th class="">Intitulé</th>
                                    <th class="">Code Pays</th>
                                    <th class="text-right">Nbre Régions</th>
                                    <th class="text-right">Nbre Clients</th>
                                    <th class="text-right">Nbre Marchands</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!empty($pays)){
                                    foreach ($pays as $pay) {
                                        $nbreRegion = \Projet\Database\Region::countBySearchType(null,$pay->id);
                                        $nbreClient = Profil::countBySearchType(null,null,null,null,null,null, null,null,$pay->id);
                                        $nbreMarchand = Marchand::countBySearchType(null,null,null,null,null,null,$pay->id);
                                        ?>
                                        <tr>
                                            <td class=""><?= ucfirst($pay->intitule); ?></td>
                                            <td class=""><b><?= $pay->code.' <small>('.$pay->nbre.' chiffres)</small>' ?></b></td>
                                            <td class="text-right"><?= thousand($nbreRegion->Total) ?></td>
                                            <td class="text-right"><?= thousand($nbreClient->Total) ?></td>
                                            <td class="text-right"><?= thousand($nbreMarchand->Total) ?></td>
                                            <td class="text-center">

                                                <a href="javascript:void(0);" class="edit text-success"
                                                   data-name="<?= $pay->intitule; ?>"
                                                   data-id="<?= $pay->id; ?>"
                                                   data-code="<?= $pay->code; ?>"
                                                   data-nbre="<?= $pay->nbre; ?>">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>&nbsp
                                                <a href="javascript:void(0);" class="trash text-danger"
                                                   data-url="<?= App::url('pays/delete'); ?>"
                                                   data-id="<?= $pay->id; ?>"><i class="fa fa-trash fa-2x"></i></a>

                                            </td>
                                        </tr>
                                    <?php } } else{ ?>
                                    <tr>
                                        <td colspan="6" class="text-danger text-center">Liste des pays vide</td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <?php
                                if(!empty($pays)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?php $paginator->paginateTwo(); ?>
                                                </div>
                                            </div>
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
<div class="modal fade" id="addPays" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title" id="introPays">Enregistrer une categorie</h2>
            </div>
            <form action="<?= App::url('pays/save') ?>" id="form-Pays" method="post">
                <div class="modal-body">
                    <input type="hidden" id="idPays">
                    <input type="hidden" id="action">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Nom du pays <b>*</b></label>
                                <input type="text" id="namePays" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Code Pays <b>*</b></label>
                                <input type="number" id="code" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nbre de chiffres du numéro sans code <b>*</b></label>
                                <input type="number" id="nbre" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="confirmPays" class="newBtn btn btn-default">AJOUTER</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>