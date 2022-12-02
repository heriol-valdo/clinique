<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\Article;
use Projet\Database\Marchand;
use Projet\Database\Profil;
use Projet\Database\SousCategorie;
use Projet\Database\Worker;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\Paginator;
use Projet\Model\Privilege;
use Projet\Model\StringHelper;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Les régions");
App::setNavigation("Les régions");
App::setBreadcumb('<li class="active">Régions</li>');
App::addScript('assets/js/region.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Régions <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" id="ajouterVille" data-original-title="Nouvelle Région">
                        <i class="icon-plus text-success fa-2x"></i>
                    </a>
                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('regions') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('regions') ?>" method="get">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <select class="form-control" name="pays" data-toggle="tooltip" data-original-title="Chercher par le pays">
                                        <option value="">Chercher par le pays</option>
                                        <?php
                                        foreach ($pays as $pay){
                                            $is = isset($_GET['pays'])&&$_GET['pays']==$pay->id?' selected':'';
                                            echo '<option value="'.$pay->id.'"'.$is.'>'.$pay->intitule.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="search" <?= (isset($_GET['search'])&&!empty($_GET['search']))?'value="'.$_GET['search'].'"':''; ?> placeholder="Chercher par le nom de la région ..." class="form-control" title="Chercher par le nom de la région">
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
                                    <th class="">Pays</th>
                                    <th class="">Région</th>
                                    <th class="text-right">Nbre Clients</th>
                                    <th class="text-right">Nbre Marchands</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody id="table-Villes">
                                <?php
                                if (!empty($regions)){
                                    foreach ($regions as $region) {
                                        $nbreClient = Profil::countBySearchType(null,null,null,null,null,null, null,null,null,$region->id);
                                        $nbreMarchand = Marchand::countBySearchType(null,null,null,null,null,null,null,$region->id);
                                        ?>
                                        <tr>
                                            <td class=""><?= ucfirst($region->libPays); ?></td>
                                            <td class=""><?= ucfirst($region->intitule); ?></td>
                                            <td class="text-right"><?= thousand($nbreClient->Total); ?></td>
                                            <td class="text-right"><?= thousand($nbreMarchand->Total); ?></td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" class="edit text-success"
                                                   data-name="<?= $region->intitule; ?>"
                                                   data-id="<?= $region->id; ?>"
                                                   data-pays="<?= $region->idPays; ?>">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>&nbsp
                                                <a href="javascript:void(0);" class="trash text-danger"
                                                   data-url="<?= App::url('regions/delete'); ?>"
                                                   data-id="<?= $region->id; ?>"><i class="fa fa-trash fa-2x"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } } else{ ?>
                                    <tr>
                                        <td colspan="5" class="text-danger text-center">Liste des régions vide</td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <?php
                                if(!empty($regions)){ ?>
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
<div class="modal fade" id="addVille" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title" id="introVille">Enregistrer une ville</h2>
            </div>
            <form action="<?= App::url('regions/save') ?>" id="form-Ville" method="post">
                <div class="modal-body">
                    <input type="hidden" id="idVille">
                    <input type="hidden" id="action">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="control-label">Pays <b>*</b></label>
                            <select id="idPays" class="form-control">
                                <option value="">.......</option>
                                <?php foreach ($pays as $pay) {
                                    echo '<option value="'.$pay->id.'">'.$pay->intitule.'</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nom région <b>*</b></label>
                                <input type="text" id="nameVille" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="confirmVille" class="newBtn btn btn-default">AJOUTER</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>