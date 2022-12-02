<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\Article;
use Projet\Database\Categorie;
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
App::setTitle("Les types de cartes de fidelité");
App::setNavigation("Les types de cartes de fidelité");
App::setBreadcumb('<li class="active">Cartes de fidelité</li>');
App::addScript('assets/js/carte.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Types de Cartes de fidelité <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" class="new" data-original-title="Nouveau type carte de fidelité">
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
                                    <th class="text-center">Image</th>
                                    <th class="">Nom</th>
                                    <th class="text-right">% réd</th>
                                    <th class="text-right">$ Comm</th>
                                    <th class="text-right">Coût <small>(XOF)</small></th>
                                    <th class="text-right">Min Achats <small>(XOF)</small></th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!empty($cartes)){
                                    foreach ($cartes as $carte) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><img src="<?= FileHelper::url($carte->image) ?>" style="height: 50px;width: 70px" alt="Img"></td>
                                            <td class=""><b><?= $carte->nom.' <small>('.$carte->code.')</small>'; ?></b></td>
                                            <td class="text-right"><b><?= thousand($carte->pourcentage) ?>%</b></td>
                                            <td class="text-right"><b><?= float_value($carte->commission) ?>%</b></td>
                                            <td class="text-right"><b><?= thousand($carte->prix) ?></b></td>
                                            <td class="text-right"><b><?= thousand($carte->minimum) ?></b></td>
                                            <td class="text-center">

                                                <a href="javascript:void(0);" class="edit text-success"
                                                   data-nom="<?= $carte->nom; ?>" data-minimum="<?= $carte->minimum; ?>"
                                                   data-commission="<?= $carte->commission; ?>" data-id="<?= $carte->id; ?>" data-pourcentage="<?= $carte->pourcentage; ?>"
                                                   data-details="<?= $carte->details; ?>" data-code="<?= $carte->code; ?>" data-prix="<?= $carte->prix; ?>">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>&nbsp
                                                <a href="javascript:void(0);" class="editPhoto text-warning"
                                                   data-id="<?= $carte->id; ?>">
                                                    <i class="fa fa-image fa-2x"></i>
                                                </a>&nbsp
                                                <a href="javascript:void(0);" class="delete text-danger"
                                                   data-url="<?= App::url('cartes/delete'); ?>"
                                                   data-id="<?= $carte->id; ?>"><i class="fa fa-trash fa-2x"></i></a>

                                            </td>
                                        </tr>
                                    <?php } } else{ ?>
                                    <tr>
                                        <td colspan="7" class="text-danger text-center">Liste des types de cartes de fidelité vide</td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <?php
                                if(!empty($cartes)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="7">
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
<div class="modal fade newModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titleForm"></h2>
            </div>
            <form action="<?= App::url('cartes/add') ?>" id="newForm" method="post">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="action" name="action">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="nom">Nom de la carte</label>
                            <input type="text" id="nom" name="nom" class="form-control">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="code">Code de la carte</label>
                            <input type="text" id="code" name="code" class="form-control">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="pourcentage">Pourcentage de réduction</label>
                            <input type="number" id="pourcentage" name="pourcentage" class="form-control">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="commission">Commission AfrikFid</label>
                            <input type="text" id="commission" name="commission" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label class="prix">Coût de la carte</label>
                            <input type="number" id="prix" name="prix" class="form-control">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="minimum">Valeur min de paiement</label>
                            <input type="number" id="minimum" name="minimum" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <label class="details">Détail</label>
                            <textarea name="details" id="details" class="form-control" rows="1"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="newBtn btn btn-default">AJOUTER</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade photoModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">MODIFIER L'IMAGE</h2>
            </div>
            <form action="<?= App::url('cartes/setImage') ?>" id="photoForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="idPhoto" name="idPhoto">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="photoImage">Image <b>*</b></label>
                            <input type="file" class="form-control" multiple id="photoImage" accept="image/*" name="image">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="photoBtn btn btn-default">MODIFIER</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>