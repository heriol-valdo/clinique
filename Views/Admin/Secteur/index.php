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
App::setTitle("Les secteurs d'activité");
App::setNavigation("Les secteurs d'activité");
App::setBreadcumb('<li class="active">Secteurs d\'activité</li>');
App::addScript('assets/js/secteur.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Secteurs d'activité <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" id="ajouterPays" data-original-title="Nouveau secteur d'activité">
                        <i class="icon-plus text-success fa-2x"></i>
                    </a>
                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('secteurs') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('secteurs') ?>" method="get">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="search" <?= (isset($_GET['search'])&&!empty($_GET['search']))?'value="'.$_GET['search'].'"':''; ?> placeholder="Chercher un secteur d'activité par son nom ..." class="form-control" title=" Chercher un secteur d'activité par son nom ... ">
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
                                    <th class="">Description</th>
                                    <th class="text-right">Nbre Clients</th>
                                    <th class="text-right">Nbre Marchands</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!empty($secteurs)){
                                    foreach ($secteurs as $secteur) {
                                        $nbreClient = Profil::countBySearchType(null,null,null,null,null,null,null,null,null,null,$secteur->id);
                                        $nbreMarchand = Marchand::countBySearchType(null,null,null,null,null,null,null,null,$secteur->id);
                                        ?>
                                        <tr>
                                            <td class=""><?= ucfirst($secteur->intitule); ?></td>
                                            <td class=""><?= StringHelper::abbreviate(StringHelper::isEmpty($secteur->description),50) ?></td>
                                            <td class="text-right"><?= thousand($nbreClient->Total) ?></td>
                                            <td class="text-right"><?= thousand($nbreMarchand->Total) ?></td>
                                            <td class="text-center">

                                                <a href="javascript:void(0);" class="edit text-success"
                                                   data-name="<?= $secteur->intitule; ?>"
                                                   data-id="<?= $secteur->id; ?>"
                                                   data-description="<?= $secteur->description; ?>">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>&nbsp
                                                <a href="javascript:void(0);" class="trash text-danger"
                                                   data-url="<?= App::url('secteurs/delete'); ?>"
                                                   data-id="<?= $secteur->id; ?>"><i class="fa fa-trash fa-2x"></i></a>

                                            </td>
                                        </tr>
                                    <?php } } else{ ?>
                                    <tr>
                                        <td colspan="5" class="text-danger text-center">Liste des secteurs d'activité vide</td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <?php
                                if(!empty($secteurs)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="5">
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
            <form action="<?= App::url('secteurs/save') ?>" id="form-Pays" method="post">
                <div class="modal-body">
                    <input type="hidden" id="idPays">
                    <input type="hidden" id="action">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Intitulé <b>*</b></label>
                                <input type="text" id="namePays" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <textarea class="form-control" id="description" rows="1"></textarea>
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