<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\Article;
use Projet\Database\Vues;
use Projet\Database\Worker;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\Paginator;
use Projet\Model\StringHelper;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Les lignes de commissions");
App::setNavigation("Les lignes de commissions");
App::setBreadcumb('<li class="active">Configuration des commissions</li>');
App::addScript('assets/js/tranche.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Configuration des commissions <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" class="new" data-original-title="Nouvelle ligne de commission">
                        <i class="icon-plus text-success fa-2x"></i>
                    </a>
                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
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
                                    <th class="text-center">Intervalle de prix <small>(XOF)</small></th>
                                    <th class="text-right">Commission <small>(XOF)</small></th>
                                    <th class="text-center">#</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($tranches)){
                                    foreach ($tranches as $tranche) {
                                        echo
                                            '
                                            <tr>
                                                <td class="text-center"><b>'.thousand($tranche->debut).' - '.thousand($tranche->fin).'</b></td>
                                                <td class="text-right"><b>'.thousand($tranche->cout).'</b></td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            Actions <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="javascript:void(0);" data-id="'.$tranche->id.'"
                                                                 data-debut="'.$tranche->debut.'" data-fin="'.$tranche->fin.'" data-cout="'.$tranche->cout.'"
                                                                class="edit">Modifier</a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);" class="delete" 
                                                                data-url="'.App::url('tranches/delete').'" data-id="'.$tranche->id.'">Supprimer</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            ';
                                    }}else{
                                    echo '<tr><td colspan="3" class="text-danger text-center">Liste des lignes de commissions vide ...</td></tr>';
                                }
                                ?>
                                </tbody>
                                <?php
                                if(!empty($tranches)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="3">
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
<div class="modal fade newModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titleForm">Titre</h2>
            </div>
            <form action="<?= App::url('tranches/save') ?>" id="newForm" method="post">
                <div class="modal-body">
                    <input type="hidden" id="action" name="action">
                    <input type="hidden" id="idElement" name="id">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="debuts">Entre <b>*</b></label>
                            <input type="number" class="form-control" id="debuts" name="debut" placeholder="Entre">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="fins">Et <b>*</b></label>
                            <input type="number" class="form-control" id="fins" name="fin" placeholder="Et">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="cout">Commission <b>*</b></label>
                            <input type="number" class="form-control" id="cout" name="cout" placeholder="Commission">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="newBtn btn btn-default">Ajouter</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>