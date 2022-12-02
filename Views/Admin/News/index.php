<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

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
App::setTitle("Les news");
App::setNavigation("Les news");
App::setBreadcumb('<li class="active">News</li>');
App::addStyle('assets/plugins/summernote-master/summernote.css',true);
App::addScript('assets/plugins/summernote-master/summernote.min.js',true);
App::addScript('assets/js/news.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    News <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" class="new" data-original-title="Nouvelle news">
                        <i class="icon-plus text-success fa-2x"></i>
                    </a>
                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('news') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('article') ?>" method="get">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['debut'])&&!empty($_GET['debut']))?'value="'.$_GET['debut'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par date ajout min" name="debut" id="debut" placeholder="Chercher par date ajout min">
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['end'])&&!empty($_GET['end']))?'value="'.$_GET['end'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par date ajout max" name="end" id="end" placeholder="Chercher par date ajout max">
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
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th class="">Image</th>
                                    <th class="">Titre</th>
                                    <th class="">Contenu</th>
                                    <th class="text-right">Vues</th>
                                    <th class="text-center">#</th>
                                    <th class="">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($news)){
                                    foreach ($news as $new) {
                                        echo
                                            '
                                            <tr>
                                                <td class=""><img src="'.FileHelper::url($new->image).'" class="img-l" alt="Img"></td>
                                                <td class="">'.StringHelper::abbreviate($new->titre,80).'</td>
                                                <td class="">'.StringHelper::abbreviate(strip_tags($new->contenu),250).'</td>
                                                <td class="text-right">'.thousand($new->vues).'</td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            Actions <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="javascript:void(0);" data-id="'.$new->id.'"
                                                                 data-nom="'.$new->titre.'"
                                                                class="edit">Modifier la news</a>
                                                                <div class="bibio hide">'.$new->contenu.'</div>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);" data-url="'.App::url('article/delete').'" 
                                                                class="trash" data-id="'.$new->id.'">Supprimer la news</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td class="text-right">'.DateParser::DateConviviale($new->created_at,1).'</td>
                                            </tr>
                                            ';
                                    }}else{
                                    echo '<tr><td colspan="6" class="text-danger text-center">Liste des news vide ...</td></tr>';
                                }
                                ?>
                                </tbody>
                                <?php
                                if(!empty($news)){ ?>
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
<div class="modal fade newModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title titleForm">Titre</h2>
            </div>
            <form action="<?= App::url('article/save') ?>" id="newForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="action" name="action">
                    <input type="hidden" id="idElement" name="id">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="nom">Titre <b>*</b></label>
                            <input type="text" class="form-control" name="nom" id="nom" placeholder="titre">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="detail">Contenu <b>*</b></label>
                            <textarea name="detail" id="contenu" placeholder="contenu" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row" id="pictureContent">
                        <div class="col-md-12 form-group">
                            <label for="photoImage">Image</label>
                            <input type="file" class="form-control" accept="image/*" id="photoImage" name="file">
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
<div class="modal fade photoModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">MODIFIER L'IMAGE DE LA NEWS</h2>
            </div>
            <form action="<?= App::url('article/change') ?>" id="photoForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="idPhoto" name="idPhoto">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="photoImage">Image</label>
                            <input type="file" class="form-control" accept="image/*" id="image" name="file">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="photoBtn btn btn-default">MISE A JOUR</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
