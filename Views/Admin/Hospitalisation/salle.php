<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 03/09/2020
 * Time: 13:47
 */


use Projet\Model\App;
use Projet\Model\Paginator;
use Projet\Model\StringHelper;


$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Les salles");
App::setNavigation("Les salles");
App::setBreadcumb('<li class="active">Salles</li>');
App::addScript('assets/js/salle.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Salles <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" id="add" data-original-title="Nouvelle Salles">
                        <i class="icon-plus text-success fa-2x"></i>
                    </a>
                    <a target="_blank" href="<?= App::url('salle/pdf?search='.$search) ?>"
                       data-toggle="tooltip" data-original-title="Generer le fichier PDF des salles" ><i class="fa fa-file-pdf-o fa-2x text-primary"></i></a>
                    <a target="_blank" href="<?= App::url('salle/excell?search='.$search) ?>"
                       data-toggle="tooltip" data-original-title="Generer le fichier Excel des salles" ><i class="fa fa-file-excel-o fa-2x text-info"></i></a>

                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('salles') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                     </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('salles') ?>" method="get">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="search" <?= (isset($_GET['search'])&&!empty($_GET['search']))?'value="'.$_GET['search'].'"':''; ?> placeholder="Chercher par  nom ou prix ..." class="form-control" title="Chercher par le nom ou prix">
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
                                <thead class="noBackground">
                                <tr>
                                    <th class="">Intitulé</th>
                                    <th class="text-right">Prix</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody id="table-Villes">
                                <?php
                                if (!empty($items)){
                                    foreach ($items as $item) {
                                        ?>
                                        <tr>
                                            <td class=""><?= StringHelper::isEmpty($item->nom); ?></td>
                                            <td class="text-right"><?= thousand($item->prix); ?></td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" class="edit text-success"
                                                   data-nom="<?= $item->nom; ?>"
                                                   data-id="<?= $item->id; ?>"
                                                   data-prix="<?= $item->prix; ?>">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>&nbsp
                                                <a href="javascript:void(0);" class="trash text-danger"
                                                   data-url="<?= App::url('salle/delete'); ?>"
                                                   data-id="<?= $item->id; ?>"><i class="fa fa-trash fa-2x"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } } else{ ?>
                                    <tr>
                                        <td colspan="4" class="text-danger text-center">Liste des salles vide</td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <?php
                                if(!empty($items)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="4">
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
<div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title" id="intro">Enregistrer une Salle</h2>
            </div>
            <form action="<?= App::url('salle/save') ?>" id="newFrom" method="post">
                <div class="modal-body">
                    <input type="hidden" id="idElement">
                    <input type="hidden" id="action">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Intitulé <b>*</b></label>
                                <input type="text" id="nom" class="form-control" required>
                            </div>
                        </div><div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Prix <b>*</b></label>
                                <input type="text" id="prix" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="confirm" class="newBtn btn btn-default">AJOUTER</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>

