<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Database\Classe;
use Projet\Database\Classe_Eleve;
use Projet\Database\Cours;
use Projet\Database\Enseignant;
use Projet\Database\Paiement;
use Projet\Database\Scolarite;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\Encrypt;
use Projet\Model\FileHelper;
use Projet\Model\Paginator;
use Projet\Model\Privilege;
use Projet\Model\StringHelper;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
App::setTitle("Les suggestions");
App::setNavigation("Les suggestions");
App::setBreadcumb('<li class="active">Suggestions</li>');
App::addScript('assets/js/discussion.js',true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    Suggestions <small>(<?= thousand($nbre->Total); ?>)</small>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip"class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('suggestions') ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('suggestions') ?>" method="get">
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
                                    <th class="">Date</th>
                                    <th class="">Auteur</th>
                                    <th class="">Email</th>
                                    <th class="">Numéro</th>
                                    <th class="">Sujet</th>
                                    <th class="">Message</th>
                                    <th class="text-center">#</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($suggestions)){
                                    foreach ($suggestions as $suggestion) {
                                        echo
                                            '
                                            <tr>
                                               <td class="">'.DateParser::DateConviviale($suggestion->created_at,1).'</td>
                                               <td class="">'.$suggestion->nom.'</td>
                                               <td class="">'.StringHelper::isEmpty($suggestion->email,1).'</td>
                                               <td class="">'.thousand($suggestion->numero).'</td>
                                               <td class="">'.StringHelper::abbreviate($suggestion->sujet,50).'</td>
                                               <td class="">'.StringHelper::abbreviate($suggestion->message,75).'</td>
                                                <td class="text-center">
                                                <a href="javascript:void(0);" class="detail text-success"
                                                   data-url="'.App::url('suggestions/detail').'"
                                                   data-id="'.$suggestion->id.'"><i class="fa fa-info fa-2x"></i>
                                                </a>
                                            </td>
                                            </tr>
                                            ';
                                    }}else{
                                    echo '<tr><td colspan="7" class="text-danger text-center">Liste des suggestions vide ...</td></tr>';
                                }
                                ?>
                                </tbody>
                                <?php
                                if(!empty($suggestions)){ ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="7">
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
<div class="modal fade messageModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content black">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">DETAIL SUGGESTION</h2>
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