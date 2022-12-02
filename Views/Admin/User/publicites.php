<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\Marchand;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\Paginator;
use Projet\Model\StringHelper;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Les slides publicitaires");
App::setNavigation("Les slides publicitaires");
App::setBreadcumb('<li class="active">Slides publicitaires</li>');
App::addScript('assets/js/publicite.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Slides publicitaires <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" id="new" data-original-title="Nouveau Slide publicitaire">
                        <i class="icon-plus text-success fa-2x"></i>
                    </a>
                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('commandes') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="">Image</th>
                                <th class="">Nom</th>
                                <th class="">Marchand</th>
                                <th class="text-right">Priorité</th>
                                <th class="">Ajouté</th>
                                <th class="text-center">#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(!empty($publicites)){
                                foreach ($publicites as $publicite) {
                                    $nomMarchand = '<i class="text-info">AfrikFid</i>';
                                    if(!empty($publicite->idMarchand))
                                        $nomMarchand = Marchand::find($publicite->idMarchand)->nom;
                                    echo
                                        '
                                            <tr>
                                                <td class=""><img src="'.FileHelper::url($publicite->path).'" style="width: 100px;height: 70px;" class="imgSlide" alt="Img"></td>
                                                <td class="">'.StringHelper::isEmpty($publicite->nom).'</td>
                                                <td class="">'.$nomMarchand.'</td>
                                                <td class="text-right">'.thousand($publicite->priorite).'</td>
                                                <td class="">'.DateParser::relativeTime($publicite->created_at).'</td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0);" class="trash text-danger"
                                                   data-url="'.App::url('publicite/delete').'"
                                                   data-id="'.$publicite->id.'"><i class="fa fa-trash fa-2x"></i></a>
                                                </td>
                                            </tr>
                                            ';
                                }}else{
                                echo '<tr><td colspan="6" class="text-danger text-center">Liste des publicités vide ...</td></tr>';
                            }
                            ?>
                            </tbody>
                            <?php
                            if(!empty($publicites)){ ?>
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
<div class="modal fade newModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">NOUVEAU SLIDE PUBLICITAIRE</h2>
            </div>
            <form action="<?= App::url('publicite/save') ?>" id="newForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="priorite">Priorité <b>*</b></label>
                            <select name="priorite" id="priorite" class="form-control">
                                <option value="">............</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="idMarchand">Marchand</label>
                            <select name="idMarchand" id="idMarchand" class="form-control">
                                <option value="">............</option>
                                <?php
                                foreach ($marchands as $marchand) {
                                    echo '<option value="'.$marchand->id.'">'.$marchand->nom.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="name">Nom</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nom">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="photoImage">Image (1500*500 pixels) <b>*</b></label>
                            <input type="file" class="form-control" id="photoImage" accept="image/*" name="image">
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