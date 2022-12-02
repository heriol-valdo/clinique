<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\Article;
use Projet\Database\Profil;
use Projet\Database\Vues;
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
App::setTitle("Les profils administrateurs");
App::setNavigation("Les profils administrateurs");
App::setBreadcumb('<li class="active">Profils administrateurs</li>');
App::addStyle('assets/css/multi-select.css',true);
App::addScript('assets/js/jquery.multi-select.js',true);
App::addScript('assets/js/profile.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Profils administrateurs <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" class="new" data-original-title="Nouveau profil administrateur">
                        <i class="icon-plus text-success fa-2x"></i>
                    </a>
                    <a href="javascript:void(0);" data-toggle="tooltip" class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('profiles') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('profiles') ?>" method="get">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['search'])&&!empty($_GET['search']))?'value="'.$_GET['search'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par nom" name="search" placeholder="Chercher par nom">
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
                                    <th class="">Nom</th>
                                    <th class="">Privilège</th>
                                    <th class="text-right">Nbre Admin</th>
                                    <th class="text-center">#</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($profiles)){
                                    foreach ($profiles as $profile) {
                                        $nbre = Profil::countBySearchType(null,null,null,null,null,null,null,$profile->id);
                                        echo
                                            '
                                            <tr>
                                                <td class="">'.$profile->nom.'</td>
                                                <td class="">'.Privilege::showPrivilege($profile->privilege).'</td>
                                                <td class="text-right">'.thousand($nbre->Total).'</td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            Actions <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="javascript:void(0);" data-id="'.$profile->id.'"
                                                                 data-nom="'.$profile->nom.'" data-privilege="'.$profile->privilege.'"
                                                                class="edit">Modifier</a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);" class="delete" 
                                                                data-url="'.App::url('profiles/delete').'" data-id="'.$profile->id.'">Supprimer</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            ';
                                    }}else{
                                    echo '<tr><td colspan="4" class="text-danger text-center">Liste des profils administrateurs vide ...</td></tr>';
                                }
                                ?>
                                </tbody>
                                <?php
                                if(!empty($profiles)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="4">
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
            <form action="<?= App::url('profiles/save') ?>" id="newForm" method="post">
                <div class="modal-body">
                    <input type="hidden" id="action">
                    <input type="hidden" id="idElement">
                    <p class="mainColor text-right">* Champs obligatoires</p>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="nom">Nom <b>*</b></label>
                            <input type="text" class="form-control" id="nom" placeholder="Nom">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="privileges">Privilèges <b>*</b></label>
                            <select multiple name="privilege" id="privileges" class="form-control">
                                <?= Privilege::getOptionsSelect(); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="newBtn btn btn-success">Ajouter</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
