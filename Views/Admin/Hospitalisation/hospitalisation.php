<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 03/09/2020
 * Time: 13:47
 */


use Projet\Database\patient;
use Projet\Database\Salle;
use Projet\Model\App;
use Projet\Model\Paginator;
use Projet\Model\StringHelper;


$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Les Hospitalisations");
App::setNavigation("Les Hospitalisations");
App::setBreadcumb('<li class="active">Hospitalisations</li>');
App::addScript('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css',true);
App::addScript('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js',true);
App::addScript('assets/js/hospitalisation.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Hospitalisations <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" id="add" data-original-title="Nouvelle Hospitalisation">
                        <i class="icon-plus text-success fa-2x"></i>
                    </a>
                    <a target="_blank" href="<?= App::url('hospitalisations/pdf?search='.$search) ?>"
                       data-toggle="tooltip" data-original-title="Generer le fichier PDF des Hospitalisations" ><i class="fa fa-file-pdf-o fa-2x text-primary"></i></a>
                    <a target="_blank" href="<?= App::url('hospitalisations/excell?search='.$search) ?>"
                       data-toggle="tooltip" data-original-title="Generer le fichier Excel des Hospitalisations" ><i class="fa fa-file-excel-o fa-2x text-info"></i></a>

                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('hospitalisations') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('hospitalisations') ?>" method="get">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="idsalle" <?= (isset($_GET['idsalle'])&&!empty($_GET['idsalle']))?'value="'.$_GET['idsalle'].'"':''; ?> placeholder="Chercher par  salle ..." class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="search" <?= (isset($_GET['idpatient'])&&!empty($_GET['idpatient']))?'value="'.$_GET['idpatient'].'"':''; ?> placeholder="Chercher par  patient ..." class="form-control" >
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
                                    <th class="">Salle</th>
                                    <th class="">Patient</th>
                                    <th class="text-center">Date d'entré</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody id="table-Villes">
                                <?php
                                if (!empty($items)){
                                    foreach ($items as $item) {
                                        $salle = Salle::find($item->idsalle);
                                        $patient = patient::find($item->idpatient);
                                        ?>
                                        <tr>
                                            <td class=""><?= StringHelper::isEmpty($salle->nom ); ?></td>
                                            <td class=""><?= StringHelper::isEmpty($patient->nom ); ?></td>
                                            <td class=""><?= StringHelper::isEmpty($item->date_in ); ?></td>
                                        <td class="text-center">
                                                <a href="javascript:void(0);" class="edit text-success"
                                                   data-id="<?= $item->id; ?>"
                                                   data-idsalle="<?= $item->idsalle; ?>"
                                                   data-idpatient="<?= $item->idpatient; ?>"
                                                   data-date_in="<?= $item->date_in; ?>">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>&nbsp
                                                <a href="javascript:void(0);" class="trash text-danger"
                                                   data-url="<?= App::url('hospitalisation/delete'); ?>"
                                                   data-id="<?= $item->id; ?>"><i class="fa fa-trash fa-2x"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } } else{ ?>
                                    <tr>
                                        <td colspan="4" class="text-danger text-center">Liste des Hospitalisations vide</td>
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

<div class=" modal fade newModal" id="newModal" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
    <div class="modal-dialog" style="width: 60%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="pci-cross pci-circle"></i></span></button>
                <h2 class="modal-title titleForm">Titre</h2>
            </div>
            <form action="<?= App::url('hospitalisation/save') ?>" id="newFrom" method="post">
                <div class="modal-body">
                    <input type="hidden" id="idElement">
                    <input type="hidden" id="action">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="idpatient">Nom du Patient<b>*</b></label>
                            <select name="idpatient" id="idpatient"  class="form-control" data-placeholder="Selectionnez le Patient">
                                <option value="">...</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Salle <b>*</b></label>
                                <input type="text" id="idsalle" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Date d'entre <b>*</b></label>
                                <input type="text" id="date_in" class="form-control" required>
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