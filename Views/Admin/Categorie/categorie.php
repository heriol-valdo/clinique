<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\Article;
use Projet\Database\category;
use Projet\Database\products;
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
App::setTitle("Les sous catégories");
App::setNavigation("Les sous catégories");
App::setBreadcumb('<li class="active">Sous catégories</li>');
App::addScript('assets/js/category.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Sous catégories <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" id="ajouterVille" data-original-title="Nouvelle Sous catégorie">
                        <i class="icon-plus text-success fa-2x"></i>
                    </a>
                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('categories') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('categories') ?>" method="get">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <select class="form-control" name="categorie" data-toggle="tooltip" data-original-title="Chercher par la catégorie">
                                        <option value="">Chercher par la catégorie</option>
                                        <?php
                                        foreach ($categories as $category){
                                            $is = isset($_GET['categorie'])&&$_GET['categorie']==$category->id?' selected':'';
                                            echo '<option value="'.$category->id.'"'.$is.'>'.$category->category_name.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="search" <?= (isset($_GET['search'])&&!empty($_GET['search']))?'value="'.$_GET['search'].'"':''; ?> placeholder="Chercher par la sous catégorie ..." class="form-control" title="Chercher par le nom de le catégorie">
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
                                    <th class="">Catégorie</th>
                                    <th class="text-right">Nbre Produits</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody id="table-Villes">
                                <?php
                                if (!empty($sous)){
                                    foreach ($sous as $sou) {
                                        $cat = category::find($sou->category_id);
                                        $nbreArticle = products::countBySearchType(null,null,$sou->id);
                                        ?>
                                        <tr>
                                            <td class=""><?= ucfirst($sou->subcategory_name); ?></td>
                                            <td class=""><?= ucfirst($cat->category_name); ?></td>
                                            <td class="text-right"><a href="<?= App::url('produits?cat='.$sou->category_id.'&categorie='.$sou->id) ?>"><?= thousand($nbreArticle->Total) ?></a></td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" class="edit text-success"
                                                   data-name="<?= $sou->subcategory_name; ?>"
                                                   data-id="<?= $sou->id; ?>"
                                                   data-categorie="<?= $sou->category_id; ?>">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>&nbsp
                                                <a href="javascript:void(0);" class="editPhoto text-warning"
                                                   data-id="<?= $sou->id; ?>">
                                                    <i class="fa fa-image fa-2x"></i>
                                                </a>&nbsp
                                                <a href="javascript:void(0);" class="detailPhoto text-info"
                                                   data-url="<?= App::url('categories/detail'); ?>"
                                                   data-id="<?= $sou->id; ?>">
                                                    <i class="fa fa-info-circle fa-2x"></i>
                                                </a>&nbsp
                                                <a href="javascript:void(0);" class="trash text-danger"
                                                   data-url="<?= App::url('categories/delete'); ?>"
                                                   data-id="<?= $sou->id; ?>"><i class="fa fa-trash fa-2x"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } } else{ ?>
                                    <tr>
                                        <td colspan="4" class="text-danger text-center">Liste des sous catégories vide</td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <?php
                                if(!empty($sous)){ ?>
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
<div class="modal fade" id="addVille" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title" id="introVille">Enregistrer une ville</h2>
            </div>
            <form action="<?= App::url('categories/save') ?>" id="form-Ville" method="post">
                <div class="modal-body">
                    <input type="hidden" id="idVille">
                    <input type="hidden" id="action">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="control-label">Catégorie <b>*</b></label>
                            <select id="categorie" class="form-control" required>
                                <option value="">.......</option>
                                <?php foreach ($categories as $cat) {
                                    echo '<option value="'.$cat->id.'">'.$cat->category_name.'</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Intitulé <b>*</b></label>
                                <input type="text" id="nameVille" class="form-control" required>
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
<div class="modal fade photoModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">MODIFIER L'IMAGE</h2>
            </div>
            <form action="<?= App::url('categories/setImage') ?>" id="photoForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="idPhoto" name="idPhoto">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="photoImage">Images <b>*</b></label>
                            <input type="file" class="form-control" multiple id="photoImage" accept="image/*" name="file">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="photoBtn btn btn-default">ENREGISTRER</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade messageModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">DETAIL SOUS CATEGORIE</h2>
            </div>
            <div class="modal-body">
                <div class="loader">
                    <p class="text-center"><img class="img-xs" src="<?= FileHelper::url('assets/images/load.gif') ?>" alt=""></p>
                </div>
                <div class="contenus hide">

                </div>
            </div>
        </div>
    </div>
</div>