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
App::setTitle("Portfolio de $affilie->username");
App::setNavigation("Portfolio de $affilie->username");
App::addScript('https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js',true);
App::addScript('https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.js',true);
App::addScript('assets/js/projet.js',true);
App::setBreadcumb('<li><a href="javascript:void(0);" onclick="history.go(-1);return false;">Affiliés</a></li><li class="active">Portfolio</li>');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <?= "Portfolio de $affilie->username <small>(".thousand($nbre->Total).")</small>" ?>
                </h5>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip"class="panel-collapse" data-original-title="Reduire/Agrandir">
                        <i class="icon-arrow-down fa-2x"></i>
                    </a>
                    <a href="<?= App::url('affilies/portfolio?id='.$_GET['id']) ?>" data-toggle="tooltip" class="panel-reload" data-original-title="Rafraichir">
                        <i class="icon-reload fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-t-sm">
                    <div class="col-md-12">
                        <form action="<?= App::url('affilies/portfolio') ?>" method="get">
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['debut'])&&!empty($_GET['debut']))?'value="'.$_GET['debut'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par date min" name="debut" id="debut" placeholder="Chercher par date min">
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" class="form-control" <?= (isset($_GET['end'])&&!empty($_GET['end']))?'value="'.$_GET['end'].'"':''; ?>
                                           data-toggle="tooltip" data-original-title="Chercher par date max" name="end" id="end" placeholder="Chercher par date max">
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
                                    <th class="">Projet</th>
                                    <th class="">Description</th>
                                    <th class="">Date</th>
                                    <th class="">#</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($projects)){
                                    foreach ($projects as $project) {
                                        echo
                                            '
                                            <tr>
                                                <td class="">'.$project->project_name.'</td>
                                                <td class="">'.StringHelper::abbreviate($project->project_description,75).'</td>
                                                <td class="">'.DateParser::DateShort($project->date,1).'</td>
                                                <td><a href="javascript:void(0);" class="detail btn-link" data-url="'.App::url('affilies/portfolio/images').'" data-id="'.$project->id.'">Voir les images</a></td>
                                            </tr>
                                            ';
                                    }}else{
                                    echo '<tr><td colspan="4" class="text-danger text-center">Aucun projet trouvé...</td></tr>';
                                }
                                ?>
                                </tbody>
                                <?php
                                if(!empty($projects)){ ?>
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
<div class="modal fade messageModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 85%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">DETAIL PROJET</h2>
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